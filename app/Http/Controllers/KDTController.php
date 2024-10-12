<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Milon\Barcode\DNS1D;
use Barryvdh\DomPDF\Facade\PDF;

class KDTController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
        ];
        return view('kdt', $data);
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
        
        $end = $start + $length;

        $sql = "SELECT pi.penerbit_terbitan_id, ir.mohon_date, pt.author, pt.kepeng,
                pt.VALIDATION_DATE,
                case 
                    when upper(ir.jenis) = 'LEPAS' then listagg(pi.isbn_no, ', ') within group (order by pi.isbn_no)
                    when upper(ir.jenis) = 'JILID' then listagg(pi.isbn_no || ' (' || pi.KETERANGAN_JILID || ') ', ', ') within group (order by pi.isbn_no) 
                    else listagg(pi.isbn_no, ', ') within group (order by pi.isbn_no)
                End isbn_no_gab, pt.bulan_terbit, pt.tahun_terbit, pt.call_number, pt.sinopsis, pt.subjek,
				ir.id as isbn_resi_id, ir.source,ir.jenis,pt.title,  pt.jml_jilid, pt.jilid_volume, 
                pt.validator_by, pt.is_kdt_valid, pt.id
                FROM penerbit_isbn pi
                JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                LEFT JOIN isbn_resi ir on ir.penerbit_terbitan_id = pt.id
                WHERE pi.PENERBIT_ID =$id AND pt.is_kdt_valid=1";
        $sqlGroupBy = " GROUP BY pi.penerbit_terbitan_id, pt.title,  pt.jml_jilid, pt.jilid_volume, pt.bulan_terbit, pt.author, pt.kepeng,
                pt.validation_date, pt.validator_by, pt.is_kdt_valid, ir.jenis, ir.mohon_date, ir.id, pt.tahun_terbit, ir.source, 
                pt.call_number, pt.sinopsis, pt.subjek, pt.id";

        $sqlFiltered = "SELECT pt.id FROM penerbit_isbn pi
                        JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                        LEFT JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id
                        WHERE pi.penerbit_id = $id  AND pt.is_kdt_valid = 1 ";
        $sqlFilGroupBy = "GROUP BY pt.id ";
       
        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'isbn'){
                    $isbn = str_replace("-","",$advSearch["value"]);
                    $sqlFiltered .= " AND CONCAT('WIN',(upper(pi.ISBN_NO))) like 'WIN%".$isbn."%'";
                    $sql .= " AND CONCAT('WIN',(upper(ISBN_NO))) like 'WIN%".$isbn."%'";
                }
                if($advSearch["param"] == 'title'){
                    $sqlFiltered .= " AND CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%'";
                    $sql .= " AND CONCAT('WIN',(upper(TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%'";
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

        if($request->input(key: 'sumber') !=''){
            $sqlFiltered .= " AND ir.source = '".$request->input('sumber')."'";
            $sql .= " AND ir.source = '".$request->input('sumber')."'";
        }
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM 
                (SELECT pi.penerbit_terbitan_id FROM PENERBIT_ISBN pi JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id  
                WHERE pi.PENERBIT_ID='$id' AND pt.is_kdt_valid = 1 GROUP BY pi.penerbit_terbitan_id) ",
                 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        
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
                /*if($jenis == 'jilid'){
                    $jml_jilid = count(explode(',', $val['ISBN_NO_GAB']));
                } else {
                    $jml_jilid = 1;
                }*/
                $source = $val['SOURCE'] == 'web' ? "<span class='badge btn-secondary'>".$val['SOURCE']."</span>" : "<span class='badge btn-primary'>".$val['SOURCE']."</span>";
                $jenis = $val['JENIS'] == 'lepas' ? "<span class='badge btn-light-success'>".$val['JENIS']."</span>" : "<span class='badge btn-light-warning'>".$val['JENIS']."</span>";
                $kdt = $val['IS_KDT_VALID'] == 1 ? '<a class="btn btn-success p-2 m-1 fs-8" onClick="cetakKDT('.$val['PENERBIT_TERBITAN_ID'].')">Cetak KDT</a>' : "";//'KDT Belum Ada';
                $sinopsis_pendek = explode(" ", $val["SINOPSIS"]);
                $first_part = implode(" ", array_splice($sinopsis_pendek, 0, 10));
                $other_part = implode(" ", array_splice($sinopsis_pendek, 10));
                $response['data'][] = [
                    $nomor,
                    $kdt,
                    $val['ISBN_NO_GAB'],
                    $val['TITLE'] . "<br/>$jenis $source",
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['BULAN_TERBIT'] .' ' . $val['TAHUN_TERBIT'],
                    $val['CALL_NUMBER'],
                    $val['SUBJEK'],
                    $first_part . "<a class='btn btn-light-primary p-1 m-0 fs-8 wrap' onclick='readmore(".$val['ID'] .")' id='btnReadMore".$val['ID']."'>Selanjutnya..</a>
                    <span class='d-none sinopsis".$val['ID']."'>$other_part</span>   <a class='btn btn-light-primary p-1 m-0 fs-8 wrap d-none' onclick='less(".$val['ID'] .")' id='btnLess".$val['ID']."'>Tutup</a>",
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
