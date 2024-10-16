<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Milon\Barcode\DNS1D;
use Barryvdh\DomPDF\Facade\PDF as PDF;
//use Barryvdh\DomPDF\PDF;

class IsbnDataController extends Controller
{
    public function index()
    {
        if(session('penerbit')['GROUP'] != session('penerbit')['ID']) {
            $semua_penerbit = kurl("get","getlistraw", "", "SELECT ID, NAME FROM PENERBIT WHERE ID IN(".session('penerbit')['GROUP'].")", 'sql', '')["Data"]["Items"];
        } else {
            $semua_penerbit = [];
        }
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"],
            'semua_penerbit' => $semua_penerbit
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

        if(session('penerbit')['GROUP'] != session('penerbit')['ID']){
            //kalau ada group nya//
            if($request->input('penerbit') != '0'){
                $where = " WHERE pi.PENERBIT_ID = " . $request->input('penerbit'); //jika difilter dengan penerbit id
            } else {
                $where = " WHERE pi.PENERBIT_ID IN (".session('penerbit')['GROUP'].") ";
            }
        } else {
            $where = " WHERE pi.PENERBIT_ID =$id ";
        }
        $end = $start + $length;

        $sql = "SELECT pi.penerbit_terbitan_id, ir.mohon_date, pt.author, pt.kepeng, pi.prefix_element, pi.publisher_element,pi.item_element, pi.check_digit,
                pi.RECEIVED_DATE_KCKR, pi.RECEIVED_DATE_PROV,pt.VALIDATION_DATE, pi.keterangan_jilid, pi.id as piid, pi.link_buku,
                pi.isbn_no, pt.bulan_terbit, pt.tahun_terbit, pt.jenis_media,
				ir.id as isbn_resi_id, ir.source, ir.jenis,
                pt.title,  pt.jml_jilid, pt.jilid_volume, pi.ACCEPTDATE, pt.call_number, pt.sinopsis, pt.subjek,
                pt.is_kdt_valid
                FROM penerbit_isbn pi
                LEFT JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                LEFT JOIN isbn_resi ir on ir.penerbit_terbitan_id = pt.id " . $where;
        //\Log::info($sql);
        $sqlFiltered = "SELECT pt.id FROM penerbit_terbitan pt LEFT JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id
                        JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id " . $where;
       
        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'isbn'){
                    $isbn = str_replace("-","",$advSearch["value"]);
                    $sqlFiltered .= " AND CONCAT('WIN',(upper(pi.ISBN_NO))) like 'WIN%".$isbn."%'";
                    $sql .= " AND CONCAT('WIN',(upper(ISBN_NO))) like 'WIN%".$isbn."%'";
                }
                if($advSearch["param"] == 'title'){
                    $sqlFiltered .= " AND CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%' ";
                    $sql .= " AND CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%' ";
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
        if($request->input('jenisMedia') !=''){
            $sqlFiltered .= " AND pt.jenis_media = '".$request->input('jenisMedia')."'";
            $sql .= " AND pt.jenis_media = '".$request->input('jenisMedia')."'";  
        }
        if($request->input('jenisTerbitan') !=''){
            $sqlFiltered .= " AND upper(ir.jenis) = '".strtoupper($request->input('jenisTerbitan'))."'";
            $sql .= " AND upper(ir.jenis) = '".strtoupper($request->input('jenisTerbitan'))."'";  
        }
        if($request->input('kdtValid') !=''){
            $sqlFiltered .= " AND pt.is_kdt_valid = '".$request->input('kdtValid')."'";
            $sql .= " AND pt.is_kdt_valid = '".$request->input('kdtValid')."'";
        }
        if($request->input(key: 'sumber') !=''){
            $sqlFiltered .= " AND ir.source = '".$request->input('sumber')."'";
            $sql .= " AND ir.source = '".$request->input('sumber')."'";
        }
        if($request->input('statusKckr') !=''){
            switch($request->input('statusKckr')) {
                case "1-perpusnas": 
                    $sqlFiltered .= " AND pi.received_date_kckr is not null ";
                    $sql .= " AND pi.received_date_kckr is not null ";
                    break;
                case "0-perpusnas": 
                    $sqlFiltered .= " AND pi.received_date_kckr is  null ";
                    $sql .= " AND pi.received_date_kckr is  null ";
                    break;
                case "1-prov": 
                    $sqlFiltered .= " AND pi.received_date_prov is not null ";
                    $sql .= " AND pi.received_date_prov is not null ";
                    break;
                case "0-prov": 
                    $sqlFiltered .= " AND pi.received_date_prov is  null ";
                    $sql .= " AND pi.received_date_prov is  null ";
                    break;
            }
        }
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM PENERBIT_ISBN WHERE PENERBIT_ID='$id'  ", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
        if($length == '-1'){
            $end = $totalData;
        }
        
        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql )  inner WHERE rownum <=$end) outer WHERE rn >$start", 'sql', '')["Data"]["Items"];
    
        $totalFiltered = kurl("get","getlistraw", "", "SELECT COUNT(*) JUMLAH FROM ($sqlFiltered )", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
        $response['data'] = [];
        if ($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $source = $val['SOURCE'] == 'web' ? "<span class='badge badge-secondary'>".$val['SOURCE']."</span>" : "<span class='badge btn-primary'>".$val['SOURCE']."</span>";
                $jenis = $val['JENIS'] == 'lepas' ? "<span class='badge badge-light-success'>".$val['JENIS']."</span>" : "<span class='badge badge-light-warning'>".$val['JENIS']."</span>";
                $kdt = $val['IS_KDT_VALID'] == 1 ? '<a class="badge badge-success h-20px m-1" onClick="cetakKDT('.$val['PENERBIT_TERBITAN_ID'].')">Cetak KDT</a>' : "";//'KDT Belum Ada';
                $sinopsis_pendek = explode(" ", $val["SINOPSIS"]);
                $first_part = implode(" ", array_splice($sinopsis_pendek, 0, 10));
                $other_part = implode(" ", array_splice($sinopsis_pendek, 10));
                switch($val['JENIS_MEDIA']){
                    case '1': $jenis_media = 'Cetak'; break;
                    case '2': $jenis_media = 'Digital (PDF)'; break;
                    case '3': $jenis_media = 'Digital (EPUB)'; break;
                    case '4': $jenis_media = 'Audio Book'; break;
                    case '5': $jenis_media = 'Audio Visual Book'; break;
                    default: $jenis_media = ''; break;
                }
                $response['data'][] = [
                    $nomor,
                    '<a class="badge badge-light-info fs-8 p-2 m-0" onclick="cetakBarcode('.$val['ISBN_NO'].')">Barcode</a>' .$kdt, //<a class="badge btn-primary h-30px m-1" onClick="cetakKDT()">KDT</a>',
                    $val['PREFIX_ELEMENT'] .'-' . $val['PUBLISHER_ELEMENT'] . '-' . $val['ITEM_ELEMENT'] . '-' . $val['CHECK_DIGIT']  . '<br/>' . $val['KETERANGAN_JILID'],
                    $val['TITLE'] . "<br/>$jenis $source <span class='text-success'><i>$jenis_media</i></span>",
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['BULAN_TERBIT'] .' ' . $val['TAHUN_TERBIT'],
                    '<a href="'.$val['LINK_BUKU'].'">' . $val['LINK_BUKU'] . '</a>',
                    $val['MOHON_DATE'],
                    $val['ACCEPTDATE'],
                    $val['RECEIVED_DATE_KCKR'] ? $val['RECEIVED_DATE_KCKR'] : '<a class="badge badge-danger wrap" href="https://edeposit.perpusnas.go.id/login" target="_blank">Serahkan ke Perpusnas</a>',
                    $val['RECEIVED_DATE_PROV'] ? $val['RECEIVED_DATE_PROV'] : '<a class="badge badge-danger wrap" href="https://edeposit.perpusnas.go.id/login" target="_blank">Serahkan ke Provinsi</a>',
                    $val['CALL_NUMBER'],
                    $val['SUBJEK'],
                    $first_part . "<a class='btn badge-light-primary p-1 m-0 fs-8 wrap' onclick='readmore(".$val['PIID'] .")' id='btnReadMore".$val['PIID']."'>Selanjutnya..</a>
                    <span class='d-none sinopsis".$val['PIID']."'>$other_part</span>   <a class='btn badge-light-primary p-1 m-0 fs-8 wrap d-none' onclick='less(".$val['PIID'] .")' id='btnLess".$val['PIID']."'>Tutup</a>",
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
        $query = "SELECT TITLE || (CASE WHEN LENGTH(TRIM(TRANSLATE(KEPENG using char_cs)))  > 0 THEN (' / ' || TRIM(TRANSLATE(KEPENG using char_cs))  || '.') ELSE '' END) || 
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
        date_default_timezone_set('Asia/Jakarta');
        $kdt = kurl("post","getlistraw", "", "SELECT pt.*, p.name, pi.* FROM PENERBIT_TERBITAN pt 
        JOIN penerbit p on p.id = pt.penerbit_id 
        JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id
        WHERE pt.ID = '$id'", 'sql', '')["Data"]["Items"];
        $isbn = "";
        if(count($kdt) > 1) {
            foreach($kdt as $k){
                $isbn .= $k['PREFIX_ELEMENT'] . '-' . $k['PUBLISHER_ELEMENT'] . '-' . $k['ITEM_ELEMENT'] . '-' . $k['CHECK_DIGIT'] .' ' . $k['KETERANGAN_JILID']."<br/>";
            }
        } else {
            $isbn .= $kdt[0]['PREFIX_ELEMENT'] . '-' . $kdt[0]['PUBLISHER_ELEMENT'] . '-' . $kdt[0]['ITEM_ELEMENT'] . '-' . $kdt[0]['CHECK_DIGIT'];
        }
        if(!request('bo_penerbit')) {}
        $data = [
            'data' => $kdt[0],
            'isbn' => $isbn,
            'bo_penerbit'=> request('bo_penerbit')
        ];
        $pdf = PDF::loadView('kdt_pdf', $data);
        return $pdf->download('kdt'.$id.now()->format('Ymd').'.pdf');

    }

    function viewPDF($id)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $kdt = kurl("post","getlistraw", "", "SELECT pt.*, p.name, pi.* FROM PENERBIT_TERBITAN pt  
        JOIN penerbit p on p.id = pt.penerbit_id 
        JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id
        WHERE pt.ID = '$id'", 'sql', '')["Data"]["Items"];
        $isbn = "";
        if(count($kdt) > 1) {
            foreach($kdt as $k){
                $isbn .= $k['PREFIX_ELEMENT'] . '-' . $k['PUBLISHER_ELEMENT'] . '-' . $k['ITEM_ELEMENT'] . '-' . $k['CHECK_DIGIT'] . "<br/>";
            }
        } else {
            $isbn .= $kdt[0]['PREFIX_ELEMENT'] . '-' . $kdt[0]['PUBLISHER_ELEMENT'] . '-' . $kdt[0]['ITEM_ELEMENT'] . '-' . $kdt[0]['CHECK_DIGIT'];
        }
        $data = [
            'data' => $kdt[0],
            'isbn' => $isbn,
            'bo_penerbit'=> request('bo_penerbit')
        ];
        //$pdf = PDF::loadView('kdt_pdf', ['data' => $data]);
        return view('kdt_pdf', $data);

    }

    function generateBarcode($id)
    {
        $queryData = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_ISBN WHERE ISBN_NO='$id'", 'sql', '')["Data"]["Items"][0];
        return view('barcode', ["data" => $queryData]) ;
    }

}
