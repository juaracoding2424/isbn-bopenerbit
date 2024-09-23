<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
        ];
        return view('history', $data);
    }
    public function data()
    {
        try{
            $sql = "SELECT * FROM (SELECT h.actiondate, h.note, pt.title, pi.isbn_no, ir.noresi, h.tablename from historydata h 
                    JOIN penerbit_terbitan pt on pt.id = h.idref 
                    LEFT JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id
                    JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id
                    WHERE upper(h.tablename) = 'PENERBIT_TERBITAN'  
                    AND pt.penerbit_id = " . session('penerbit')['ID'] . " order by actiondate desc) WHERE rownum <= 10";
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

    public function datatable(Request $request)
    {
        $whereLike = [
            'ID',
            'ACTIONDATE',
            'ACTIONBY',
            'NOTE',
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        $order  = $whereLike[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $id = session('penerbit')['ID'];
        
        $end = $start + $length;

        $sql  = "SELECT *
                    FROM HISTORYDATA h  WHERE actionby = '".session('penerbit')['USERNAME']."' OR actionby = '".session('penerbit')['USERNAME']."-api' 
                    ORDER BY ACTIONDATE DESC";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM HISTORYDATA WHERE actionby = '".session('penerbit')['USERNAME']."' OR actionby = '".session('penerbit')['USERNAME']."-api' ";

        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM HISTORYDATA WHERE actionby = '".session('penerbit')['USERNAME']."' OR actionby = '".session('penerbit')['USERNAME']."-api'", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $totalFiltered = kurl("get","getlistraw", "", $sqlFiltered, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $link = 'http://demo321.online/ISBN_Back_Office/';
                $note = str_replace("href='", "href='".$link, $val['NOTE']);
                $response['data'][] = [
                    $nomor,
                    $val['ACTIONDATE'],
                    $val['ACTIONBY'],
                    $note, 
                ];
                $nomor++;
            }
        }

        $response['recordsTotal'] = 0;
        if ($totalData <> FALSE) {
            $response['recordsTotal'] = $totalData;
        }

        $response['recordsFiltered'] = 0;
        if ($totalFiltered <> FALSE) {
            $response['recordsFiltered'] = $totalFiltered;
        }

        return response()->json($response);
    }
}
