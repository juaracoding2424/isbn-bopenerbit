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
        
        $end = $start + $length;

        $sql  = "SELECT pt.id, ir.noresi, pt.title, pt.kepeng, pt.author,pt.bulan_terbit, pt.tahun_terbit, 
                    pt.mohon_date, pt.jenis_media,  ir.id as IRID,
                    listagg(m.isi || '||' || m.createdate || '||' || m.is_solve || '||' || m.createby ,'¦') within group (order by m.createdate) masalah
                    FROM PENERBIT_ISBN_MASALAH m 
                    JOIN PENERBIT_TERBITAN pt ON m.PENERBIT_TERBITAN_ID = pt.ID 
                    LEFT JOIN ISBN_RESI ir on ir.id = m.isbn_resi_id
                    WHERE m.IS_SOLVE = 0 AND pt.PENERBIT_ID='$id' AND ir.status='pending'";
        $sqlFiltered = "SELECT count(pt.id) JUMLAH FROM PENERBIT_ISBN_MASALAH m 
                    LEFT JOIN ISBN_RESI ir ON m.isbn_resi_id = ir.ID 
                    JOIN PENERBIT_TERBITAN pt ON m.PENERBIT_TERBITAN_ID = pt.ID 
                    WHERE m.IS_SOLVE = 0 AND ir.PENERBIT_ID='$id' AND ir.status='pending'";
        
        $sqlGroupBy = " GROUP BY pt.id, ir.noresi, pt.title, pt.kepeng, pt.author,pt.bulan_terbit, pt.tahun_terbit, 
                    pt.mohon_date, pt.jenis_media, ir.id ";

        $sqlFilGroupBy = " GROUP BY pt.id ";

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
        if($request->input('jenisMedia') !=''){
            $sqlFiltered .= " AND pt.jenis_media = '".$request->input('jenisMedia')."'";
            $sql .= " AND pt.jenis_media = '".$request->input('jenisMedia')."'";  
        }
        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql $sqlGroupBy)  inner WHERE rownum <=$end) outer WHERE rn >$start", 'sql', '')["Data"]["Items"];
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM ISBN_RESI WHERE PENERBIT_ID='$id' AND status='pending' ", 'sql', '')["Data"]["Items"][0]["JUMLAH"];

        $totalFiltered = isset(kurl("get","getlistraw", "",  $sqlFiltered . $sqlFilGroupBy, 'sql', '')["Data"]["Items"][0]["JUMLAH"]) ? 
                            kurl("get","getlistraw", "",  $sqlFiltered . $sqlFilGroupBy, 'sql', '')["Data"]["Items"][0]["JUMLAH"] : 0;

        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                switch($val['JENIS_MEDIA']){
                    case '1': $jenis_media = 'Cetak'; break;
                    case '2': $jenis_media = 'Digital (PDF)'; break;
                    case '3': $jenis_media = 'Digital (EPUB)'; break;
                    case '4': $jenis_media = 'Audio Book'; break;
                    case '5': $jenis_media = 'Audio Visual Book'; break;
                    default: $jenis_media = ''; break;
                }
                $id = $val['ID'];
                $noresi = $val['NORESI'] ? $val['NORESI'] : $val['ID'];
                $action = '<a class="badge badge-primary h-20px m-1" href="'. url('/penerbit/isbn/permohonan/detail/'.$noresi).'" target="_self">Perbaiki permohonan</a><a class="badge badge-danger h-20px m-1" onclick="batalkanPermohonan('.$val['IRID'].')">Batalkan Permohonan</a>';
                if(session('penerbit')['IS_LOCK'] == '1') {
                    $action = "";
                }
                $masalah = explode('¦',$val['MASALAH']);
               $str_masalah = "";
                foreach($masalah as $m){
                    $detail = explode('||', $m);
                    $str_masalah .= "<div style='border:1px solid #ccc; padding:2px; margin-bottom:2px; width:300px; border-radius:2px'>";     
                    $str_masalah .= '<b>Isi:</b> ' . $detail[0] . '<br/><b>Tanggal: ' . $detail[1] . '</b><br/>';
                    $str_masalah .= '<b>Masalah selesai</b>:' . ($detail[2] == '0'? 'Tidak' : 'Selesai') . '<br/>';
                    $str_masalah .= '<b>Dibuat oleh</b>:' . $detail[3];
                    
                    $str_masalah .="</div>";
                }
               
                $response['data'][] = [
                    $nomor,
                    $action,
                    $val['NORESI'],
                    $val['TITLE']  . " <span class='text-success'><i>$jenis_media</i></span>",
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $str_masalah,     
                    $val['MOHON_DATE'],                      
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
