<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChangePasswordController extends Controller
{
    function index()
    {
        return view('ubah_password');
    }

    function submit(Request $request)
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
                $encryptedPassword = urlencode(getMd5Hash($request->input('new_password')));
                $encryptedPasswordOld = urlencode(getMd5Hash($request->input('current_password')));
                $encryptedPassword2 = urlencode(rijndaelEncryptPassword($request->input('new_password')));
                $penerbit = session('penerbit');
                $id = session('penerbit')['ID'];
                if($penerbit['STATUS'] == 'valid') {
                    $old = Http::post(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". urlencode("SELECT * FROM PENERBIT WHERE ID='".$id."' AND ISBN_PASSWORD1='$encryptedPasswordOld'"))["Data"]["Items"];
                    if(isset($old[0])){
                        
                        $updated = [
                            ["name" => "ISBN_PASSWORD1", "Value"=> $encryptedPassword],
                            ["name" => "ISBN_PASSWORD", "Value"=> $encryptedPassword],
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
                } else {
                    $old = Http::post(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&op=getlistraw&sql=". urlencode("SELECT * FROM ISBN_REGISTRASI_PENERBIT WHERE ID='".$id."' AND PASSWORD='$encryptedPasswordOld'"))["Data"]["Items"];
                    if(isset($old[0])){
                        $updated = [
                            ["name" => "PASSWORD", "Value"=> $encryptedPassword],
                            ["name" => "PASSWORD2", "Value"=> $encryptedPassword2],
                        ];
                        $old = Http::post(config('app.inlis_api_url') ."?token=". config('app.inlis_api_token') ."&issavehistory=1&id=$id&op=update&table=ISBN_REGISTRASI_PENERBIT&ListUpdateItem=". urlencode(json_encode($updated)));
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
            }
        } else {
            return response()->json([
                    'status' => 'Failed',
                    'message' => "Session habis. Mohon refresh halaman ini.",
            ], 500);
        }
    }
}
