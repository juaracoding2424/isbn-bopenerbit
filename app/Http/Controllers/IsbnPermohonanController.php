<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use \Illuminate\Http\UploadedFile;

class IsbnPermohonanController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
        ];
        return view('isbn_permohonan', $data);
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
                    WHERE pt.PENERBIT_ID='$id' AND (ir.status='' OR ir.status='permohonan' OR ir.status is NULL) ";
        $sqlFiltered = "SELECT count(ir.id) JUMLAH 
                            FROM ISBN_RESI ir 
                            JOIN PENERBIT_TERBITAN pt  ON ir.penerbit_terbitan_id = pt.id 
                            WHERE pt.PENERBIT_ID='$id' AND (ir.status='' OR ir.status='permohonan' OR ir.status is NULL) ";

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
        //\Log::info("SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end");
        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql) inner) outer WHERE rn >$start AND rn <= $end", 'sql', '')["Data"]["Items"];
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM ISBN_RESI WHERE PENERBIT_ID='$id' AND (status='' OR status='permohonan' OR status is NULL)", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $totalFiltered = kurl("get","getlistraw", "", $sqlFiltered, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                //\Log::info($val);
                $id = $val['ID'];
                $noresi = $val['NORESI'] ? $val['NORESI'] : $val['ID'];
                $source = $val['SOURCE'] == 'web' ? "<span class='badge badge-secondary'>".$val['SOURCE']."</span>" : "<span class='badge badge-primary'>".$val['SOURCE']."</span>";
                $jenis = $val['JENIS'] == 'lepas' ? "<span class='badge badge-light-success'>".$val['JENIS']."</span>" : "<span class='badge badge-light-warning'>".$val['JENIS']."</span>";
                //$jml_jilid = $val['JML_JILID_REQ'];
                //if($jml_jilid){
                //    $jilid_lepas = intval($jml_jilid) > 1 ? "terbitan jilid" : "terbitan lepas";
                //}else {
                //    $jilid_lepas = "terbitan lepas";
                //}
                $response['data'][] = [
                    $nomor,
                    '<a class="badge badge-info h-30px m-1" href="/penerbit/isbn/permohonan/detail/'.$noresi.'">Ubah Data</a><a class="badge badge-danger h-30px m-1" href="#" onclick="batalkanPermohonan('.$id.')">Batalkan Permohonan</a>',
                    $val['NORESI'] ."<br/>" .$source,
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

    function new()
    {
        return view('tambah_isbn');
    }

    function submit(Request $request)
    {
        $penerbit = session('penerbit');
        //\Log::info(request()->all());
        //try{   
            if(request('penerbit_terbitan_id') == ''){ //form baru
                if(request('title') != ''){
                    if($this->checkTitle(request('title'), $penerbit['ID']) > 0) {
                        return response()->json([
                            'status' => 'Failed',
                            'message'   => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                            'err' => ['title' => ['Judul buku sudah ada, Anda tidak dapat memohon ISBN baru dengan judul yang sama.']],
                        ], 422);
                    };
                }
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
                    'url.*' => 'required',
                    'file_dummy' => 'required|array|min:1',
                    'file_lampiran' => 'required|array|min:1',
                    'file_dummy.*' => 'required',
                    'file_lampiran.*' => 'required',
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
                    'url.*.required' => 'Anda belum mengisi URL/Link publikasi buku',
                    'file_dummy.required' => 'Anda belum mengunggah file dummy buku',
                    'file_lampiran.required' => 'Anda belum mengunggah file lampiran buku',
                    'file_dummy.*.required' => 'Anda belum mengunggah file dummy buku',
                    'file_lampiran.*.required' => 'Anda belum mengunggah file lampiran buku',
                ]);
            } else {
                $rules = [
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
                    'jml_hlm' => 'required',
                    //'status' => 'required',
                    'url.*' => 'required',
                    ];
                $messages = [
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
                    'jml_hlm.required' => 'Anda wajib mengisi jumlah halaman buku',
                    //'status.required' => 'Anda belum memilih jenis permintaan ISBN (Lepas/Jilid)',
                    'url.*.required' => 'Anda belum mengisi URL/Link publikasi buku',
                ];
                if(request('penerbit_isbn_masalah_id') != ''){
                    array_merge($rules, [
                            'file_lampiran' => 'required|array|min:1',
                            'file_lampiran.*' => 'required',
                    ]);
                    array_merge($messages ,[
                            'file_lampiran.required' => 'Anda belum mengunggah file lampiran buku yang sudah diperbaiki',
                            'file_lampiran.*.required' => 'Anda belum mengunggah file lampiran buku yang sudah diperbaiki',
                    ]);
                }
                if(request('status') == 'lepas') {
                    array_merge($rules, [
                        'jml_hlm.min' => 'min:40',
                    ]);
                    array_merge($messages ,[
                        'jml_hlm.min' => 'Menurut UNESCO, jumlah halaman buku paling sedikit terdiri dari 40 halaman, tidak termasuk bagian preliminaries dan postliminaries',
                    ]);
                }
                $validator = \Validator::make(request()->all(), $rules, $messages);
            }
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
                if(request('noresi') != ""){
                    $noresi = request('noresi');
                    if(strlen($noresi) < 19){
                        $noresi = now()->format('YmdHis') . strtoupper(str()->random(5));
                    }
                }
                $jumlah_jilid = intval(request('jumlah_jilid'));
                if(request('status') == 'jilid') { 
                    #--------------VALIDASI JUMLAH JILID----------------------------------------------------------------
                    /*if($jumlah_jilid < 2) {
                        return response()->json([
                            'status' => 'Failed',
                            'message'   => 'Gagal menyimpan data!',
                            'err' => ["jumlah_jilid" => ["Wajib memasukan minimal 2 data buku jika merupakan terbitan jilid"]],
                        ], 422);
                    }*/
                    #----------------END VALIDASI -------------------------------------------------------------------------
                    $jml_hlm = $jumlah_jilid . " jil";
                } else {
                    $jml_hlm = request('jml_hlm');
                }
                $urls = ""; $jilids = "";
                for($i = 0; $i < count(request('url')); $i++) {
                    $urls .= request('url')[$i];
                    $jilids .= "jilid " . $i+1;
                    if(isset(request('url')[$i+1])){
                        $urls .= "¦";
                        $jilids .= "¦";
                    }
                }
                
                $ListData = [
                        [ "name"=>"TITLE", "Value"=> request('title') ],
                        [ "name"=>"KEPENG", "Value"=> $authors ],
                        [ "name"=>"EDISI", "Value"=> request('edisi')],
                        [ "name"=>"SERI", "Value"=> request('seri')],
                        [ "name"=>"SINOPSIS", "Value"=> request('deskripsi') ],
                        [ "name"=>"JML_HLM", "Value"=> $jml_hlm ],
                        [ "name"=>"TAHUN_TERBIT", "Value"=> request('tahun_terbit') ],
                        [ "name"=>"BULAN_TERBIT", "Value"=> request('bulan_terbit') ],
                        [ "name"=>"JENIS_KELOMPOK", "Value"=> request('jenis_kelompok') ],
                        [ "name"=>"JENIS_MEDIA", "Value"=> request('jenis_media') ],
                        [ "name"=>"JENIS_TERBITAN", "Value"=> request('jenis_terbitan') ],
                        [ "name"=>"JENIS_PENELITIAN", "Value"=> request('jenis_penelitian') ],
                        [ "name"=>"JENIS_PUSTAKA", "Value"=> request('jenis_pustaka') ],
                        [ "name"=>"JENIS_KATEGORI", "Value"=> request('jenis_kategori') ],
                        [ "name"=>"KETEBALAN", "Value"=> request('ketebalan')],
                        
                ];
                $IsbnResi = [
                    [ "name" =>"NORESI", "Value" => $noresi ],
                    [ "name" => "JENIS", "Value" => request('status')],
                    [ "name" =>"JML_JILID_REQ", "Value" => $jumlah_jilid],
                    [ "name" =>"LINK_BUKU", "Value" => $urls ],
                ];
                
                if($jumlah_jilid > 1){
                    array_push($IsbnResi, 
                        [ "name"=>"KETERANGAN_JILID", "Value"=> $jilids ]
                    );
                }
                if(request('penerbit_terbitan_id') != ''){
                    // EDIT DATA PERMOHONAN
                    array_push($ListData, 
                            [ "name"=>"UPDATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                            [ "name"=>"UPDATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"UPDATETERMINAL", "Value"=> \Request::ip()]
                    );
                    if(request('penerbit_isbn_masalah_id') != ''){
                        array_push($IsbnResi, 
                            [ "name"=>"STATUS", "Value"=> "permohonan"], //ketika bermasalah, dan diupdate jadi permohonan sehingga balik lagi ke permohonan
                        );
                    }
                    $id = request('penerbit_terbitan_id');
                    $id_resi = request('isbn_resi_id');

                    // UPDATE KE TABEL PENERBIT_TERBITAN
                    $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=PENERBIT_TERBITAN&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));

                    // UPDATE KE TABEL ISBN_RESI
                    $res2 =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=ISBN_RESI&id=$id_resi&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($IsbnResi)));
                } else {
                    // TAMBAH DATA PERMOHONAN
                    array_push($ListData, 
                            [ "name"=>"MOHON_DATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"PENERBIT_ID", "Value"=> session('penerbit')["ID"] ], 
                            [ "name"=>"IS_KDT_VALID", "Value"=> '0' ],
                            [ "name"=>"CREATEBY", "Value"=> session('penerbit')["USERNAME"]], 
                            [ "name"=>"CREATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"CREATETERMINAL", "Value"=> \Request::ip()]
                    );
                    
                    // INSERT KE TABEL PENERBIT_TERBITAN
                    $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=PENERBIT_TERBITAN&issavehistory=1&ListAddItem=" . urlencode(json_encode($ListData)));
                    $id = $res['Data']['ID'];

                    // INSERT KE TABEL ISBN_RESI
                    array_push($IsbnResi, 
                        [ "name" => "MOHON_DATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                        [ "name" => "PENERBIT_ID", "Value"=> session('penerbit')["ID"] ] ,
                        [ "name" => "PENERBIT_TERBITAN_ID", "Value" => $id],
                        [ "name" => "STATUS", "Value"=> "permohonan"],
                        [ "name" => "CREATEBY", "Value"=> session('penerbit')["USERNAME"]], 
                        [ "name" => "CREATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                        [ "name" => "CREATETERMINAL", "Value"=> \Request::ip()]
                    );
                    $res2 =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=ISBN_RESI&issavehistory=1&ListAddItem=" . urlencode(json_encode($IsbnResi)));
                    $id_resi = $res2['Data']['ID'];
                    
                }
                /* ------------------------------------------------ simpan file ------------------------------------------*/
                if(request('status') == 'lepas') {
                    $file = [
                        'file_dummy' => $request->input('file_dummy')[0] ?? null,
                        'file_lampiran' => $request->input('file_lampiran')[0] ?? null,
                        'file_cover' => $request->input('file_cover')[0] ?? null,
                    ];
                    //\Log::info($request->input('file_dummy')[0]);
                    if(request('penerbit_terbitan_id') != '' && isset($request->input('file_dummy')[0])){
                        //ganti file dummy kalau ada
                        if(isset($request->input('file_dummy_id')[0])) {
                            $params = [
                                'penerbitisbnfile' => $request->input('file_dummy_id')[0],
                                'actionby' => session('penerbit')['USERNAME'],
                                'terminal' => \Request::ip()
                            ];
                            kurl("post", "deletefilelampiran",'', '', $params);
                        }
                    }
                    if(request('penerbit_terbitan_id') != '' && isset($request->input('file_cover')[0])){
                        //ganti file cover kalau ada
                        if(isset($request->input('file_cover_id')[0])) {
                            $params = [
                                'penerbitisbnfile' => $request->input('file_cover_id')[0],
                                'actionby' => session('penerbit')['USERNAME'],
                                'terminal' => \Request::ip()
                            ];
                            kurl("post", "deletefilelampiran",'', '', $params);
                        }
                    }
                    if(request('penerbit_isbn_masalah_id' != '')) {
                        //kalau bermasalah, lampirannya ga usah dihapus
                        $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), '', $id_resi, true);    
                    } else {
                        //kalau mau ganti lampiran permohonan 
                        if(request('penerbit_isbn_masalah') == '' && isset($request->input('file_lampiran')[0])) {
                            if(isset($request->input('file_lampiran_id')[0])) {
                                $params = [
                                    'penerbitisbnfile' => $request->input('file_lampiran_id')[0],
                                    'actionby' => session('penerbit')['USERNAME'],
                                    'terminal' => \Request::ip()
                                ];
                                kurl("post", "deletefilelampiran",'', '', $params);
                            }
                        }
                        $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), '', $id_resi);    
                    }
                    

                } else {     
                    //upload file jilid               
                    for($i = 0; $i < $jumlah_jilid; $i++){
                        $file = [
                            'file_dummy' => $request->input('file_dummy')[$i] ?? null,
                            'file_lampiran' => $request->input('file_lampiran')[$i] ?? null,
                            'file_cover' => $request->input('file_cover')[$i] ?? null
                        ];
                        if(request('penerbit_terbitan_id') != '' && isset($request->input('file_dummy')[$i])){
                            //ganti file dummy kalau ada
                            if(isset($request->input('file_dummy_id')[$i])) {
                                $params = [
                                    'penerbitisbnfile' => $request->input('file_dummy_id')[$i],
                                    'actionby' => session('penerbit')['USERNAME'],
                                    'terminal' => \Request::ip()
                                ];
                                kurl("post", "deletefilelampiran",'', '', $params);
                            }
                        }
                        if(request('penerbit_terbitan_id') != '' && isset($request->input('file_cover')[$i])){
                            //ganti file cover kalau ada
                            if(isset($request->input('file_cover_id')[$i])) {
                                $params = [
                                    'penerbitisbnfile' => $request->input('file_cover_id')[$i],
                                    'actionby' => session('penerbit')['USERNAME'],
                                    'terminal' => \Request::ip()
                                ];
                                kurl("post", "deletefilelampiran",'', '', $params);
                            }
                        }
                        if(request('penerbit_isbn_masalah_id' != '')) {
                            //kalau bermasalah, lampirannya ga usah dihapus
                            $keterangan = "perbaikan jilid ke- " . $i + 1;   
                            $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), $keterangan, $id_resi, true);    
                        } else {
                            //kalau mau ganti lampiran permohonan 
                            if(request('penerbit_isbn_masalah') == '' && isset($request->input('file_lampiran')[$i])) {
                                if(isset($request->input('file_lampiran_id')[$i])) {
                                    $params = [
                                        'penerbitisbnfile' => $request->input('file_lampiran_id')[$i],
                                        'actionby' => session('penerbit')['USERNAME'],
                                        'terminal' => \Request::ip()
                                    ];
                                    kurl("post", "deletefilelampiran",'', '', $params);
                                }
                            }
                            $keterangan = "jilid ke- " . $i + 1;   
                            $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), $keterangan, $id_resi);     
                        }                   
                    }
                }

                //\Log::info($res);
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Data permohonan berhasil disimpan.',
                    'noresi' => $noresi
                ], 200);
            }
        /*} catch(\Exception $e){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data permohonan gagal disimpan. Server Error!',
                'noresi' => $e->getMessage()
            ], 500);
        }*/
    }

    function cancel($noresi)
    {
        $data =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=" . urlencode('SELECT * FROM PENERBIT_TERBITAN WHERE NORESI=' . $noresi));
    }

    function rollback_permohonan($id) 
    {
        $params = [
            ["name" => 'status', 'Value'=> 'batal'],
        ];
        //$data = kurl('get','update', 'ISBN_RESI', '', '' , $params);
        //return $data['Status'];
        \Log::info(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=ISBN_RESI&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($params)));
        $res2 =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=ISBN_RESI&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($params)));
        \Log::info($res2);
        return $res2;
    }

    //send file lampiran, dummy, cover
    function upload_file($file, $penerbit, $terbitan_id, $ip, $keterangan, $resi_id,$is_masalah = false) 
    {
        $gagal = [];

        if($is_masalah){
            //file lampiran
            if ($file['file_lampiran']) {
                $filePath_one = public_path('file_tmp_upload/'.$file['file_lampiran']);
                if (File::exists($filePath_one)) {
                    $file_one = new UploadedFile(
                        $filePath_one,
                        $file['file_lampiran'],
                        File::mimeType($filePath_one),
                        null,
                        true
                    );
                    kurl_upload('post', $penerbit, $terbitan_id, "lampiran_pending", $file_one, $ip, $keterangan, $resi_id);
                }
            }
        } else {
            //file lampiran
            if ($file['file_lampiran']) {
                $filePath_one = public_path('file_tmp_upload/'.$file['file_lampiran']);
                if (File::exists($filePath_one)) {
                    $file_one = new UploadedFile(
                        $filePath_one,
                        $file['file_lampiran'],
                        File::mimeType($filePath_one),
                        null,
                        true
                    );
                    kurl_upload('post', $penerbit, $terbitan_id, "lampiran_permohonan", $file_one, $ip, $keterangan, $resi_id);
                }
            } 
        }
        //file dummy
        if ($file['file_dummy']) {
            $filePath_two = public_path('file_tmp_upload/'.$file['file_dummy']);
            if (File::exists($filePath_two)) {
                $file_two = new UploadedFile(
                    $filePath_two,
                    $file['file_dummy'],
                    File::mimeType($filePath_two),
                    null,
                    true
                );
                kurl_upload('post', $penerbit, $terbitan_id, "dummy_buku", $file_two, $ip, $keterangan);
            }
        }
        //file cover
        if ($file['file_cover']) {
            $filePath_3 = public_path('file_tmp_upload/'.$file['file_cover']);
            if (File::exists($filePath_3)) {
                $file_3 = new UploadedFile(
                    $filePath_3,
                    $file['file_cover'],
                    File::mimeType($filePath_3),
                    null,
                    true
                );
                kurl_upload('post', $penerbit, $terbitan_id, "cover", $file_3, $ip, $keterangan);
            }
        }
    }


    function detail($noresi)
    {
        $detail = kurl("get","getlistraw", "", "SELECT ir.id, ir.penerbit_terbitan_id, pt.title, pt.author, pt.kepeng,pt.bulan_terbit, pt.tahun_terbit, ir.noresi, ir.createdate, ir.mohon_date,  
            ir.jml_jilid_req, ir.jenis, ir.status, ir.link_buku, ir.keterangan_jilid, pt.jenis_media, pt.jenis_kategori, pt.jenis_kelompok, pt.jenis_pustaka,  pt.jenis_terbitan,
            pt.sinopsis, pt.jml_hlm, pt.ketebalan, pt.edisi, pt.seri, pt.is_kdt_valid, pt.jenis_penelitian, pt.jenis_kelompok, ir.createdate, ir.createterminal, ir.createby         
          FROM  ISBN_RESI ir JOIN PENERBIT_TERBITAN pt ON ir.penerbit_terbitan_id = pt.id WHERE NORESI='$noresi'", 'sql', '');


        if(!isset($detail["Data"]["Items"][0])) {
            $detail = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_TERBITAN WHERE ID=$noresi", 'sql', '');
        }
       
      
        $id = $detail['Data']['Items'][0]['ID'];
        $id_penerbit_terbitan = $detail['Data']["Items"][0]["PENERBIT_TERBITAN_ID"];
        //\Log::info($id_penerbit_terbitan);
        $file = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_ISBN_FILE WHERE PENERBIT_TERBITAN_ID='$id_penerbit_terbitan'", 'sql', '');
        //$file = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_ISBN_FILE WHERE ISBN_RESI_ID='$id'", 'sql', '');
        $masalah = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_ISBN_MASALAH WHERE PENERBIT_TERBITAN_ID='$id_penerbit_terbitan' AND IS_SOLVE=0 ", 'sql', '');
        $data = [
            'jenis' =>  $detail["Data"]["Items"][0]["JENIS"],
            'status' =>  $detail["Data"]["Items"][0]["STATUS"],
            'detail' => $detail["Data"]["Items"][0],
            'noresi' => $noresi,
            'file' => $file,
            'masalah' => $masalah,
        ];
        return view('edit_isbn', $data);
    }

    function getDetail($id)
    {
        $detail = kurl("get","getlistraw", "", "SELECT pt.* FROM PENERBIT_TERBITAN pt JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id WHERE ir.ID='$id'", 'sql', '');
       
        if(intval($detail["Data"]["Items"][0]["JML_JILID"]) > 1){
            $status = "jilid";
        } else {
            $status = "lepas";
        }        
        $data = [
            'status' => $status,
            'detail' => $detail["Data"]["Items"][0],
        ];
        return response()->json($data);
    }

    function getFile($id)
    {
        $file = Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=" . urlencode('SELECT * FROM PENERBIT_ISBN_FILE WHERE PENERBIT_TERBITAN_ID=' . $id))["Data"]["Items"];
        return response()->json($file);
    }
    
    function getJilidLengkap()
    {
        $id = session('penerbit')['ID'];
        $sql = "SELECT pi.isbn_no, pt.title 
                FROM PENERBIT_ISBN pi 
                JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id 
                WHERE pi.keterangan_jilid LIKE '%lengkap%' 
                AND pi.penerbit_id = $id";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '');
        return response()->json($data);
    }

    function checkTitle($title, $id)
    {
        $title = strtoupper(preg_replace("/[^a-zA-Z0-9]/", "", $title));
        $count = kurl("get","getlistraw", "", "SELECT count(*) JML FROM PENERBIT_TERBITAN WHERE  REGEXP_REPLACE(UPPER(TITLE), '[^[:alnum:]]', '') = '$title' AND penerbit_id='$id'", 'sql', '')["Data"]["Items"][0]["JML"];
        return intval($count);
    }

    function deleteFile($id)
    {
        $params = [
            'penerbitisbnfileid' => $id,
            'actionby' => session('penerbit')['USERNAME'],
            'terminal' => \Request::ip()
        ];
        kurl("post", "deletefilelampiran",'', '','', $params);
        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
