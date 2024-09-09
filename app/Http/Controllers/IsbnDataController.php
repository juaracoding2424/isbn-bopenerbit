<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\PDF;
use Milon\Barcode\DNS1D;

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
                    pt.kepeng, pt.author, pt.tahun_terbit, pi.received_date_kckr, pi.received_date_prov, pt.jml_jilid, pt.jilid_volume, pt.bulan_terbit, pi.penerbit_terbitan_id,
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
                $kdt = $val['IS_KDT_VALID'] == 1 ? '<a class="badge badge-success h-30px m-1" onClick="cetakKDT('.$val['PENERBIT_TERBITAN_ID'].')">Cetak KDT</a>' : '<a class="badge badge-primary h-30px m-1" onClick="reqKDT('.$val['PENERBIT_TERBITAN_ID'].')">Permohonan KDT</a>';
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

    public function detail($id)
    {
        //$data =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=" . "SELECT * FROM PENERBIT_TERBITAN WHERE NORESI='" . $noresi ."'");
        $data = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_ISBN pi JOIN PENERBIT_TERBITAN pt ON pi.PENERBIT_TERBITAN_ID = pt.ID WHERE pi.ID='" . $id ."' ", 'sql', '')["Data"]["Items"];
        return response()->json($data);
    }

    public function getKDT($id){
        $query = "SELECT TITLE || (CASE WHEN LENGTH(TRIM(KEPENG)) > 0 THEN (' / ' || TRIM(KEPENG) || '.') ELSE '' END) || 
        (CASE WHEN LENGTH(TRIM(EDISI)) > 0 THEN (' -- ' || TRIM(EDISI) || '.') ELSE '' END)|| 
        (CASE WHEN LENGTH(TRIM((CASE WHEN LENGTH(TRIM(TEMPAT_TERBIT)) > 0 THEN (' -- ' || TRIM(TEMPAT_TERBIT) || ' : ' || PENERBIT.NAME || 
        (CASE WHEN LENGTH(TRIM(TAHUN_TERBIT)) > 0 THEN (', ' || TRIM(TAHUN_TERBIT)) ELSE (' -- ' || PENERBIT.NAME || 
        (CASE WHEN LENGTH(TRIM(TAHUN_TERBIT)) > 0 THEN (', ' || TRIM(TAHUN_TERBIT)) ELSE (' -- ' || PENERBIT.NAME) END)) END)) 
        ELSE (' -- ' || PENERBIT.NAME || (CASE WHEN LENGTH(TRIM(TAHUN_TERBIT)) > 0 THEN (', ' || TRIM(TAHUN_TERBIT)) 
        ELSE (' -- ' || PENERBIT.NAME || (CASE WHEN LENGTH(TRIM(TAHUN_TERBIT)) > 0 THEN (', ' || TRIM(TAHUN_TERBIT)) 
        ELSE (' -- ' || PENERBIT.NAME) END)) END)) END))) > 0 THEN ((CASE WHEN LENGTH(TRIM(TEMPAT_TERBIT)) > 0 THEN 
        (' -- ' || TRIM(TEMPAT_TERBIT) || ' : ' || PENERBIT.NAME || (CASE WHEN LENGTH(TRIM(TAHUN_TERBIT)) > 0 THEN 
        (', ' || TRIM(TAHUN_TERBIT)) ELSE (' -- ' || PENERBIT.NAME || (CASE WHEN LENGTH(TRIM(TAHUN_TERBIT)) > 0 THEN   
        (', ' || TRIM(TAHUN_TERBIT)) ELSE (' -- ' || PENERBIT.NAME) END)) END)) ELSE (' -- ' || PENERBIT.NAME ||
         (CASE WHEN LENGTH(TRIM(TAHUN_TERBIT)) > 0 THEN (', ' || TRIM(TAHUN_TERBIT)) ELSE (' -- ' || PENERBIT.NAME || 
         (CASE WHEN LENGTH(TRIM(TAHUN_TERBIT)) > 0 THEN (', ' || TRIM(TAHUN_TERBIT)) ELSE (' -- ' || PENERBIT.NAME) END)) END)) END) || '.') ELSE '' END) || 
         REPLACE((CASE  WHEN LENGTH(TRIM((CASE WHEN LENGTH(TRIM(JML_HLM)) > 0 THEN ('\n' || TRIM(JML_HLM) || ' hlm.' || 
         (CASE WHEN LENGTH(TRIM(KETEBALAN)) > 0 THEN (' ; ' || TRIM(KETEBALAN) || ' cm.') ELSE '' END)) ELSE 
         ((CASE WHEN LENGTH(TRIM(KETEBALAN)) > 0 THEN ('\n' || TRIM(KETEBALAN) || ' cm.') ELSE '' END)) END))) > 0 THEN 
         ((CASE WHEN LENGTH(TRIM(JML_HLM)) > 0 THEN ('\n' || TRIM(JML_HLM) || ' hlm.' || (CASE WHEN LENGTH(TRIM(KETEBALAN)) > 0 
         THEN (' ; ' || TRIM(KETEBALAN) || ' cm.') ELSE '' END)) ELSE ((CASE WHEN LENGTH(TRIM(KETEBALAN)) > 0 THEN ('\n' || TRIM(KETEBALAN) || ' cm.') ELSE '' END)) 
         END)) ELSE '' END),'jil hlm','jil') || '\n' || (CASE WHEN LENGTH(TRIM(CATATAN)) > 0 THEN 
         ('\n' || TRIM(CATATAN)) ELSE '' END) || (CASE WHEN LENGTH(TRIM((SELECT LISTAGG((PREFIX_ELEMENT || '-' || PUBLISHER_ELEMENT || '-' || ITEM_ELEMENT || '-' || CHECK_DIGIT), '\n') WITHIN 
         GROUP (ORDER BY ITEM_ELEMENT) FROM PENERBIT_ISBN WHERE PENERBIT_TERBITAN_ID = PENERBIT_TERBITAN.ID))) > 0 THEN ('\n' || (SELECT (LISTAGG('ISBN ' || (PREFIX_ELEMENT || '-' || PUBLISHER_ELEMENT || '-' || ITEM_ELEMENT || '-' || CHECK_DIGIT) || (CASE WHEN LENGTH(TRIM(KETERANGAN)) > 0 THEN (' (' || TRIM(KETERANGAN) || ')') ELSE '' END), '\n') WITHIN GROUP (ORDER BY ITEM_ELEMENT)) FROM PENERBIT_ISBN WHERE PENERBIT_TERBITAN_ID = PENERBIT_TERBITAN.ID)) ELSE '' END) as ISI 
        FROM PENERBIT_TERBITAN INNER JOIN PENERBIT ON PENERBIT_TERBITAN.PENERBIT_ID = PENERBIT.ID WHERE 1=1 
        AND PENERBIT_TERBITAN.ID =$id";
        $data = kurl("post","getlistraw", "", $query, 'sql', '')["Data"]["Items"][0];
        $isi = $data["ISI"];
        return $isi;
    }

    function generatePDF($id)
    {   
        //$data = $this->getKDT($id);
        $data = [
            'title' => 'domPDF in Laravel 10', 
            'data'=> $this->getKDT($id)
        ];
        $pdf = PDF::loadView('kdt_pdf', $data);
        return $pdf->download('kdt'.$id.now()->format('Ymd').'.pdf');

    }

    function viewPDF($id)
    {   
        date_default_timezone_set('Asia/Jakarta');
        //$data = $this->getKDT($id);
        $data = [
            'title' => 'domPDF in Laravel 10', 
            'data'=> $this->getKDT($id)
        ];
        $pdf = PDF::loadView('kdt_pdf', $data);
        return view('kdt_pdf', $data);

    }

    function generateBarcode($id)
    {
        $d = new DNS1D();
        //$d->setStorPath(__DIR__.'/cache/');
        return view('barcode') ;//, $d->getBarcodeHTML('9780691147727', 'EAN13')); 
    }
}
