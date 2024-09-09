<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IsbnDataController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
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
        $id = session('penerbit')['ID'];
        
        $start = $start;
        $end = $start + $length;

        $sql  = "SELECT pi.id, pt.title, pi.keterangan, pi.isbn_no, pi.prefix_element, pi.publisher_element, pi.item_element, pi.check_digit, pi.keterangan_jilid,
                    pt.kepeng, pt.author, pt.tahun_terbit, pi.received_date_kckr, pi.received_date_prov, pt.jml_jilid, pt.jilid_volume, pt.bulan_terbit,
                    pt.validation_date, pt.mohon_date, pt.validator_by, pt.is_kdt_valid FROM PENERBIT_ISBN pi 
                    JOIN PENERBIT_TERBITAN pt ON pt.ID = pi.PENERBIT_TERBITAN_ID WHERE pi.PENERBIT_ID='$id'";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM PENERBIT_ISBN pi JOIN PENERBIT_TERBITAN pt ON pt.ID = pi.PENERBIT_TERBITAN_ID 
            WHERE pi.PENERBIT_ID='$id' ";
       
        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'isbn'){
                    $isbn = str_replace("-","",$advSearch["value"]);
                    $sqlFiltered .= " AND pi.ISBN_NO like '%".$isbn."%'";
                    $sql .= " AND pi.ISBN_NO like '%".$isbn."%'";
                }
                if($advSearch["param"] == 'title'){
                    $sqlFiltered .= " AND (lower(pt.TITLE) like '%".strtolower($advSearch["value"])."%' OR lower(pi.KETERANGAN_JILID) like '%".strtolower($advSearch["value"]) ."%')";
                    $sql .= " AND (lower(pt.TITLE) like '%".strtolower($advSearch["value"])."%' OR lower(pi.KETERANGAN_JILID) like '%".strtolower($advSearch["value"]) ."%')";
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
        if($request->input('jenisTerbitan') !=''){
            if($request->input('jenisTerbitan') == 'lepas'){
                $sqlFiltered .= " AND (pt.JML_JILID is null OR pt.JML_JILID=1)";
                $sql .= " AND (pt.JML_JILID is null OR pt.JML_JILID=1)";
            }
            if($request->input('jenisTerbitan') == 'jilid'){
                $sqlFiltered .= " AND  pt.JML_JILID > 1";
                $sql .= " AND pt.JML_JILID > 1";
            }
        }
        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM PENERBIT_ISBN WHERE PENERBIT_ID='$id' AND (status='diterima' OR status is null)", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $totalFiltered = kurl("get","getlistraw", "", $sqlFiltered, 'sql', '')["Data"]["Items"][0]["JUMLAH"];

        $response['data'] = [];
        if ($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $jml_jilid = $val['JML_JILID'];
                if($jml_jilid){
                    $jilid_lepas = intval($jml_jilid) > 1 ? "terbitan jilid" : "terbitan lepas";
                }else {
                    $jilid_lepas = "terbitan lepas";
                }
                $kdt = $val['IS_KDT_VALID'] == 1 ? '<a class="badge badge-success h-30px m-1" onClick="cetakKDT('.$val['ID'].')">Cetak KDT</a>' : '<a class="badge badge-primary h-30px m-1" onClick="reqKDT('.$val['ID'].')">Permohonan KDT</a>';
                $response['data'][] = [
                    $nomor,
                    '<a class="badge badge-info h-30px m-1" onclick="cetakBarcode('.$val['ID'].')">Barcode</a>' .$kdt, //<a class="badge badge-primary h-30px m-1" onClick="cetakKDT()">KDT</a>',
                    $val['PREFIX_ELEMENT'] .'-' . $val['PUBLISHER_ELEMENT'] . '-' . $val['ITEM_ELEMENT'] . '-' . $val['CHECK_DIGIT'] ,
                    $val['TITLE'] . "   <i>". $val['KETERANGAN_JILID'] ."</i><br/><span class='badge badge-light-success'>$jilid_lepas</span>",
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['BULAN_TERBIT'] .' ' . $val['TAHUN_TERBIT'],
                    '<select class="form-select fs-7 select-costum" id="changeStatus_'.$val['ID'].'" onChange="changeStatus('.$val['ID'].')"><option value"">--Pilih status--</option><option value="belum terbit">Belum Terbit</option><option value="terbit">Sudah Terbit</option><option value="batal">Batal Terbit</option></select>', 
                    $val['MOHON_DATE'],
                    $val['VALIDATION_DATE'],
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

    public function detail($noresi)
    {
        $data =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=" . "SELECT * FROM PENERBIT_TERBITAN WHERE NORESI='" . $noresi ."'");

        return view('edit_isbn', $data);
    }
}
