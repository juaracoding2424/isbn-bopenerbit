<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IsbnMasalahController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => $this->penerbit["NAME"]
        ];
        return view('isbn_bermasalah', $data);
    }
    public function datatable(Request $request)
    {
        $whereLike = [
            'ID',
            'TITLE',
            'KEPENG',
            'TAHUN_TERBIT',
            'MOHON_DATE',
            'ISI',
            ''
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        $order  = $whereLike[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $id = $this->penerbit['ID'];
        
        $start = $start;
        $end = $start + $length;

        $sql  = "SELECT pt.id, m.isi, m.createdate, pt.title, pt.kepeng, pt.author, pt.tahun_terbit, pt.mohon_date
                    FROM PENERBIT_ISBN_MASALAH m JOIN PENERBIT_TERBITAN pt
                    ON m.PENERBIT_TERBITAN_ID = pt.ID 
                    WHERE m.IS_SOLVE = 0 AND pt.PENERBIT_ID='$id' AND pt.status='pending'";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM PENERBIT_ISBN_MASALAH m JOIN PENERBIT_TERBITAN pt
                    ON m.PENERBIT_TERBITAN_ID = pt.ID 
                    WHERE m.IS_SOLVE = 0 AND pt.PENERBIT_ID='$id' AND pt.status='pending'";

        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'title'){
                    $sqlFiltered .= " AND lower(pt.TITLE) like '%".strtolower($advSearch["value"])."%'";
                    $sql .= " AND lower(pt.TITLE) like '%".strtolower($advSearch["value"])."%'";
                }
                if($advSearch["param"] == 'tahun_terbit'){
                    $sqlFiltered .= " AND pt.TAHUN_TERBIT like '%".$advSearch["value"]."%'";
                    $sql .= " AND pt.TAHUN_TERBIT like '%".$advSearch["value"]."%'";
                }
                if($advSearch["param"] == 'kepeng'){
                    $sqlFiltered .= " AND (lower(pt.kepeng) like '%".strtolower($advSearch["value"])."%' OR lower(pt.author) like '%".strtolower($advSearch["value"])."%') ";
                    $sql .= " AND (lower(pt.kepeng) like '%".strtolower($advSearch["value"])."%' OR lower(pt.author) like '%".strtolower($advSearch["value"])."%') ";
                }
                if($advSearch["param"] == 'masalah'){
                    $sqlFiltered .= " AND lower(m.isi) like '%".strtolower($advSearch["value"])."%'";
                    $sql .= " AND lower(m.isi) like '%".strtolower($advSearch["value"])."%'";
                }
            }
        }
        $queryData = Http::get(config('app.inlis_api_url'), [
                "token" => config('app.inlis_api_token'),
                "op" => "getlistraw",
                "sql" => "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end"
            ])->json()["Data"]["Items"];

        $totalData = Http::get(config('app.inlis_api_url'), [
                "token" => config('app.inlis_api_token'),
                "op" => "getlistraw",
                "sql" => "SELECT count(*) JUMLAH FROM PENERBIT_TERBITAN WHERE PENERBIT_ID='$id' AND status='pending'"
            ])->json()["Data"]["Items"][0]["JUMLAH"];

        $totalFiltered = Http::get(config('app.inlis_api_url'), [
                "token" => config('app.inlis_api_token'),
                "op" => "getlistraw",
                "sql" => $sqlFiltered
            ])->json()["Data"]["Items"][0]['JUMLAH'];
        
        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $id = $val['ID'];
                $response['data'][] = [
                    $nomor,
                    $val['TITLE'],
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['TAHUN_TERBIT'],
                    $val['MOHON_DATE'],
                    $val['ISI'],
                    '<a class="badge badge-primary h-30px m-1" onClick="perbaikiPermohonan('.$id.')">Perbaiki permohonan</a><a class="badge badge-danger h-30px m-1" onclick="batalkanPermohonan('.$id.')">Batalkan Permohonan</a>',
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
