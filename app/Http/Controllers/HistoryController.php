<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function data()
    {
        /*--AND h.NOTE LIKE 'Set status diterima'
          --AND h.NOTE LIKE 'Set status Set status bermasalah'
        */
        try{
            $sql = "SELECT * from historydata h 
                    JOIN penerbit_terbitan pt on pt.id = h.idref 
                    WHERE upper(h.tablename) = 'PENERBIT_TERBITAN'  
                    AND pt.penerbit_id = " . session('penerbit')['ID'] . " AND rownum <= 10";

            $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
            if(isset($data[0])){
                return response()->json($data);
            } else {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 500);
            }
        } catch(\Exception $e){
            return response()->json([
                "message" => "Server error. " . $e->getMessage()
            ], 500);
        }
    }
}
