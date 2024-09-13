<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IsbnMasalahController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
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
        $id = session('penerbit')['ID'];
        
        $start = $start;
        $end = $start + $length;

        $sql  = "SELECT pt.id, m.isi, m.createdate, ir.noresi, pt.title, pt.kepeng, pt.author, pt.tahun_terbit, pt.mohon_date
                    FROM PENERBIT_ISBN_MASALAH m 
                    JOIN PENERBIT_TERBITAN pt ON m.PENERBIT_TERBITAN_ID = pt.ID 
                    JOIN ISBN_RESI ir on ir.id = m.isbn_resi_id
                    WHERE m.IS_SOLVE = 0 AND pt.PENERBIT_ID='$id' AND ir.status='pending'";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM PENERBIT_ISBN_MASALAH m 
                    JOIN ISBN_RESI ir ON m.isbn_resi_id = ir.ID 
                    JOIN PENERBIT_TERBITAN pt ON m.PENERBIT_TERBITAN_ID = pt.ID 
                    WHERE m.IS_SOLVE = 0 AND ir.PENERBIT_ID='$id' AND ir.status='pending'";

        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'title'){
                    $sqlFiltered .= " AND (CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%')";
                    $sql .= " AND (CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%')";
                }
                if($advSearch["param"] == 'tahun_terbit'){
                    $sqlFiltered .= " AND pt.TAHUN_TERBIT like '%".$advSearch["value"]."%'";
                    $sql .= " AND pt.TAHUN_TERBIT like '%".$advSearch["value"]."%'";
                }
                if($advSearch["param"] == 'kepeng'){
                    $sqlFiltered .= " AND (upper(pt.kepeng) like '%".strtoupper($advSearch["value"])."%' OR upper(pt.author) like '%".strtoupper($advSearch["value"])."%') ";
                    $sql .= " AND (upper(pt.kepeng) like '%".strtoupper($advSearch["value"])."%' OR upper(pt.author) like '%".strtoupper($advSearch["value"])."%') ";
                }
                if($advSearch["param"] == 'masalah'){
                    $sqlFiltered .= " AND upper(m.isi) like '%".strtoupper($advSearch["value"])."%'";
                    $sql .= " AND upper(m.isi) like '%".strtoupper($advSearch["value"])."%'";
                }
                if($advSearch["param"] == 'no_resi'){
                    $sqlFiltered .= " AND (CONCAT('WIN',upper(ir.noresi))) like 'WIN%".strtoupper($advSearch["value"])."%'";
                    $sql .= " AND (CONCAT('WIN',upper(ir.noresi))) like 'WIN%".strtoupper($advSearch["value"])."%'";
                }
            }
        }
        \Log::info("SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end");
        \Log::info($sqlFiltered);
        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM ISBN_RESI WHERE PENERBIT_ID='$id' AND status='pending'", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $totalFiltered = kurl("get","getlistraw", "", $sqlFiltered, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $id = $val['ID'];
                $noresi = $val['NORESI'] ? $val['NORESI'] : $val['ID'];
                $response['data'][] = [
                    $nomor,
                    '<a class="badge badge-primary h-30px m-1" href="/penerbit/isbn/permohonan/detail/'.$noresi.'" target="_self">Perbaiki permohonan</a><a class="badge badge-danger h-30px m-1" onclick="batalkanPermohonan('.$id.')">Batalkan Permohonan</a>',
                    $val['NORESI'],
                    $val['TITLE'],
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['TAHUN_TERBIT'],
                    $val['MOHON_DATE'],
                    $val['ISI'],        
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

    function detail($noresi)
    {
        $detail =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=SELECT * FROM PENERBIT_TERBITAN WHERE NORESI='$noresi'");
        if(!isset($detail["Data"]["Items"][0])) {
            $detail =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=SELECT * FROM PENERBIT_TERBITAN WHERE ID='$noresi'");
        }
        if(intval($detail["Data"]["Items"][0]["JML_JILID"]) > 1){
            $status = "jilid";
        } else {
            $status = "lepas";
        }        
        $data = [
            'status' => $status,
            'detail' => $detail["Data"]["Items"],
            'noresi' => $noresi,
        ];
        return view('edit_isbn', $data);
    }

    function getDetail($id)
    {
        $detail =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=SELECT * FROM PENERBIT_TERBITAN WHERE ID='$id'");
        if(intval($detail["Data"]["Items"][0]["JML_JILID"]) > 1){
            $status = "jilid";
        } else {
            $status = "lepas";
        }        
        $data = [
            'status' => $status,
            'detail' => $detail["Data"]["Items"][0],
        ];
        return response()->json($data);
    }
}
