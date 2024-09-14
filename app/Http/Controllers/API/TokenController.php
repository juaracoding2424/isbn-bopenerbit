<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

class TokenController extends Controller
{
    function getToken(Request $request)
    {
        //\Log::info($request->header('x-api-key'));
        //\Log::info($request->json()->all());
        $data = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT WHERE X_API_KEY='".$request->input('x-api-key')."'", 'sql', '')["Data"]["Items"];
        
        //\Log::info($data);

        if(isset($data[0]["NAME"])){
            $token = Str::random(60);
            $expired_at = Date('Y-m-d H:i:s', strtotime(config('app.expires')));
            $send_data = [
                ["name"=> "JWT", "Value" => $token],
                ["name" =>"JWT_EXPIRED", "Value" => $expired_at]
            ];
            $params = [
                "issavehistory" => 0,
                "id" => $data[0]["ID"]
            ];
            $res = kurl('post','update', 'PENERBIT', $send_data, 'ListUpdateItem', $params);
            if($res["Status"] == "Success"){
                return response()->json([
                "token" => $token,
                "expired_at" => $expired_at
                ], 200);
            } else {
                return response()->json([
                    'status' => "Failed",
                    'message' => $res["Message"]
                ], 500);
            }
        } else {
            return response()->json([
                'message' => "Application Key tidak ditemukan",
                'status' => "Failed"
            ], 401);
        }
    }
}
