<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    function login()
    {
        if(session('penerbit') == null) {
            return view('sign-in');
        } else {
            return redirect('penerbit/dashboard');
        }
    }

    function submit(Request $request)
    {
        if(session('penerbit')) {
            return redirect('penerbit/dashboard');
        } else {
            $validator = \Validator::make(request()->all(),[
                'username' => 'required',
                'password' => 'required',
                ],[
                    'username.required' => 'Username wajib diisi',
                    'password.required' => 'Password wajib diisi',
                ]);
            if($validator->fails()){
                    return response()->json([
                        'status' => 'Failed',
                        'message'   => 'Gagal Login!',
                        'err' => $validator->errors(),
                    ], 422);
            } else {
                $ip = $request->ip();  
                //encript password
                $encryptedPassword = urlencode(getMd5Hash($request->input('password')));
                $encryptedPassword2 = urlencode(rijndaelEncryptPassword($request->input('password')));
                //\Log::info(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". "SELECT * FROM PENERBIT WHERE ISBN_USER_NAME='" . $request->input('username'). "' AND (ISBN_PASSWORD1='$encryptedPassword' OR ISBN_PASSWORD2='$encryptedPassword2' OR ISBN_PASSWORD='$encryptedPassword')");
                $penerbit = Http::post(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". urlencode("SELECT * FROM PENERBIT WHERE ISBN_USER_NAME='" . $request->input('username'). "' AND (ISBN_PASSWORD1='$encryptedPassword' OR ISBN_PASSWORD2='$encryptedPassword2' OR ISBN_PASSWORD='$encryptedPassword')"));
                if(isset($penerbit["Data"]['Items'][0])){
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
                    $penerbit_belum_verifikasi = Http::post(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". urlencode("SELECT * FROM ISBN_REGISTRASI_PENERBIT WHERE USER_NAME='" . $request->input('username'). "' AND (PASSWORD='$encryptedPassword' OR PASSWORD2='$encryptedPassword2')"));
                    if(isset($penerbit_belum_verifikasi["Data"]['Items'][0])){
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
                            'message'   => 'Username atau password salah!',
                        ], 500);
                    }
                }
            }
        }
    }

    function logout()
    {
        session()->flush();
        return redirect('login'); 
    }



}
