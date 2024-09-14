<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ISBNController extends Controller
{
    public function data(Request $request)
    {
        $penerbit = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT WHERE JWT='".$request->bearerToken()."'", 'sql', '')["Data"]["Items"][0];
        $page = $request->input('page') ? $request->input('page') : 1;

        
        $length = $request->input('length') ? $request->input('length') : 10;
        $start  = ($page - 1) * $length;
        //$order  = $whereLike[$request->input('order.0.column')];
        //$dir    = $request->input('order.0.dir');
        //$search = $request->input('search.value');
        $id = $penerbit['ID'];
        $end = $start + $length;

        $sql = "SELECT pi.isbn_no, ir.mohon_date, ir.noresi, ir.jenis as jenis_permohonan, ir.source, pt.title, pt.jml_jilid, pt.jilid_volume, 
                pt.author, pt.kepeng, pt.sinopsis, pt.distributor, pt.tempat_terbit, pt.edisi, pt.seri, pt.bulan_terbit, pt.tahun_terbit,
                pt.jml_hlm, pt.ketebalan as dimensi, pt.subjek, pt.call_number, pi.keterangan_jilid,
                pt.jenis_media, pt.jenis_terbitan, pt.jenis_pustaka, pt.jenis_kategori, pt.jenis_kelompok, pt.jenis_penelitian,
                pt.is_kdt_valid, pi.RECEIVED_DATE_KCKR, pi.RECEIVED_DATE_PROV,pi.acceptdate
                FROM penerbit_isbn pi
                JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                JOIN isbn_resi ir on ir.penerbit_terbitan_id = pt.id
                WHERE pi.PENERBIT_ID =$id ";

        $sqlFiltered = "SELECT pt.id FROM penerbit_terbitan pt JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id
                        JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id
                        WHERE ir.penerbit_id = $id ";
        $sqlWhere = "";
        $query = [];
        if($request->input('title')){
            $sqlWhere .= " AND (CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($request->input('title'))."%')";
            array_push($query, [
                "field" => "title",
                "value" => $request->input('title')
            ]);
        }
        if($request->input('kepeng')){
            $sqlWhere .= " AND (upper(pt.kepeng) like '%".strtoupper($request->input('kepeng'))."%' OR upper(pt.author) like '%".strtoupper($request->input('kepeng'))."%') ";
            array_push($query, [
                "field" => "kepeng",
                "value" => $request->input('kepeng')
            ]);
        }
        if($request->input('bulan_terbit')){
            $sqlWhere .= " AND pt.bulan_terbit ='".$request->input('bulan_terbit')."'";
            array_push($query, [
                "field" => "bulan_terbit",
                "value" => $request->input('bulan_terbit')
            ]);
        }
        if($request->input('tahun_terbit')){
            $sqlWhere .= " AND pt.tahun_terbit ='".$request->input('tahun_terbit')."'";
            array_push($query, [
                "field" => "tahun_terbit",
                "value" => $request->input('tahun_terbit')
            ]);
        }
        if($request->input('jenis_permohonan')){
            $sqlWhere .= " AND upper(ir.jenis) ='". strtoupper($request->input('jenis_permohonan'))."'";
            array_push($query, [
                "field" => "jenis_permohonan",
                "value" => $request->input('jenis_permohonan')
            ]);
        }
        if($request->input('jenis_kategori')){
            $sqlWhere .= " AND pt.jenis_kategori ='".$request->input('jenis_kategori')."'";
            array_push($query, [
                "field" => "jenis_kategori",
                "value" => $request->input('jenis_kategori')
            ]);
        }
        if($request->input('jenis_media')){
            $sqlWhere .= " AND pt.jenis_media ='".$request->input('jenis_media')."'";
            array_push($query, [
                "field" => "jenis_media",
                "value" => $request->input('jenis_media')
            ]);
        }
        if($request->input('jenis_kelompok')){
            $sqlWhere .= " AND pt.jenis_kelompok ='".$request->input('jenis_kelompok')."'";
            array_push($query, [
                "field" => "jenis_kelompok",
                "value" => $request->input('jenis_kelompok')
            ]);
        }
        if($request->input('jenis_penelitian')){
            $sqlWhere .= " AND pt.jenis_penelitian ='".$request->input('jenis_penelitian')."'";
            array_push($query, [
                "field" => "jenis_penelitian",
                "value" => $request->input('jenis_penelitian')
            ]);
        }
        if($request->input('jenis_pustaka')){
            $sqlWhere .= " AND pt.jenis_pustaka ='".$request->input('jenis_pustaka')."'";
            array_push($query, [
                "field" => "jenis_pustaka",
                "value" => $request->input('jenis_pustaka')
            ]);
        }
        if($request->input('jenis_terbitan')){
            $sqlWhere .= " AND pt.jenis_terbitan ='".$request->input('jenis_terbitan')."'";
            array_push($query, [
                "field" => "jenis_terbitan",
                "value" => $request->input('jenis_terbitan')
            ]);
        }
        /*if($request->input('date_start')){
            $sqlWhere .= " AND VALIDATE_DATE ='".$request->input('date_start')."'";
             array_push($query, [
                "field" => "date_start",
                "value" => $request->input('date_start')
            ]);
        }
        if($request->input('date_end')){
            $sqlWhere .= " AND VALIDATE_DATE ='".$request->input('date_end')."'";
             array_push($query, [
                "field" => "date_end",
                "value" => $request->input('date_end')
            ]);
        }*/
        //\Log::info("SELECT outer.* FROM (SELECT ROWNUM nomor, inner.* FROM ($sql $sqlWhere) inner) outer WHERE rn >$start AND rn <= $end");
        $data = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM nomor, inner.* FROM ($sql $sqlWhere) inner) outer WHERE nomor >$start AND nomor <= $end", 'sql', '')["Data"]["Items"];  
        // \Log::info("SELECT COUNT(*) JML FROM PENERBIT_ISBN WHERE PENERBIT_ID=$id");
        $totalData = kurl("get","getlistraw", "", "SELECT COUNT(*) JML FROM PENERBIT_ISBN WHERE PENERBIT_ID=$id",'sql', '')["Data"]["Items"][0]["JML"];    
        $totalFiltered = kurl("get","getlistraw", "", "SELECT COUNT(*) JML FROM ($sqlFiltered  $sqlWhere)",'sql', '')["Data"]["Items"][0]["JML"];        
        
        return response()->json([
            'data' => $data,
            'page' => $page,
            'length' => $length,
            'total' => $totalData,
            'totalFiltered' => $totalFiltered,
            'query' => $query,
        ], 200);
    }
}
