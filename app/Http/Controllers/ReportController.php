<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportIsbnExport;

class ReportController extends Controller
{
    function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
        ];
        return view('report_isbn', $data);
    }

    function showData(Request $request)
    {
        $start  = $request->input('start') ? $request->input('start') : 0;
        $length = $request->input('length') ? $request->input('length') : 300;
        $id = session('penerbit')['ID'];
        
        $end = $start + $length;

        $sql = "SELECT pi.penerbit_terbitan_id, ir.mohon_date, pt.author, pt.kepeng, pi.prefix_element, pi.publisher_element,pi.item_element, pi.check_digit,
                pi.RECEIVED_DATE_KCKR, pi.RECEIVED_DATE_PROV,pt.VALIDATION_DATE, pi.isbn_no, pt.bulan_terbit, pt.tahun_terbit, 
                pt.jenis_media, pt.jenis_penelitian, pt.jenis_kelompok, pt.jenis_pustaka, pt.jenis_kategori, pt.jenis_terbitan,
				ir.id as isbn_resi_id, ir.source, ir.jenis, pt.title,  pt.jml_jilid, pt.jilid_volume, pi.ACCEPTDATE, pt.call_number, pt.sinopsis, pt.subjek,
                pt.is_kdt_valid
                FROM penerbit_isbn pi
                LEFT JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                LEFT JOIN isbn_resi ir on ir.penerbit_terbitan_id = pt.id
                WHERE pi.PENERBIT_ID =$id ";

        $sqlFiltered = "SELECT pt.id FROM penerbit_isbn pi
                        LEFT JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                        LEFT JOIN isbn_resi ir on ir.penerbit_terbitan_id = pt.id
                        WHERE pi.PENERBIT_ID =$id ";
        if($request->input('advSearch')) {
            $advSearch_ = json_decode($request->input('advSearch'), true);

            foreach($advSearch_ as $advSearch){
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
            switch($request->input("periode")) {
                case "tahunan" : 
                    if($request->input('date_start')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."-01-01', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."-01-01', 'yyyy-mm-dd')";
                    }
                    if($request->input('date_end')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."-12-31', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."-12-31', 'yyyy-mm-dd')";
                    } 
                    break;
                case "bulanan" : 
                    if($request->input('date_start')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."-01', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."-01', 'yyyy-mm-dd')";
                    }
                    if($request->input('date_end')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."-31', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."-31', 'yyyy-mm-dd')";
                    } 
                break;
                case "harian" : 
                    if($request->input('date_start')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."', 'yyyy-mm-dd')";
                    }
                    if($request->input('date_end')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."', 'yyyy-mm-dd')";
                    } 
                break;
            }
            
        }
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM PENERBIT_ISBN WHERE PENERBIT_ID='$id' ", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
        if($length == '-1'){
            $end = $totalData;
        }
        $queryData = [];
        if($request->input('action') == 'view' || $request->input('action') == 'pdf' || $request->input('action') == 'xls'){
            for($i = 0; $i < ceil($totalData/$length); $i++){
                $start = $i * $length;
                $end = $start + $length;
                
                $res = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql ) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
                $queryData = array_merge($queryData, $res);
            }
        } else {
            //\Log::info("SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql ) inner) outer WHERE rn >$start AND rn <= $end");
            $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql ) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        }
       
        $totalFiltered = kurl("get","getlistraw", "", "SELECT COUNT(*) JUMLAH FROM ($sqlFiltered )", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
        $response['data'] = [];
        if ($queryData <> FALSE) {
            $nomor = 1;
            foreach ($queryData as $val) {
                $source = $val['SOURCE'] == 'web' ? "<span class='badge badge-secondary'>".$val['SOURCE']."</span>" : "<span class='badge badge-primary'>".$val['SOURCE']."</span>";
                $jenis = $val['JENIS'] == 'lepas' ? "<span class='badge badge-light-success'>".$val['JENIS']."</span>" : "<span class='badge badge-light-warning'>".$val['JENIS']."</span>";
                $kdt = $val['IS_KDT_VALID'] == 1 ? url("/penerbit/isbn/data/view-kdt/") : "Belum ada KDT";
                switch($val['JENIS_MEDIA']){
                    case '1': $jenis_media = 'Cetak'; break;
                    case '2': $jenis_media = 'Digital (PDF)'; break;
                    case '3': $jenis_media = 'Digital (EPUB)'; break;
                    case '4': $jenis_media = 'Audio Book'; break;
                    case '5': $jenis_media = 'Audio Visual Book'; break;
                    default: $jenis_media = ''; break;
                }
                switch($val['JENIS_TERBITAN']){
                    case '1': $jt = 'Pemerintah'; break;
                    case '2': $jt = 'Perguruan Tinggi'; break;
                    case '3': $jt = 'Swasta'; break;
                    default: $jt = ''; break;
                }
                switch($val['JENIS_PENELITIAN']){
                    case '1': $jp = 'Penelitian'; break;
                    case '2': $jp = 'Non Penelitian'; break;
                    default: $jp = ''; break;
                }
                switch($val['JENIS_KELOMPOK']){
                    case '1': $jk = 'Anak'; break;
                    case '2': $jk = 'Dewasa'; break;
                    case '3': $jk = 'Semua Umur'; break;
                    default: $jk = ''; break;
                }
                switch($val['JENIS_PUSTAKA']){
                    case '1': $jpu = 'Fiksi'; break;
                    case '2': $jpu = 'Non Fiksi'; break;
                    default: $jpu = ''; break;
                }
                switch($val['JENIS_KATEGORI']){
                    case '1': $jkt = 'Terjemahan'; break;
                    case '2': $jkt = 'Non Terjemahan'; break;
                    default: $jkt = ''; break;
                }
                $response['data'][] = [
                    $nomor,
                    $val['PREFIX_ELEMENT'] .'-' . $val['PUBLISHER_ELEMENT'] . '-' . $val['ITEM_ELEMENT'] . '-' . $val['CHECK_DIGIT'] ,
                    $val['TITLE'],
                    $val['JENIS'],
                    $val['SOURCE'],
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['BULAN_TERBIT'] .' ' . $val['TAHUN_TERBIT'],
                    $val['MOHON_DATE'],
                    $val['ACCEPTDATE'],
                    $val['RECEIVED_DATE_KCKR'] ? $val['RECEIVED_DATE_KCKR'] : 'belum diserahkan',
                    $val['RECEIVED_DATE_PROV'] ? $val['RECEIVED_DATE_PROV'] : 'belum diserahkan',
                    $kdt,
                    $jenis_media,
                    $jt,
                    $jp,
                    $jk,
                    $jpu,
                    $jkt
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
        
        if($request->input('action') == 'view') {
            $pdf = PDF::loadView('report_isbn_data_pdf', $response);
            return view('report_isbn_data_pdf', $response);
        } 
        if($request->input('action') == 'pdf') { 
            $pdf = PDF::loadView('report_isbn_data_pdf', $response);
            return $pdf->download('Laporan Data ISBN ' . session('penerbit')['NAME'] . now()->format('YmdHis') .'.pdf');
        }

        if($request->input('action') == 'datatable') {
            return view('report_isbn_data');
        }
        if($request->input('action') == 'data') {
            return response()->json($response);
        }
        if($request->input('action') == 'xls') {
            return Excel::download(new ReportIsbnExport($response['data'], session('penerbit')['NAME']), 'Laporan Data ISBN ' . session('penerbit')['NAME'] . now()->format('YmdHis') .'.xlsx');
        }
        if($request->input('action') == 'csv') {
            return Excel::download(new ReportIsbnExport($response['data'], session('penerbit')['NAME']), 
            'Laporan Data ISBN ' . session('penerbit')['NAME'] . now()->format('YmdHis') .'.csv', 
            \Maatwebsite\Excel\Excel::CSV);
        }

    }
    function showFrequency(Request $request)
    {
        $start  = $request->input('start') ? $request->input('start') : 0;
        $length = $request->input('length') ? $request->input('length') : 300;
        $id = session('penerbit')['ID'];
        
        $end = $start + $length;

        $sql = "SELECT pi.penerbit_terbitan_id, ir.mohon_date, pt.author, pt.kepeng, pi.prefix_element, pi.publisher_element,pi.item_element, pi.check_digit,
                pi.RECEIVED_DATE_KCKR, pi.RECEIVED_DATE_PROV,pt.VALIDATION_DATE, pi.isbn_no, pt.bulan_terbit, pt.tahun_terbit,
				ir.id as isbn_resi_id, ir.source, ir.jenis, pt.title,  pt.jml_jilid, pt.jilid_volume, pi.ACCEPTDATE, pt.call_number, pt.sinopsis, pt.subjek,
                pt.is_kdt_valid
                FROM penerbit_isbn pi
                LEFT JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                LEFT JOIN isbn_resi ir on ir.penerbit_terbitan_id = pt.id
                WHERE pi.PENERBIT_ID =$id ";

        $sqlFiltered = "SELECT pt.id FROM penerbit_terbitan pt LEFT JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id
                        LEFT JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id
                        WHERE ir.penerbit_id = $id ";
        if($request->input('advSearch')) {
            $advSearch_ = json_decode($request->input('advSearch'), true);

            foreach($advSearch_ as $advSearch){
                if($advSearch["value"] != '') {
                    if($advSearch["param"] == 'isbn'){
                        $isbn = str_replace("-","",$advSearch["value"]);
                        $sqlFiltered .= " AND CONCAT('WIN',(upper(pi.ISBN_NO))) like 'WIN%".$isbn."%'";
                        $sql .= " AND CONCAT('WIN',(upper(ISBN_NO))) like 'WIN%".$isbn."%'";
                    }
                    if($advSearch["param"] == 'title'){
                        $sqlFiltered .= " AND CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%'";
                        $sql .= " AND CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%'";
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
            switch($request->input("periode")) {
                case "tahunan" : 
                    if($request->input('date_start')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."-01-01', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."-01-01', 'yyyy-mm-dd')";
                    }
                    if($request->input('date_end')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."-12-31', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."-12-31', 'yyyy-mm-dd')";
                    } 
                    break;
                case "bulanan" : 
                    if($request->input('date_start')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."-01', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."-01', 'yyyy-mm-dd')";
                    }
                    if($request->input('date_end')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."-31', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."-31', 'yyyy-mm-dd')";
                    } 
                break;
                case "harian" : 
                    if($request->input('date_start')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE >= TO_DATE('".$request->input('date_start')."', 'yyyy-mm-dd')";
                    }
                    if($request->input('date_end')){
                        $sqlFiltered .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."', 'yyyy-mm-dd')";
                        $sql .= " AND pi.ACCEPTDATE <= TO_DATE('".$request->input('date_end')."', 'yyyy-mm-dd')";
                    } 
                break;
            }
            
        }
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM (SELECT penerbit_terbitan_id FROM PENERBIT_ISBN WHERE PENERBIT_ID='$id' GROUP BY penerbit_terbitan_id) ", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
        if($length == '-1'){
            $end = $totalData;
        }
        $queryData = [];
        if($request->input('action') == 'view' || $request->input('action') == 'pdf' || $request->input('action') == 'xls'){
        for($i = 0; $i < ceil($totalData/$length); $i++){
                $start = $i * $length;
                $end = $start + $length;
                $res = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql ) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
                $queryData = array_merge($queryData, $res);
            }
        } else {
            $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql ) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        }
        $totalFiltered = kurl("get","getlistraw", "", "SELECT COUNT(*) JUMLAH FROM ($sqlFiltered )", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
        $response['data'] = [];
        if ($queryData <> FALSE) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $source = $val['SOURCE'] == 'web' ? "<span class='badge badge-secondary'>".$val['SOURCE']."</span>" : "<span class='badge badge-primary'>".$val['SOURCE']."</span>";
                $jenis = $val['JENIS'] == 'lepas' ? "<span class='badge badge-light-success'>".$val['JENIS']."</span>" : "<span class='badge badge-light-warning'>".$val['JENIS']."</span>";
                $kdt = $val['IS_KDT_VALID'] == 1 ? url("/penerbit/isbn/data/view-kdt/") : "";
                $response['data'][] = [
                    $nomor,
                    $val['PREFIX_ELEMENT'] .'-' . $val['PUBLISHER_ELEMENT'] . '-' . $val['ITEM_ELEMENT'] . '-' . $val['CHECK_DIGIT'] ,
                    $val['TITLE'],
                    $val['JENIS'],
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['BULAN_TERBIT'] .' ' . $val['TAHUN_TERBIT'],
                    $val['MOHON_DATE'],
                    $val['ACCEPTDATE'],
                    $val['RECEIVED_DATE_KCKR'] ? $val['RECEIVED_DATE_KCKR'] : 'belum diserahkan',
                    $val['RECEIVED_DATE_PROV'] ? $val['RECEIVED_DATE_PROV'] : 'belum diserahkan',
                    $kdt,
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
        
        if($request->input('action') == 'view') {
            $pdf = PDF::loadView('report_isbn_data_pdf', $response);
            return view('report_isbn_data_pdf', $response);
        } 
        if($request->input('action') == 'pdf') { 
            $pdf = PDF::loadView('report_isbn_data_pdf', $response);
            return $pdf->download('Laporan Data ISBN ' . session('penerbit')['NAME'] . now()->format('YmdHis') .'.pdf');
        }

        if($request->input('action') == 'datatable') {
            return view('report_isbn_data');
        }
        if($request->input('action') == 'data') {
            return response()->json($response);
        }
        if($request->input('action') == 'xls') {
            return Excel::download(new ReportIsbnExport($response['data']), 'Laporan Data ISBN ' . session('penerbit')['NAME'] . now()->format('YmdHis') .'.xlsx');
        }

    }
}