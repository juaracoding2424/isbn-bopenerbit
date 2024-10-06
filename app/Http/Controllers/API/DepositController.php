<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DepositController extends Controller
{
    function receivedPerpusnas(Request $request)
    {
        $token = $request->input('token');
        $isbn = str_replace("-", "",$request->input('isbn'));
        $date = $request->input('datetime');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        $validator = \Validator::make($request->all(), [
            'datetime'        => 'date_format:Y-m-d H:i:s',
        ], [
            'datetime.date_format' => 'Format tanggal dan waktu tidak sesuai. Format yang benar adalah Y-m-d H:i:s. Contoh: 2024-07-27 17:18:09'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                'err' => $validator->errors(),
            ], 422);
        } 
        //CHECK DATA ISBN
        $data = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT_ISBN pi LEFT JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id WHERE ISBN_NO='$isbn'"));
        if(!isset($data['Data']["Items"][0])){ //data isbn tidak ditemukan
            return response()->json([
                    'status' => 'Failed',
                    'message' => 'ISBN ' . $isbn . ' not found!',
            ], 200);
        } 
        $id = $data['Data']["Items"][0]['ID']; //penerbit_isbn 
        $id2 = $data['Data']["Items"][0]['ID1']; //penerbit_terbitan_id
        //UPDATE KE TABEL PENERBIT_ISBN
        $ListData = [
            ["name" => "RECEIVED_DATE_KCKR", "Value" => $request->input('datetime')]
        ];
        $res = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=PENERBIT_ISBN&issavehistory=1&id=$id&ListUpdateItem=" . urlencode(json_encode($ListData)));
        
        //INSERT HISTORY PENERBIT TERBITAN
        $history = [
            [ "name" => "TABLENAME", "Value"=> "PENERBIT_TERBITAN"],
            [ "name" => "IDREF", "Value"=> $id2],
            [ "name" => "ACTION" , "Value"=> "Edit"],
            [ "name" => "ACTIONDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
            [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
            [ "name" => "ACTIONBY", "Value"=> "deposit-api"],
            [ "name" => "NOTE", "Value"=> "Tandai diterima perpusnas <br/>ISBN : " . $isbn . "<br/>Tanggal penerimaan : " . $request->input('datetime')],
        ];
        $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
    }

    function receivedProvinsi(Request $request)
    {
        $token = $request->input('token');
        $isbn = str_replace("-", "",$request->input('isbn'));
        $date = $request->input('datetime');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        $validator = \Validator::make($request->all(), [
            'datetime'        => 'date_format:Y-m-d H:i:s',
        ], [
            'datetime.date_format' => 'Format tanggal dan waktu tidak sesuai. Format yang benar adalah Y-m-d H:i:s. Contoh: 2024-07-27 17:18:09'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                'err' => $validator->errors(),
            ], 422);
        } 
        //CHECK DATA ISBN
        $data = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT_ISBN pi LEFT JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id WHERE ISBN_NO='$isbn'"));
        if(!isset($data['Data']["Items"][0])){ //data isbn tidak ditemukan
            return response()->json([
                    'status' => 'Failed',
                    'message' => 'ISBN ' . $isbn . ' not found!',
            ], 200);
        } 
        $id = $data['Data']["Items"][0]['ID']; //penerbit_isbn 
        $id2 = $data['Data']["Items"][0]['ID1']; //penerbit_terbitan_id
        //UPDATE KE TABEL PENERBIT_ISBN
        $ListData = [
            ["name" => "RECEIVED_DATE_PROV", "Value" => $request->input('datetime')]
        ];
        $res = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=PENERBIT_ISBN&issavehistory=1&id=$id&ListUpdateItem=" . urlencode(json_encode($ListData)));
        
        //INSERT HISTORY PENERBIT TERBITAN
        $history = [
            [ "name" => "TABLENAME", "Value"=> "PENERBIT_TERBITAN"],
            [ "name" => "IDREF", "Value"=> $id2],
            [ "name" => "ACTION" , "Value"=> "Edit"],
            [ "name" => "ACTIONDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
            [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
            [ "name" => "ACTIONBY", "Value"=> "deposit-api"],
            [ "name" => "NOTE", "Value"=> "Tandai diterima provinsi <br/>ISBN : " . $isbn . "<br/>Tanggal penerimaan : " . $request->input('datetime')],
        ];
        $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
    }

    function getIsbn(Request $request)
    {
        $isbn = str_replace("-", "",$request->input('isbn'));
        $token = $request->input('token');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        if($isbn == "") {
            return response()->json([
                'status' => 'Failed',
                'message' => 'ISBN is required',
            ], 500);
        }
        
        $penerbit = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT_ISBN pi LEFT JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id WHERE ISBN_NO='$isbn'"));

        if(isset($penerbit['Data']["Items"][0])){
            return response()->json([
                    'status' => 'Success',
                    'data' => $penerbit['Data']["Items"][0],
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'ISBN ' . $isbn . ' not found!',
            ], 500);
        }
    }
}
