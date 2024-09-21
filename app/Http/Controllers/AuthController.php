<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Str;

class AuthController extends Controller
{
    public function login()
    {
        if (session('penerbit') == null) {
            return view('sign-in');
        } else {
            return redirect('penerbit/dashboard');
        }
    }

    public function submit(Request $request)
    {
        if (session('penerbit')) {
            return redirect('penerbit/dashboard');
        } else {
            $validator = \Validator::make(request()->all(), [
                'username' => 'required',
                'password' => 'required',
            ], [
                'username.required' => 'Username wajib diisi',
                'password.required' => 'Password wajib diisi',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Gagal Login!',
                    'err' => $validator->errors(),
                ], 422);
            } else {
                $ip = $request->ip();
                //encript password
                $encryptedPassword = urlencode(getMd5Hash($request->input('password')));
                $encryptedPassword2 = urlencode(rijndaelEncryptPassword($request->input('password')));
                //\Log::info(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". "SELECT * FROM PENERBIT WHERE ISBN_USER_NAME='" . $request->input('username'). "' AND (ISBN_PASSWORD1='$encryptedPassword' OR ISBN_PASSWORD2='$encryptedPassword2' OR ISBN_PASSWORD='$encryptedPassword')");
                $penerbit = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT WHERE ISBN_USER_NAME='" . $request->input('username') . "' AND (ISBN_PASSWORD1='$encryptedPassword' OR ISBN_PASSWORD2='$encryptedPassword2' OR ISBN_PASSWORD='$encryptedPassword')"));
                if (isset($penerbit["Data"]['Items'][0])) {
                    $penerbit = $penerbit["Data"]['Items'][0];
                    //\Log::info($penerbit);
                    session([
                        'penerbit' => [
                            'STATUS' => 'valid',
                            'ID' => $penerbit['ID'],
                            'USERNAME' => $penerbit['ISBN_USER_NAME'],
                            'EMAIL' => $penerbit['EMAIL1'],
                            'NAME' => $penerbit['NAME'],
                            'PROVINCE_ID' => $penerbit['PROVINCE_ID'],
                            'CITY_ID' => $penerbit['CITY_ID'],
                            'DISTRICT_ID' => $penerbit['DISTRICT_ID'],
                            'VILLAGE_ID' => $penerbit['VILLAGE_ID'],
                        ]]);
                    return response()->json([
                        'penerbitstatus' => 'valid',
                        'status' => 'Success',
                    ], 200);
                } else {
                    //cari di tabel registrasi isbn
                    $penerbit_belum_verifikasi = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM ISBN_REGISTRASI_PENERBIT WHERE USER_NAME='" . $request->input('username') . "' AND (PASSWORD='$encryptedPassword' OR PASSWORD2='$encryptedPassword2')"));
                    if (isset($penerbit_belum_verifikasi["Data"]['Items'][0])) {
                        $penerbit_belum_verifikasi = $penerbit_belum_verifikasi["Data"]['Items'][0];
                        //\Log::info($penerbit_belum_verifikasi);
                        session([
                            'penerbit' => [
                                'STATUS' => 'notvalid',
                                'ID' => $penerbit_belum_verifikasi['ID'],
                                'USERNAME' => $penerbit_belum_verifikasi['USER_NAME'],
                                'EMAIL' => $penerbit_belum_verifikasi['ADMIN_EMAIL'],
                                'NAME' => $penerbit_belum_verifikasi['NAMA_PENERBIT'],
                                'PROVINCE_ID' => $penerbit_belum_verifikasi['PROVINCE_ID'],
                                'CITY_ID' => $penerbit_belum_verifikasi['CITY_ID'],
                                'DISTRICT_ID' => $penerbit_belum_verifikasi['DISTRICT_ID'],
                                'VILLAGE_ID' => $penerbit_belum_verifikasi['VILLAGE_ID'],
                            ]]);
                        return response()->json([
                            'penerbitstatus' => 'notvalid',
                            'status' => 'Success',
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 'Failed',
                            'message' => 'Username atau password salah!',
                        ], 500);
                    }
                }
            }
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect('login');
    }

    public function resetPassword()
    {
        if (session('penerbit') == null) {
            return view('reset-password');
        } else {
            return redirect('penerbit/dashboard');
        }
    }

