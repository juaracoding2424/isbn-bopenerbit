<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IsbnPermohonanController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => $this->penerbit["NAME"]
        ];
        return view('isbn_permohonan', $data);
    }
    public function datatable(Request $request)
    {
        $whereLike = [
            'ID',
            'TITLE',
            'KEPENG',
            'TAHUN_TERBIT',
            'MOHON_DATE',
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

        $sql  = "SELECT *
                    FROM PENERBIT_TERBITAN pt
                    WHERE pt.PENERBIT_ID='$id' AND pt.status='permohonan'";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM PENERBIT_TERBITAN WHERE PENERBIT_ID='$id' AND status='permohonan'";

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
                "sql" => "SELECT count(*) JUMLAH FROM PENERBIT_TERBITAN WHERE PENERBIT_ID='$id' AND status='permohonan'"
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
                    '<a class="badge badge-info h-30px m-1" href="tambah_isbn.php">Ubah Data</a><a class="badge badge-danger h-30px m-1" href="#" onclick="batalkanPermohonan('.$id.')">Batalkan Permohonan</a>',
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

    public function new()
    {
        $data = [
            'nama_penerbit' => $this->penerbit["NAME"]
        ];
        return view('tambah_isbn');
    }
}
