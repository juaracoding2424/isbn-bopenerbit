<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    function detail(Request $request)
    {
        try{
            $sql = "SELECT p.id, p.name, alamat, nama_gedung, provinsi, city, kontak1, telp1, email1, fax1, 
                        kontak2, telp2, email2, fax2, kodepos, isbn_user_name, website, keterangan,
                        PROPINSI.NAMAPROPINSI,  KABUPATEN.NAMAKAB 
                        FROM PENERBIT P
                        LEFT JOIN PROPINSI on propinsi.id = P.PROVINCE_ID
                        LEFT JOIN KABUPATEN ON KABUPATEN.id = P.CITY_ID
                        WHERE JWT='" . $request->bearerToken() ."'";

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
