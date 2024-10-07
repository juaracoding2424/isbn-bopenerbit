<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
        ];
        return view('history', $data);
    }
    public function data()
    {
        try{
            $sql = "SELECT * FROM (SELECT h.id,
                        h.ACTION,
                        h.ACTIONBY,
                        h.ACTIONDATE,
                        h.ACTIONTERMINAL,
                        h.TABLENAME,
                        h.idref,
                        h.NOTE, 
                        pt.title,
                        COALESCE(p.name, irp.nama_penerbit) as penerbit_name,
                        ir.noresi, pi.isbn_no
                    FROM HISTORYDATA h
                    left join penerbit p on p.id = h.idref and h.TABLENAME = 'PENERBIT'
                    left join penerbit_terbitan pt on pt.id = h.idref and h.TABLENAME = 'PENERBIT_TERBITAN'
                    left join isbn_resi ir on ir.penerbit_terbitan_id = pt.id and h.TABLENAME = 'PENERBIT_TERBITAN'
                    left join ISBN_REGISTRASI_PENERBIT irp on irp.id = h.idref and h.TABLENAME = 'ISBN_REGISTRASI_PENERBIT'
                    LEFT JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id and h.TABLENAME = 'PENERBIT_TERBITAN'
                    WHERE (TABLENAME = 'PENERBIT' OR TABLENAME = 'PENERBIT_TERBITAN' OR TABLENAME = 'ISBN_REGISTRASI_PENERBIT')
                    AND (h.ACTIONBY = '" . session('penerbit')['USERNAME']. "' or h.ACTIONBY ='" . session('penerbit')['USERNAME']. "-api')
                    ORDER BY h.ACTIONDATE desc ) WHERE rownum <=20 ";
            $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
            if(isset($data[0])){
                return response()->json($data);
            } else {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 500);
            }
        } catch(\Exception $e){
            return response()->json([
                "message" => "Server error. " . $e->getMessage()
            ], 500);
        }
    }

    public function datatable(Request $request)
    {
        $whereLike = [
            'ID',
            'ACTIONDATE',
            'ACTIONBY',
            'NOTE',
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        //$order  = $whereLike[$request->input('order.1.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $id = session('penerbit')['ID'];
        
        $end = $start + $length;

        $sql  = "SELECT h.id,
                        h.ACTION,
                        h.ACTIONBY,
                        h.ACTIONDATE,
                        h.ACTIONTERMINAL,
                        h.TABLENAME,
                        h.idref,
                        h.NOTE, 
                        pt.title,
                        COALESCE(p.name, irp.nama_penerbit) as penerbit_name,
                        ir.noresi, pi.isbn_no
                    FROM HISTORYDATA h
                    left join penerbit p on p.id = h.idref and h.TABLENAME = 'PENERBIT'
                    left join penerbit_terbitan pt on pt.id = h.idref and h.TABLENAME = 'PENERBIT_TERBITAN'
                    left join isbn_resi ir on ir.penerbit_terbitan_id = pt.id and h.TABLENAME = 'PENERBIT_TERBITAN'
                    left join ISBN_REGISTRASI_PENERBIT irp on irp.id = h.idref and h.TABLENAME = 'ISBN_REGISTRASI_PENERBIT'
                    LEFT JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id and h.TABLENAME = 'PENERBIT_TERBITAN'
                    WHERE (TABLENAME = 'PENERBIT' OR TABLENAME = 'PENERBIT_TERBITAN' OR TABLENAME = 'ISBN_REGISTRASI_PENERBIT')
                    AND (h.ACTIONBY = '" . session('penerbit')['USERNAME']. "' or h.ACTIONBY ='" . session('penerbit')['USERNAME']. "-api')
                    ORDER BY h.ACTIONDATE desc";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM HISTORYDATA WHERE (actionby = '".session('penerbit')['USERNAME']."' OR actionby = '".session('penerbit')['USERNAME']."-api') 
                        AND (TABLENAME = 'PENERBIT' OR TABLENAME = 'PENERBIT_TERBITAN' OR TABLENAME = 'ISBN_REGISTRASI_PENERBIT') ";
        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM HISTORYDATA WHERE (actionby = '".session('penerbit')['USERNAME']."' OR actionby = '".session('penerbit')['USERNAME']."-api')
                         AND (TABLENAME = 'PENERBIT' OR TABLENAME = 'PENERBIT_TERBITAN' OR TABLENAME = 'ISBN_REGISTRASI_PENERBIT')", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $totalFiltered = kurl("get","getlistraw", "", $sqlFiltered, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $status_permohonan = ""; $cek_disini = ""; $link = config('app.isbn_file_location'); $note="Permohonan";
                switch($val['NOTE']){
                    case 'Permohonan baru': 
                        $status_permohonan = '<span class="badge badge-primary">BARU</span>';
                        $cek_disini = "<a href='".url('/penerbit/isbn/permohonan/detail/' . $val['NORESI']) ."'>Cek disini.</a>";
                        break;
                    case 'Permohonan lanjutan': 
                        $note = "Permohonan ";
                        $status_permohonan = '<span class="badge badge-primary">JILID LANJUTAN</span>';
                        $cek_disini = "<a href='".url('/penerbit/isbn/permohonan/detail/' . $val['NORESI']) ."'>Cek disini.</a>";
                        break;
                    case 'Set status diterima': 
                        $status_permohonan = '<span class="badge badge-success">DITERIMA</span>';
                        $cek_disini = "<a href='".url('/penerbit/isbn/data') ."'>Cek disini.</a>";
                        break;
                    case 'Set status bermasalah': 
                        $status_permohonan = '<span class="badge badge-danger">BERMASALAH</span>';
                        $cek_disini = "<a href='".url('/penerbit/isbn/permohonan/detail/' . $val['NORESI']) ."'>Cek disini.</a>";
                        break;
                    case 'Set status batal': 
                        $status_permohonan = '<span class="badge badge-light-danger">BATAL</span>';
                        $cek_disini = "<a href='".url('/penerbit/isbn/permohonan/batal') ."'>Cek disini.</a>";
                        break;
                    default: 
                        $note = str_replace("href='", "href='".$link, $val['NOTE']);
                        $status_permohonan = '' ;
                        break;
                }
                if($val['TABLENAME'] == 'PENERBIT_TERBITAN'){
                    $notes = $note . $status_permohonan . " : '" .$val['TITLE'] ."'. ". $cek_disini;
                } else {
                    $notes = $note . $status_permohonan;
                }
                $response['data'][] = [
                    $nomor,
                    $val['ACTIONDATE'],
                    $val['ACTIONBY'],
                    $notes
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
