<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Milon\Barcode\DNS1D;
use Barryvdh\DomPDF\Facade\PDF;

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

        $sql = "SELECT pi.penerbit_terbitan_id, pt.KD_PENERBIT_DTL, ir.mohon_date, pt.author, pt.kepeng,
                pi.RECEIVED_DATE_KCKR, pi.RECEIVED_DATE_PROV,pt.VALIDATION_DATE,
                case 
                    when upper(ir.jenis) = 'LEPAS' then listagg(pi.isbn_no, ', ') within group (order by pi.isbn_no)
                    when upper(ir.jenis) = 'JILID' then listagg(pi.isbn_no || ' (' || pi.KETERANGAN_JILID || ') ', ', ') within group (order by pi.isbn_no) 
                End isbn_no_gab, pt.bulan_terbit, pt.tahun_terbit,
								ir.id as isbn_resi_id,
                ir.jenis,
                pt.title,  pt.jml_jilid, pt.jilid_volume, 
                 pt.validator_by, pt.is_kdt_valid
                FROM penerbit_isbn pi
                JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                JOIN isbn_resi ir on ir.penerbit_terbitan_id = pt.id
                WHERE pi.PENERBIT_ID =$id ";
        $sqlGroupBy = " GROUP BY pi.penerbit_terbitan_id, pt.title,  pt.jml_jilid, pt.jilid_volume, pt.bulan_terbit, pt.author, pt.kepeng,
                pt.validation_date, pt.validator_by, pt.is_kdt_valid, ir.jenis, ir.mohon_date, ir.id, pt.tahun_terbit,
                pi.RECEIVED_DATE_KCKR, pi.RECEIVED_DATE_PROV, pt.KD_PENERBIT_DTL";

        $sqlFiltered = "SELECT pt.id FROM penerbit_terbitan pt JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id
                        JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id
                        WHERE ir.penerbit_id = $id ";
        $sqlFilGroupBy = "GROUP BY pt.id ";
       
        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'isbn'){
                    $isbn = str_replace("-","",$advSearch["value"]);
                    $sqlFiltered .= " AND CONCAT('WIN',(upper(pi.ISBN_NO))) like 'WIN%".$isbn."%'";
                    $sql .= " AND CONCAT('WIN',(upper(ISBN_NO))) like 'WIN%".$isbn."%'";
                }
                if($advSearch["param"] == 'title'){
                    $sqlFiltered .= " AND (CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%' OR CONCAT('WIN',upper(pi.KETERANGAN_JILID)) like 'WIN%".strtoupper($advSearch["value"]) ."%')";
                    $sql .= " AND (CONCAT('WIN',(upper(TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%' OR CONCAT('WIN',upper(KETERANGAN_JILID)) like 'WIN%".strtoupper($advSearch["value"]) ."%')";
                }
                if($advSearch["param"] == 'tahun_terbit'){
                    $sqlFiltered .= " AND pt.TAHUN_TERBIT like '%".$advSearch["value"]."%'";
                    $sql .= " AND TAHUN_TERBIT like '%".$advSearch["value"]."%'";
                }
                if($advSearch["param"] == 'kepeng'){
                    $sqlFiltered .= " AND (upper(pt.kepeng) like '%".strtoupper($advSearch["value"])."%' OR upper(pt.author) like '%".strtoupper($advSearch["value"])."%') ";
                    $sql .= " AND (upper(kepeng) like '%".strtoupper($advSearch["value"])."%' OR upper(author) like '%".strtoupper($advSearch["value"])."%') ";
                }
            }
        }
        if($request->input('jenisTerbitan') !=''){
            $sqlFiltered .= " AND upper(ir.jenis) = '".strtoupper($request->input('jenisTerbitan'))."'";
            $sql .= " AND upper(ir.jenis) = '".strtoupper($request->input('jenisTerbitan'))."'";  
        }
        if($request->input('kdtValid') !=''){
            $sqlFiltered .= " AND pt.is_kdt_valid = '".$request->input('kdtValid')."'";
            $sql .= " AND pt.is_kdt_valid = '".$request->input('kdtValid')."'";
        }
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM (SELECT penerbit_terbitan_id FROM PENERBIT_ISBN WHERE PENERBIT_ID='$id' GROUP BY penerbit_terbitan_id) ", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
        if($length == '-1'){
            $end = $totalData;
        }
        
        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql  $sqlGroupBy) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        $totalFiltered = kurl("get","getlistraw", "", "SELECT COUNT(*) JUMLAH FROM ($sqlFiltered $sqlFilGroupBy)", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
        $response['data'] = [];
        if ($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $jenis = str_contains($val['ISBN_NO_GAB'], "(") ? "jilid" : "lepas";
                if($jenis == 'jilid'){
                    $jml_jilid = count(explode(',', $val['ISBN_NO_GAB']));
                } else {
                    $jml_jilid = 1;
                }
               
                $kdt = $val['IS_KDT_VALID'] == 1 ? '<a class="badge badge-success h-30px m-1" onClick="cetakKDT('.$val['PENERBIT_TERBITAN_ID'].')">Cetak KDT</a>' : "";//'KDT Belum Ada';
                $response['data'][] = [
                    $nomor,
                    '<a class="badge badge-info h-30px m-1" onclick="cetakBarcode('.$val['PENERBIT_TERBITAN_ID'].')">Barcode</a>' .$kdt, //<a class="badge badge-primary h-30px m-1" onClick="cetakKDT()">KDT</a>',
                    //$val['PREFIX_ELEMENT'] .'-' . $val['PUBLISHER_ELEMENT'] . '-' . $val['ITEM_ELEMENT'] . '-' . $val['CHECK_DIGIT'] ,
                    $val['ISBN_NO_GAB'],
                    $val['TITLE'] . "<br/><span class='badge badge-light-success'>$jenis</span>",
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['BULAN_TERBIT'] .' ' . $val['TAHUN_TERBIT'],

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
