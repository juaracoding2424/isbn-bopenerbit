<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IsbnBatalController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
        ];
        return view('isbn_batal', $data);
    }
    function datatable(Request $request)
    {
        $whereLike = [
            'ID',
            'NORESI',
            'TITLE',
            'KEPENG',
            'TAHUN_TERBIT',
            'MOHON_DATE',
            ''
        ];

        $start  = $request->input('start');
        $length = $request->input('length');
        $order  = $whereLike[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $id = session('penerbit')['ID'];
        $end = $start + $length;

        $sql  = "SELECT ir.id, pt.title, pt.author, pt.kepeng,pt.bulan_terbit, pt.tahun_terbit, ir.noresi, ir.createdate, 
                        ir.mohon_date, ir.jml_jilid_req, ir.jenis, ir.status, ir.source  
                    FROM ISBN_RESI ir 
                    JOIN PENERBIT_TERBITAN pt  ON ir.penerbit_terbitan_id = pt.id  
                    WHERE pt.PENERBIT_ID='$id' AND ir.status = 'batal' ";
        $sqlFiltered = "SELECT count(ir.id) JUMLAH 
                            FROM ISBN_RESI ir 
                            JOIN PENERBIT_TERBITAN pt  ON ir.penerbit_terbitan_id = pt.id 
                            WHERE pt.PENERBIT_ID='$id' AND ir.status = 'batal' ";

        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'title'){
                    $sqlFiltered .= " AND CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%'";
                    $sql .= " AND CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($advSearch["value"])."%'";
                }
                if($advSearch["param"] == 'tahun_terbit'){
                    $sqlFiltered .= " AND pt.TAHUN_TERBIT like '%".$advSearch["value"]."%'";
                    $sql .= " AND pt.TAHUN_TERBIT like '%".$advSearch["value"]."%'";
                }
                if($advSearch["param"] == 'kepeng'){
                    $sqlFiltered .= " AND (upper(pt.kepeng) like '%".strtoupper($advSearch["value"])."%' OR upper(pt.author) like '%".strtoupper($advSearch["value"])."%') ";
                    $sql .= " AND (upper(pt.kepeng) like '%".strtoupper($advSearch["value"])."%' OR upper(pt.author) like '%".strtoupper($advSearch["value"])."%') ";
                }
                if($advSearch["param"] == 'no_resi'){
                    $sqlFiltered .= " AND (CONCAT('WIN',upper(ir.noresi))) like 'WIN%".strtoupper($advSearch["value"])."%'";
                    $sql .= " AND (CONCAT('WIN',upper(ir.noresi))) like 'WIN%".strtoupper($advSearch["value"])."%'";
                }
            }
        }
        if($request->input('jenisTerbitan') !=''){
            $sqlFiltered .= " AND UPPER(ir.jenis) = '" . strtoupper($request->input('jenisTerbitan')) ."'";
            $sql .= " AND UPPER(ir.jenis) = '" . strtoupper($request->input('jenisTerbitan')) ."'";
        }
        if($request->input('sumber') !=''){
            $sqlFiltered .= " AND UPPER(ir.source) = '" . strtoupper($request->input('sumner')) ."'";
            $sql .= " AND UPPER(ir.source) = '" . strtoupper($request->input('sumber')) ."'";
        }
        $sql .= " ORDER BY CREATEDATE DESC ";

        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM ISBN_RESI WHERE PENERBIT_ID='$id' AND status='batal'", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $totalFiltered = kurl("get","getlistraw", "", $sqlFiltered, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $id = $val['ID'];
                $noresi = $val['NORESI'] ? $val['NORESI'] : $val['ID'];
               
                $source = $val['SOURCE'] == 'web' ? "<span class='badge badge-secondary'>".$val['SOURCE']."</span>" : "<span class='badge badge-primary'>".$val['SOURCE']."</span>";
                $jenis = $val['JENIS'] == 'lepas' ? "<span class='badge badge-light-success'>".$val['JENIS']."</span>" : "<span class='badge badge-light-warning'>".$val['JENIS']."</span>";
                $response['data'][] = [
                    $nomor,
                    '<a class="badge badge-primary h-20px m-1" href="#" onclick="pulihkanPermohonan('.$id.')">Pulihkan Permohonan</a>',
                    $noresi ."<br/>" .$source,
                    $val['TITLE'] . "<br/>$jenis",
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['BULAN_TERBIT'] . ' ' .$val['TAHUN_TERBIT'],
                    $val['MOHON_DATE']  
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

    function pulihkanPermohonan($id) 
    {
        $params = [
            ["name" => 'status', 'Value'=> 'permohonan'],
        ];
        $isbn_resi = kurl("get","getlistraw", "", "SELECT * FROM ISBN_RESI WHERE ID='$id'", "sql", "")["Data"]["Items"][0];
        //return $data['Status'];
       
        $res2 =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=ISBN_RESI&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($params)));
        
        //INSERT HISTORY PENERBIT TERBITAN
        $history = [
            [ "name" => "TABLENAME", "Value"=> "PENERBIT_TERBITAN"],
            [ "name" => "IDREF", "Value"=> $isbn_resi['PENERBIT_TERBITAN_ID']],
            [ "name" => "ACTION" , "Value"=> "Add"],
            //[ "name" => "ACTIONDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
            [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
            [ "name" => "ACTIONBY", "Value"=> session('penerbit')["USERNAME"]],
            [ "name" => "NOTE", "Value"=> "Permohonan dipulihkan " . $isbn_resi['NORESI']],
        ];
        $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
        return $res2;
    }
    function getDetail($id)
    {
        $detail = kurl("get","getlistraw", "", "SELECT pt.* FROM PENERBIT_TERBITAN pt JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id WHERE ir.ID='$id'", 'sql', '');
        
        $data = [
            'status' => $detail["Data"]["Items"][0]['JENIS'],
            'detail' => $detail["Data"]["Items"][0],
        ];
        return response()->json($data);
    }

}