    public function resetPasswordSend()
    {
        $email = request('email');
        $queryData = kurl("get", "getlistraw", "", "SELECT * FROM PENERBIT WHERE EMAIL1='$email' OR EMAIL2 = '$email'", 'sql', '')["Data"]["Items"];
        if (!isset($queryData[0])) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Email not found!',
            ], 422);
        } else {
            $id = $queryData[0]['ID'];
            $resetToken = Str::random(60);
            $expired_at = Date('Y-m-d H:i:s', strtotime('+1 days'));
            $ListToUpdate = [
                ["name" => 'RESET_TOKEN', "Value" => $resetToken],
                ["name" => 'RESET_EXPIRED', "Value" => $expired_at],
            ];
            Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=PENERBIT&id=$id&ListUpdateItem=" . urlencode(json_encode($ListToUpdate)));
            //INSERT HISTORY
            $history = [
                ["name" => "TABLENAME", "Value" => "PENERBIT"],
                ["name" => "IDREF", "Value" => $id],
                ["name" => "ACTION", "Value" => "Update"],
                ["name" => "ACTIONBY", "Value" => $queryData[0]["ISBN_USER_NAME"]],
                ["name" => "ACTIONDATE", "Value" => now()->format('Y-m-d H:i:s')],
                ["name" => "ACTIONTERMINAL", "Value" => \Request::ip()],
                ["name" => "NOTE", "Value" => "Permintaan reset password"],
            ];
            Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
            $params = [
                ["name" => "NamaPenerbit", "Value" => $queryData[0]['NAME']],
                ["name" => "AlamatEmailPenerbit", "Value" => $email],
                ["name" => "TautanResetPassword", "Value" => "<a href='" . url("/reset-password-next?reset-token=$resetToken") . "' style='color: #fff !important;
                    border-color:  #1b84ff !important;  background-color:  #1b84ff !important;padding: 10px; border-radius: 5px;'>LINK RESET PASSWORD</a>", ],
                ["name" => "EmailDukungan", "Value" => "isbn@mail.perpusnas.go.id"],
            ];
            $res = sendMail(2, $params, $email, 'PERMOHONAN RESET PASSWORD [#' . date('Y-m-d H:i:s') . ']');

            return response()->json([
                'status' => 'Success',
                'token' => $resetToken,
            ], status: 200);
        }
    }

    public function resetPasswordNext()
    {
        if (request('reset-token')) {
            $token = request('reset-token');
            $queryData = kurl("get", "getlistraw", "", "SELECT * FROM PENERBIT WHERE RESET_TOKEN='$token'", 'sql', '')["Data"]["Items"];
            if (!isset($queryData[0])) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Reset password link not found.',
                ], 500);
            } else {
                if ((strtotime(date('Y-m-d H:i:s')) > strtotime($queryData[0]["RESET_EXPIRED"]))) {
                    return response()->json([
                        'message' => 'Your reset password link has expired.',
                        'status' => 'Failed',
                    ], 401);
                }
            }

            return view('reset-password-next', ['resetToken' => $token]);
        } else {

            return response()->json([
                'message' => 'Your reset password link is invalid.',
                'status' => 'Failed',
            ], 500);
        }
    }

    public function resetPasswordNextSubmit(Request $request)
    {
        $token = $request->input('reset-token');
        $queryData = kurl("get", "getlistraw", "", "SELECT * FROM PENERBIT WHERE RESET_TOKEN='$token'", 'sql', '')["Data"]["Items"];

        if (!isset($queryData[0])) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Reset password link not found.',
            ], 500);
        } else {
            if ((strtotime(date('Y-m-d H:i:s')) > strtotime($queryData[0]["RESET_EXPIRED"]))) {
                return response()->json([
                    'message' => 'Your reset password link has expired.',
                    'status' => 'Failed',
                ], 401);
            }
            $id = $queryData[0]['ID'];
            $encryptedPassword = urlencode(getMd5Hash($request->input('password')));
            $encryptedPassword2 = urlencode(rijndaelEncryptPassword($request->input('password')));
            //UPDATE TABEL PENERBIT
            $updated = [
                ["name" => "ISBN_PASSWORD1", "Value" => $encryptedPassword],
                ["name" => "ISBN_PASSWORD", "Value" => $encryptedPassword],
                ["name" => "ISBN_PASSWORD2", "Value" => $encryptedPassword2],
            ];
            Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&id=$id&op=update&table=PENERBIT&ListUpdateItem=" . urlencode(json_encode($updated)));

            //INSERT HISTORY
            $history = [
                ["name" => "TABLENAME", "Value" => "PENERBIT"],
                ["name" => "IDREF", "Value" => $id],
                ["name" => "ACTION", "Value" => "Update"],
                ["name" => "ACTIONBY", "Value" => $queryData[0]["ISBN_USER_NAME"]],
                ["name" => "ACTIONDATE", "Value" => now()->format('Y-m-d H:i:s')],
                ["name" => "ACTIONTERMINAL", "Value" => \Request::ip()],
                ["name" => "NOTE", "Value" => "Reset password sukses"],
            ];
            Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
            
            //KIRIM EMAIL
            $params = [
                ["name" => "NamaPenerbit", "Value" => $queryData[0]['NAME']],
                ["name" => "AlamatEmailPenerbit", "Value" => $queryData[0]['EMAIL1']],
                ["name" => "TautanLogin", "Value" => "<a href='" . url("/login") . "' style='color: #fff !important;
                    border-color:  #1b84ff !important;  background-color:  #1b84ff !important;padding: 10px; border-radius: 5px;'>LINK LOGIN</a>", ],
                ["name" => "EmailDukungan", "Value" => "isbn@mail.perpusnas.go.id"],
            ];
            sendMail(15, $params, $queryData[0]['EMAIL1'], 'Konfirmasi: Password Akun ISBN Anda Telah Berhasil Direset [#' . date('Y-m-d H:i:s') . ']');
            
            if($queryData[0]['EMAIL2'] != '' && ($queryData[0]['EMAIL2'] != $queryData[0]['EMAIL1'])){
                sendMail(15, $params, $queryData[0]['EMAIL2'], 'Konfirmasi: Password Akun ISBN Anda Telah Berhasil Direset [#' . date('Y-m-d H:i:s') . ']');
            }

            return response()->json([
                'status' => 'Success',
                'message' => 'Successfully reset the password.',
            ], 200);
        }
    }

}
