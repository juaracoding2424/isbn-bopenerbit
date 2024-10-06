<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SSOController extends Controller
{
    function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $token = $request->input('token');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        if($username == "") {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Username is required',
            ], 500);
        }
        if($password == "") {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Password is required',
            ], 500);
        }
        $encryptedPassword = getMd5Hash(urldecode($password));
        $encryptedPassword2 = rijndaelEncryptPassword(urldecode($password)); 
        $penerbit = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT WHERE ISBN_USER_NAME='" . $username . "' AND (ISBN_PASSWORD1='$encryptedPassword' OR ISBN_PASSWORD2='$encryptedPassword2' OR ISBN_PASSWORD='$encryptedPassword')"));
        return response()->json([
                'status' => 'Success',
                'data' => $penerbit['Data']["Items"][0],
        ], 200);
    }
}
