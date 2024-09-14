<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    function detail(Request $request)
    {
        try{
            $sql = "SELECT id, name, alamat, nama_gedung, provinsi, city, kontak1, telp1,email1, fax1, 
                        kontak2, telp2, email2,fax2, kodepos, isbn_user_name, website, keterangan 
                        FROM PENERBIT WHERE JWT='" . $request->bearerToken() ."'";

            $penerbit = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
            if(isset($penerbit[0])){
                return response()->json($penerbit);
            } else {
                return response()->json([
                    'message' => 'Token yang anda masukan tidak valid. Data tidak ditemukan'
                ], 500);
            }
        } catch(\Exception $e){
            return response()->json([
                "message" => "Server error. " . $e->getMessage()
            ], 500);
        }
        
    }
}
