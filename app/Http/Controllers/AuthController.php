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
                $encryptedPassword = urlencode($this->getMd5Hash($request->input('password')));
                $encryptedPassword2 = urlencode($this->rijndaelEncryptPassword($request->input('password')));
                //\Log::info(config('app.inlis_api_url'). "?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". urlencode("SELECT * FROM PENERBIT WHERE ISBN_USER_NAME='" . $request->input('username') . "' AND ISBN_PASSWORD='$encryptedPassword'"));
                $penerbit = Http::post(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". urlencode("SELECT * FROM PENERBIT WHERE ISBN_USER_NAME='" . $request->input('username'). "' AND ISBN_PASSWORD1='$encryptedPassword'"));
                if(isset($penerbit["Data"]['Items'][0])){
                    $penerbit = $penerbit["Data"]['Items'][0];
                    //\Log::info($penerbit);
                    session([
                        'penerbit' => [
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

    function changePasswordIndex()
    {
        return view('ubah_password');
    }

    function changePasswordSubmit(Request $request)
    {
        if($request->has('_token')) {
            $validator = \Validator::make($request->all(), [
                'current_password'  => 'required',
                'new_password'      => 'required',
                'confirm_password'  => 'required|same:new_password'
            ], [
                'current_password.required' => 'Password lama wajib di isi!',
                'new_password.required'     => 'Password baru wajib di isi!',
                'confirm_password.required' => 'Konfirmasi password wajib di isi!',
                'confirm_password.same'     => 'Konfirmasi password tidak sama dengan password baru!'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => 'Failed',
                    'message'   => 'Gagal mengubah password. Cek kembali password yang Anda masukan!',
                    'err' => $validator->errors(),
                ], 422);
            }
            if($request->input('new_password') == $request->input('current_password')) {
                return response()->json([
                        'status' => 'Failed',
                        'message' => "Password baru tidak boleh sama dengan password lama!",
                ], 500);
            } else {
                $encryptedPassword = urlencode($this->getMd5Hash($request->input('new_password')));
                $encryptedPasswordOld = urlencode($this->getMd5Hash($request->input('current_password')));
                $encryptedPassword2 = urlencode($this->rijndaelEncryptPassword($request->input('new_password')));
                $old = Http::post(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". urlencode("SELECT * FROM PENERBIT WHERE ID='".session('penerbit')['ID']."' AND ISBN_PASSWORD1='$encryptedPasswordOld'"))["Data"]["Items"];
                if(isset($old[0])){
                    $id = session('penerbit')['ID'];
                    $updated = [
                        ["name" => "ISBN_PASSWORD1", "Value"=> $encryptedPassword],
                        ["name" => "ISBN_PASSWORD2", "Value"=> $encryptedPassword2],
                    ];
                    $old = Http::post(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&issavehistory=1&id=$id&op=update&table=PENERBIT&ListUpdateItem=". urlencode(json_encode($updated)));
                    if($old["Status"] == "Success") {
                        return response()->json([
                                'status' => 'Success',
                                'message' => 'Password sudah diganti menjadi : <b>' . $request->input('new_password') .'</b>',
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 'Failed',
                            'message' => $old["Message"],
                        ], 500);
                    }
                } else {
                    return response()->json([
                        'status' => 'Failed',
                        'message' => "Password lama salah!",
                    ], 500);
                }  
            }
        } else {
            return response()->json([
                    'status' => 'Failed',
                    'message' => "Session habis. Mohon refresh halaman ini.",
            ], 500);
        }
    }

    function logout()
    {
        session()->flush();
        return redirect('login'); 
    }
    function rijndaelEncryptPassword($password)
    {
        // Key Size: Ensure the key is 32 bytes long for AES-256.
        // IV Size: Ensure the IV is 16 bytes long for AES-256-CBC

        $key = 'isbn_2021$'; 
        $cipher = 'aes-256-cbc';
        $iv = random_bytes(16);

        $encrypted = openssl_encrypt($password, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        // Combine IV and encrypted data for storage
        return base64_encode($iv . $encrypted);
    }

    function rinjdaelEncryptedPasswordCheck($password)
    {
        // Key Size: The same key used for encryption
        $key = 'isbn_2021$'; 
        $cipher = 'aes-256-cbc';

        // Decode the base64-encoded encrypted data
        $decodedData = base64_decode($password);

        // Extract the IV (first 16 bytes) and the encrypted data
        $iv = substr($decodedData, 0, 16);
        $encryptedData = substr($decodedData, 16);

        // Decrypt the data using the same cipher, key, and IV
        $decrypted = openssl_decrypt($encryptedData, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        return $decrypted;
    }

    function getMd5Hash($input) {
        // Compute the MD5 hash
        $hash = md5($input, true); // true to get raw binary format
        // Convert the binary hash to hexadecimal representation
        $hexHash = bin2hex($hash);
        return $hexHash;
    }

    function checkPenerbit($input)
    {

    }
}
