<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IsbnPermohonanController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => $this->penerbit["NAME"]
        ];
        return view('isbn_permohonan', $data);
    }
    public function datatable(Request $request)
    {
        $whereLike = [
            'ID',
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
        $id = $this->penerbit['ID'];
        
        $start = $start;
        $end = $start + $length;

        $sql  = "SELECT *
                    FROM PENERBIT_TERBITAN pt
                    WHERE pt.PENERBIT_ID='$id' AND pt.status='permohonan'";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM PENERBIT_TERBITAN WHERE PENERBIT_ID='$id' AND status='permohonan'";

        foreach($request->input('advSearch') as $advSearch){
            if($advSearch["value"] != '') {
                if($advSearch["param"] == 'title'){
                    $sqlFiltered .= " AND lower(pt.TITLE) like '%".strtolower($advSearch["value"])."%'";
                    $sql .= " AND lower(pt.TITLE) like '%".strtolower($advSearch["value"])."%'";
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
        $queryData = Http::get(config('app.inlis_api_url'), [
                "token" => config('app.inlis_api_token'),
                "op" => "getlistraw",
                "sql" => "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end"
            ])->json()["Data"]["Items"];

        $totalData = Http::get(config('app.inlis_api_url'), [
                "token" => config('app.inlis_api_token'),
                "op" => "getlistraw",
                "sql" => "SELECT count(*) JUMLAH FROM PENERBIT_TERBITAN WHERE PENERBIT_ID='$id' AND status='permohonan'"
            ])->json()["Data"]["Items"][0]["JUMLAH"];

        $totalFiltered = Http::get(config('app.inlis_api_url'), [
                "token" => config('app.inlis_api_token'),
                "op" => "getlistraw",
                "sql" => $sqlFiltered
            ])->json()["Data"]["Items"][0]['JUMLAH'];
        
        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                $id = $val['ID'];
                $response['data'][] = [
                    $nomor,
                    $val['TITLE'],
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['TAHUN_TERBIT'],
                    $val['MOHON_DATE'],
                    '<a class="badge badge-info h-30px m-1" href="tambah_isbn.php">Ubah Data</a><a class="badge badge-danger h-30px m-1" href="#" onclick="batalkanPermohonan('.$id.')">Batalkan Permohonan</a>',
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

    public function new()
    {
        $data = [
            'nama_penerbit' => $this->penerbit["NAME"]
        ];
        return view('tambah_isbn');
    }

    public function submit(Request $request)
    {
        //\Log::info(request()->all());
        try{   
            $validator = \Validator::make(request()->all(),[
            'title' => 'required',
            'namaPengarang' => 'required|array|min:1',
            'namaPengarang.0' => 'required',
            'provinsi' => 'required',
            'kabkot' => 'required',
            'jenis_media' => 'required',
            'jenis_terbitan' => 'required',
            'jenis_kelompok' => 'required',
            'jenis_penelitian' => 'required',
            'jenis_kategori' => 'required',
            'jenis_pustaka' => 'required',
            'deskripsi' => 'required|min:100',
            'status' => 'required',
            'url.0' => 'required',
            ],[
                'title.required' => 'Anda belum mengisi judul buku',
                'namaPengarang.0.required' => 'Anda belum mengisi nama pengarang/penulis pertama',
                'provinsi.required' => 'Anda belum mengisi provinsi terbit buku',
                'kabkot.required' => 'Anda belum mengisi kota terbit buku',
                'jenis_media.required' => 'Anda belum mengisi jenis media terbitan buku',
                'jenis_terbitan.required' => 'Anda belum mengisi jenis terbitan buku',
                'jenis_kelompok.required' => 'Anda belum mengisi kelompok pembaca buku',
                'jenis_penelitian.required' => 'Anda belum mengisi jenis penilitian',
                'jenis_kategori.required' => 'Anda belum mengisi kategori buku terjemahan/non terjemahan',
                'jenis_pustaka.required' => 'Anda belum mengisi jenis pustaka (fiksi/non fiksi)',
                'deskripsi.required' => 'Anda belum mengisi abstrak/deskripsi buku',
                'deskripsi.min' => 'Abstrak/deskripsi buku minimal terdiri dari 100 karakter',
                'status.required' => 'Anda belum memilih jenis permintaan ISBN (Lepas/Jilid)',
                'url.0.required' => 'Anda belum mengisi URL/Link publikasi buku',
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 'Failed',
                    'message'   => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                    'err' => $validator->errors(),
                ], 422);
            } else {
                $authors = "";
                for($i = 0; $i < count(request('namaPengarang')); $i++) {
                    $authors .= request('authorRole')[$i] .", " . request('namaPengarang')[$i];
                    if(isset(request('authorRole')[$i+1])){
                        $authors .= ";";
                    }
                }
                $noresi = now()->format('YmdHis') . strtoupper(str()->random(5));
                if(request('status') == 'lepas') {
                    $addData = [
                        [ "name"=>"NORESI", "Value"=> $noresi ], // example : 202409020449131FPI3
                        [ "name"=>"TITLE", "Value"=> request('title') ],
                        [ "name"=>"KEPENG", "Value"=> $authors ],
                        [ "name"=>"EDISI", "Value"=> request('edisi')[0] ],
                        [ "name"=>"SERI", "Value"=> request('seri')[0]],
                        [ "name"=>"SINOPSIS", "Value"=> request('deskripsi') ],
                        [ "name"=>"JML_HLM", "Value"=> request('jml_hlm')[0] ],
                        [ "name"=>"KETEBALAN", "Value"=> request('ketebalan')[0] ],
                        [ "name"=>"TAHUN_TERBIT", "Value"=> request('tahun_terbit') ],
                        [ "name"=>"BULAN_TERBIT", "Value"=> request('bulan_terbit') ],
                        [ "name"=>"JENIS_KELOMPOK", "Value"=> request('jenis_kelompok') ],
                        [ "name"=>"JENIS_MEDIA", "Value"=> request('jenis_media') ],
                        [ "name"=>"JENIS_TERBITAN", "Value"=> request('jenis_terbitan') ],
                        [ "name"=>"JENIS_PENELITIAN", "Value"=> request('jenis_penelitian') ],
                        [ "name"=>"JENIS_PUSTAKA", "Value"=> request('jenis_pustaka') ],
                        [ "name"=>"JENIS_KATEGORI", "Value"=> request('jenis_kategori') ],
                        [ "name"=>"MOHON_DATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                        [ "name"=>"LINK_BUKU", "Value"=> request('url')[0] ],
                        [ "name"=>"PENERBIT_ID", "Value"=> '2159312' ], //erlangga
                        [ "name"=>"IS_KDT_VALID", "Value"=> '0' ],
                        [ "name"=>"CREATEBY", "Value"=> 'erlanggamahmeru'], //nama user penerbit
                        [ "name"=>"CREATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                        [ "name"=>"CREATETERMINAL", "Value"=> \Request::ip()],
                    ];
                    $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=PENERBIT_TERBITAN&issavehistory=1&ListAddItem=" . urlencode(json_encode($addData)));
                } else {
                    $jumlah_jilid = intval(request('jumlah_jilid'));
                    for($i = 0; $i < $jumlah_jilid; $i++){
                        $addData = [
                            [ "name"=>"NORESI", "Value"=> $noresi ], // example : 202409020449131FPI3
                            [ "name"=>"TITLE", "Value"=> request('title') . ' Jilid ('.$i. ')' ],
                            [ "name"=>"KEPENG", "Value"=> $authors ],
                            [ "name"=>"EDISI", "Value"=> request('edisi')[$i] ],
                            [ "name"=>"SERI", "Value"=> request('seri')[$i]],
                            [ "name"=>"SINOPSIS", "Value"=> request('deskripsi') ],
                            [ "name"=>"JML_HLM", "Value"=> request('jml_hlm')[$i] ],
                            [ "name"=>"KETEBALAN", "Value"=> request('ketebalan')[$i] ],
                            [ "name"=>"TAHUN_TERBIT", "Value"=> request('tahun_terbit') ],
                            [ "name"=>"BULAN_TERBIT", "Value"=> request('bulan_terbit') ],
                            [ "name"=>"JENIS_KELOMPOK", "Value"=> request('jenis_kelompok') ],
                            [ "name"=>"JENIS_MEDIA", "Value"=> request('jenis_media') ],
                            [ "name"=>"JENIS_TERBITAN", "Value"=> request('jenis_terbitan') ],
                            [ "name"=>"JENIS_PENELITIAN", "Value"=> request('jenis_penelitian') ],
                            [ "name"=>"JENIS_PUSTAKA", "Value"=> request('jenis_pustaka') ],
                            [ "name"=>"JENIS_KATEGORI", "Value"=> request('jenis_kategori') ],
                            [ "name"=>"MOHON_DATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"LINK_BUKU", "Value"=> request('url')[$i] ],
                            [ "name"=> "JML_JILID", "Value" => $jumlah_jilid],
                            [ "name"=>"PENERBIT_ID", "Value"=> '2159312' ], //erlangga
                            [ "name"=>"IS_KDT_VALID", "Value"=> '0' ],
                            [ "name"=>"CREATEBY", "Value"=> 'erlanggamahmeru'], //nama user penerbit
                            [ "name"=>"CREATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"CREATETERMINAL", "Value"=> \Request::ip()],
                        ];
                        $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=PENERBIT_TERBITAN&issavehistory=1&ListAddItem=" . urlencode(json_encode($addData)));
                    }
                }
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Data permohonan berhasil disimpan.',
                    'noresi' => $noresi
                ], 200);
            }
        } catch(\Exception $e){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data permohonan gagal disimpan. Server Error!',
                'noresi' => $e->getMessage()
            ], 500);
        }
    }

    public function cancel($noresi)
    {
        $data =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=" . urlencode('SELECT * FROM PENERBIT_TERBITAN WHERE NORESI=' . $noresi));
    }
}
