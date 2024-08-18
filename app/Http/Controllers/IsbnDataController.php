<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IsbnDataController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => $this->penerbit["NAME"]
        ];
        return view('isbn_data', $data);
    }
    public function datatable(Request $request)
    {
        $whereLike = [
            'ID',
            'ISBNNO',
            'TITLE',
            'KEPENG',
            'TAHUN_TERBIT',
            '',
            'MOHON_DATE',
            'VALIDATION_DATE',
            'RECEIVED_DATE_KCKR',
            'RECEIVED_DATE_PROV',
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        $order  = $whereLike[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $id = $this->penerbit['ID'];
        
        $start = $start;
        $end = $start + $length;

        $sql  = "SELECT pi.id, pt.title, pi.keterangan, pi.isbn_no, pi.prefix_element, pi.publisher_element, pi.item_element, pi.check_digit,
                    pt.kepeng, pt.author, pt.tahun_terbit, pi.received_date_kckr, pi.received_date_prov, 
                    pt.validation_date, pt.mohon_date, pt.validator_by FROM PENERBIT_ISBN pi 
                    JOIN PENERBIT_TERBITAN pt ON pt.ID = pi.PENERBIT_TERBITAN_ID WHERE pi.PENERBIT_ID='$id' AND (pt.status='diterima' OR pt.status is null)";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM PENERBIT_ISBN pi JOIN PENERBIT_TERBITAN pt ON pt.ID = pi.PENERBIT_TERBITAN_ID 
            WHERE pi.PENERBIT_ID='$id' AND (pt.status='diterima' or pt.status is null)";
       
        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'isbn'){
                    $sqlFiltered .= " AND pi.ISBN_NO like '%".$advSearch["value"]."%'";
                    $sql .= " AND pi.ISBN_NO like '%".$advSearch["value"]."%'";
                }
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
                "sql" => "SELECT count(*) JUMLAH FROM PENERBIT_ISBN WHERE PENERBIT_ID='$id' AND (status='diterima' OR status is null)"
            ])->json()["Data"]["Items"][0]["JUMLAH"];
        $totalFiltered = Http::get(config('app.inlis_api_url'), [
                "token" => config('app.inlis_api_token'),
                "op" => "getlistraw",
                "sql" => $sqlFiltered
            ])->json()["Data"]["Items"][0]['JUMLAH'];
        
        $response['data'] = [];
        if ($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $response['data'][] = [
                    $nomor,
                    $val['PREFIX_ELEMENT'] .'-' . $val['PUBLISHER_ELEMENT'] . '-' . $val['ITEM_ELEMENT'] . '-' . $val['CHECK_DIGIT'] ,
                    $val['TITLE'],
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['TAHUN_TERBIT'],
                    '<select class="form-select fs-7 select-costum" id="changeStatus_'.$val['ID'].'" onChange="changeStatus('.$val['ID'].')"><option value"">--Pilih status--</option><option value="belum terbit">Belum Terbit</option><option value="terbit">Sudah Terbit</option><option value="batal">Batal Terbit</option></select>', 
                    $val['MOHON_DATE'],
                    $val['VALIDATION_DATE'],
                    '<a class="badge badge-info h-30px m-1" onclick="cetakBarcode()">Barcode</a><a class="badge badge-primary h-30px m-1" onClick="cetakKDT()">KDT</a>',
                    $val['RECEIVED_DATE_KCKR'] ? $val['RECEIVED_DATE_KCKR'] : '<a class="badge badge-danger wrap" href="https://edeposit.perpusnas.go.id/login" target="_blank">Serahkan ke Perpusnas</a>',
                    $val['RECEIVED_DATE_PROV'] ? $val['RECEIVED_DATE_PROV'] : '<a class="badge badge-danger wrap" href="https://edeposit.perpusnas.go.id/login" target="_blank">Serahkan ke Provinsi</a>',
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
