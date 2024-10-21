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
                        ir.mohon_date, ir.jml_jilid_req, ir.jenis, ir.status, ir.source , pt.jenis_media 
                    FROM ISBN_RESI ir 
                    JOIN PENERBIT_TERBITAN pt  ON ir.penerbit_terbitan_id = pt.id  
                    WHERE pt.PENERBIT_ID='$id' AND (ir.status='' OR ir.status='permohonan' OR ir.status is NULL OR ir.status='lanjutan') ";
        $sqlFiltered = "SELECT count(ir.id) JUMLAH 
                            FROM ISBN_RESI ir 
                            JOIN PENERBIT_TERBITAN pt  ON ir.penerbit_terbitan_id = pt.id 
                            WHERE pt.PENERBIT_ID='$id' AND (ir.status='' OR ir.status='permohonan' OR ir.status is NULL OR ir.status='lanjutan') ";

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
                if($advSearch["param"] == 'jenis_media'){
                    $sqlFiltered .= " AND pt.jenis_media = '".$advSearch["value"]."'";
                    $sql .= " AND pt.jenis_media = '".$advSearch["value"]."'";  
                }
            }
        }
        if($request->input('jenisMedia') !=''){
            $sqlFiltered .= " AND pt.jenis_media = '".$request->input('jenisMedia')."'";
            $sql .= " AND pt.jenis_media = '".$request->input('jenisMedia')."'";  
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

        $queryData = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM rn, inner.* FROM ($sql)  inner WHERE rownum <=$end) outer WHERE rn >$start", 'sql', '')["Data"]["Items"];
        $totalData = kurl("get","getlistraw", "", "SELECT count(*) JUMLAH FROM ISBN_RESI WHERE PENERBIT_ID='$id' AND (status='' OR status='permohonan' OR status is NULL)", 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $totalFiltered = kurl("get","getlistraw", "", $sqlFiltered, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        $response['data'] = [];
        if (count($queryData) > 0) {
            $nomor = $start + 1;
            foreach ($queryData as $val) {
                switch($val['JENIS_MEDIA']){
                    case '1': $jenis_media = 'Cetak'; break;
                    case '2': $jenis_media = 'Digital (PDF)'; break;
                    case '3': $jenis_media = 'Digital (EPUB)'; break;
                    case '4': $jenis_media = 'Audio Book'; break;
                    case '5': $jenis_media = 'Audio Visual Book'; break;
                    default: $jenis_media = ''; break;
                }
                $id = $val['ID'];
                $noresi = $val['NORESI'] ? $val['NORESI'] : $val['ID'];
                if($val['STATUS'] == 'lanjutan'){
                    $noresi .= "<span class='badge badge-dark'>JILID-LANJUTAN</span>";
                }
                $source = $val['SOURCE'] == 'web' ? "<span class='badge badge-secondary'>".$val['SOURCE']."</span>" : "<span class='badge btn-primary'>".$val['SOURCE']."</span>";
                $jenis = $val['JENIS'] == 'lepas' ? "<span class='badge badge-light-success'>".$val['JENIS']."</span>" : "<span class='badge badge-light-warning'>".$val['JENIS']."</span>";
                $action =  '<a class="badge badge-light-info h-20px m-1" href="'.url('/penerbit/isbn/permohonan/detail/'.$val['NORESI']) . '">Lihat Data</a><a class="badge badge-light-danger h-20px m-1" href="#" onclick="batalkanPermohonan('.$id.')">Batalkan Permohonan</a>';
                if(session('penerbit')['IS_LOCK'] == '1') {
                    $action = "";
                }
                $response['data'][] = [
                    $nomor,
                    $action,
                    $noresi ."<br/>" .$source,
                    $val['TITLE'] . "<br/>$jenis <span class='text-success'><i>$jenis_media</i></span>",
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
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
        ];
        if(session('penerbit')['IS_LOCK'] == '1') {
            return view('akun_lock', $data);
        }
        $checkKuota = checkKuota(session('penerbit')['ID']);

        if($checkKuota[0] == true){ //true kuota masih ada
            return view('tambah_isbn');
        } else {
            return view('kuota_habis', [ 'kuota' => $checkKuota]);
        }
    }

    function submit(Request $request)
    {
        $penerbit = session('penerbit');
        try{   
            if(session('penerbit')['IS_LOCK'] != '1') {
                if(request('penerbit_terbitan_id') == ''){ //form baru
                    if(request('isbn-jilid') == ''){
                        $validator = \Validator::make(request()->all(),[
                            'title' => 'required|title_exists:' . $penerbit['ID'],
                            'namaPengarang' => 'required|array|min:1',
                            'namaPengarang.0' => 'required',
                            'tahun_terbit' => 'required|tahun_terbit_min',
                            'bulan_terbit' => 'bulan_terbit_min:' . $request->input('tahun_terbit'),
                            'tempat_terbit' => 'required',
                            'jenis_media' => 'required',
                            'jenis_kelompok' => 'required',
                            'jenis_kategori' => 'required',
                            'jenis_pustaka' => 'required',
                            'deskripsi' => 'required|min:50',
                            'status' => 'required',
                            'url.*' => 'required',
                            'file_dummy' => 'required|array|min:1',
                            'file_lampiran' => 'required|array|min:1',
                            'file_dummy.*' => 'required',
                            'file_lampiran.*' => 'required',
                            //'pengajuan_kdt' => 'required'
                            ],[
                            'title.required' => 'Anda belum mengisi judul buku',
                            'title.title_exists' => 'Judul buku sudah ada, Anda tidak dapat memohon ISBN baru dengan judul yang sama.',
                            'namaPengarang.0.required' => 'Anda belum mengisi nama pengarang/penulis pertama',
                            //'provinsi.required' => 'Anda belum mengisi provinsi terbit buku',
                            //'kabkot.required' => 'Anda belum mengisi kota terbit buku',
                            'tahun_terbit.required' => 'Anda belum mengisi tahun terbit buku',
                            //'bulan_terbit.required' => 'Anda belum mengisi bulan terbit buku',
                            'tempat_terbit.required' => 'Anda belum mengisi tempat terbit buku',
                            'jenis_media.required' => 'Anda belum mengisi jenis media terbitan buku',
                            //'jenis_terbitan.required' => 'Anda belum mengisi jenis terbitan buku',
                            'jenis_kelompok.required' => 'Anda belum mengisi kelompok pembaca buku',
                            //'jenis_penelitian.required' => 'Anda belum mengisi jenis penilitian',
                            'jenis_kategori.required' => 'Anda belum mengisi kategori buku terjemahan/non terjemahan',
                            'jenis_pustaka.required' => 'Anda belum mengisi jenis pustaka (fiksi/non fiksi)',
                            'deskripsi.required' => 'Anda belum mengisi abstrak/deskripsi buku',
                            'deskripsi.min' => 'Abstrak/deskripsi buku minimal terdiri dari 50 karakter',
                            'status.required' => 'Anda belum memilih jenis permintaan ISBN (Lepas/Jilid)',
                            'url.*.required' => 'Anda belum mengisi URL/Link publikasi buku',
                            'file_dummy.required' => 'Anda belum mengunggah file dummy buku',
                            'file_lampiran.required' => 'Anda belum mengunggah file lampiran buku',
                            'file_dummy.*.required' => 'Anda belum mengunggah file dummy buku',
                            'file_lampiran.*.required' => 'Anda belum mengunggah file lampiran buku',
                            'tahun_terbit.tahun_terbit_min' => 'Tahun terbit yang Anda masukan tidak boleh kurang dari tahun ' . date('Y'),
                            'bulan_terbit.bulan_terbit_min' => 'Bulan terbit yang Anda masukan tidak boleh kurang dari bulan ' . date('m-Y'),
                            //'pengajuan_kdt.required' => 'Anda belum memilih apakah akan mengajukan KDT atau tidak',
                        ]);
                    } else { //permohonan jilid lanjutan
                        $validator = \Validator::make(request()->all(),[
                            'title' => 'required|title_exists:' . $penerbit['ID']. ',' . request('isbn-jilid'),
                            'namaPengarang' => 'required|array|min:1',
                            'namaPengarang.0' => 'required',
                            //'provinsi' => 'required',
                            //'kabkot' => 'required',
                            'tahun_terbit' => 'required',
                            //'bulan_terbit' => 'required',
                            'tempat_terbit' => 'required',
                            'jenis_media' => 'required',
                            //'jenis_terbitan' => 'required',
                            'jenis_kelompok' => 'required',
                            //'jenis_penelitian' => 'required',
                            'jenis_kategori' => 'required',
                            'jenis_pustaka' => 'required',
                            'deskripsi' => 'required|min:50',
                            //'status' => 'required',
                            'url.*' => 'required',
                            'file_dummy' => 'required|array|min:1',
                            'file_lampiran' => 'required|array|min:1',
                            'file_dummy.*' => 'required',
                            'file_lampiran.*' => 'required',
                            //'pengajuan_kdt'=>'required'
                            ],[
                            'title.required' => 'Anda belum mengisi judul buku',
                            'title.title_exists' => 'Judul buku sudah ada, Anda tidak dapat memohon ISBN baru dengan judul yang sama.',
                            'namaPengarang.0.required' => 'Anda belum mengisi nama pengarang/penulis pertama',
                            //'provinsi.required' => 'Anda belum mengisi provinsi terbit buku',
                            //'kabkot.required' => 'Anda belum mengisi kota terbit buku',
                            'tempat_terbit.required' => 'Anda belum mengisi tempat terbit buku',
                            //'bulan_terbit.required' => 'Anda belum mengisi bulan terbit buku',
                            'jenis_media.required' => 'Anda belum mengisi jenis media terbitan buku',
                            //'jenis_terbitan.required' => 'Anda belum mengisi jenis terbitan buku',
                            'jenis_kelompok.required' => 'Anda belum mengisi kelompok pembaca buku',
                            //'jenis_penelitian.required' => 'Anda belum mengisi jenis penilitian',
                            'jenis_kategori.required' => 'Anda belum mengisi kategori buku terjemahan/non terjemahan',
                            'jenis_pustaka.required' => 'Anda belum mengisi jenis pustaka (fiksi/non fiksi)',
                            'deskripsi.required' => 'Anda belum mengisi abstrak/deskripsi buku',
                            'deskripsi.min' => 'Abstrak/deskripsi buku minimal terdiri dari 50 karakter',
                            //'status.required' => 'Anda belum memilih jenis permintaan ISBN (Lepas/Jilid)',
                            'url.*.required' => 'Anda belum mengisi URL/Link publikasi buku',
                            'file_dummy.required' => 'Anda belum mengunggah file dummy buku',
                            'file_lampiran.required' => 'Anda belum mengunggah file lampiran buku',
                            'file_dummy.*.required' => 'Anda belum mengunggah file dummy buku',
                            'file_lampiran.*.required' => 'Anda belum mengunggah file lampiran buku',
                            //'pengajuan_kdt.required' => 'Anda belum memilih apakah akan mengajukan KDT atau tidak',
                        ]);
                    }
                } else { //form perbaikan
                    $rules = [
                        'title' => 'required|title_exists:' . $penerbit['ID'] . ',' . request('penerbit_terbitan_id'),
                        'namaPengarang' => 'required|array|min:1',
                        'namaPengarang.0' => 'required',
                        'tempat_terbit' => 'required',
                        'jenis_media' => 'required',
                        //'jenis_terbitan' => 'required',
                        'jenis_kelompok' => 'required',
                        //'jenis_penelitian' => 'required',
                        'jenis_kategori' => 'required',
                        'jenis_pustaka' => 'required',
                        'deskripsi' => 'required|min:50',
                        'url.*' => 'required',
                        //'pengajuan_kdt'=>'required'
                        ];
                    $messages = [
                        'title.required' => 'Anda belum mengisi judul buku',
                        'title.title_exists' => 'Judul buku sudah ada, Anda tidak dapat memohon ISBN dengan judul yang sama.',
                        'namaPengarang.0.required' => 'Anda belum mengisi nama pengarang/penulis pertama',
                        'tempat_terbit.required' => 'Anda belum mengisi tempat terbit buku',
                        'jenis_media.required' => 'Anda belum mengisi jenis media terbitan buku',
                        //'jenis_terbitan.required' => 'Anda belum mengisi jenis terbitan buku',
                        'jenis_kelompok.required' => 'Anda belum mengisi kelompok pembaca buku',
                        //'jenis_penelitian.required' => 'Anda belum mengisi jenis penilitian',
                        'jenis_kategori.required' => 'Anda belum mengisi kategori buku terjemahan/non terjemahan',
                        'jenis_pustaka.required' => 'Anda belum mengisi jenis pustaka (fiksi/non fiksi)',
                        'deskripsi.required' => 'Anda belum mengisi abstrak/deskripsi buku',
                        'deskripsi.min' => 'Abstrak/deskripsi buku minimal terdiri dari 100 karakter',
                        'url.*.required' => 'Anda belum mengisi URL/Link publikasi buku',
                        //'pengajuan_kdt.required' => 'Anda belum memilih apakah akan mengajukan KDT atau tidak',
                    ];
                    if(request('penerbit_isbn_masalah_id') != ''){
                        $rules = array_merge($rules, [
                        //        'file_lampiran' => 'required|array|min:1',
                        //        'file_lampiran.*' => 'required',
                        ]);
                        $messages = array_merge($messages ,[
                        //        'file_lampiran.required' => 'Anda belum mengunggah file lampiran buku yang sudah diperbaiki',
                        //        'file_lampiran.*.required' => 'Anda belum mengunggah file lampiran buku yang sudah diperbaiki',
                        ]);
                    }
                    if(request('status') == 'lepas') {
                        $rules = array_merge($rules, [
                            'jml_hlm' => 'required',
                            'tahun_terbit' => 'required|tahun_terbit_min',
                            'bulan_terbit' => 'bulan_terbit_min:' . $request->input('tahun_terbit'),
                            
                        ]);
                        $messages = array_merge($messages ,[
                            'jml_hlm.required' => 'Anda wajib mengisi jumlah halaman buku',
                            //'jml_hlm.min' => 'Menurut UNESCO, jumlah halaman buku paling sedikit terdiri dari 40 halaman, tidak termasuk bagian preliminaries dan postliminaries',
                            'tahun_terbit.required' => 'Anda belum mengisi tahun terbit buku',
                            //'bulan_terbit.required' => 'Anda belum mengisi bulan terbit buku',
                            'tahun_terbit.tahun_terbit_min' => 'Tahun terbit yang Anda masukan tidak boleh kurang dari tahun ' . date('Y'),
                            'bulan_terbit.bulan_terbit_min' => 'Bulan terbit yang Anda masukan tidak boleh kurang dari bulan ' . date('m-Y'),
                        ]);
                    } else {
                        $rules = array_merge($rules, [
                            'tahun_terbit' => 'required',
                            //'bulan_terbit' => 'required',
                            'bulan_terbit' => 'bulan_terbit_min:' . $request->input('tahun_terbit'),
                            
                        ]);
                        $messages = array_merge($messages ,[
                            'tahun_terbit.required' => 'Anda belum mengisi tahun terbit buku',
                            //'bulan_terbit.required' => 'Anda belum mengisi bulan terbit buku',
                            'bulan_terbit.bulan_terbit_min' => 'Bulan terbit yang Anda masukan tidak boleh kurang dari bulan ' . date('m-Y'),
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
                    $noresi = now()->addHours(7)->format('YmdHis') . strtoupper(str()->random(5));
                    if(request('noresi') != ""){
                        $noresi = request('noresi');
                        if(strlen($noresi) < 19){
                            $noresi = now()->addHours(7)->format('YmdHis') . strtoupper(str()->random(5));
                        }
                    }
                    $jumlah_jilid = intval(request('jumlah_jilid'));
                    if(request('status') == 'jilid') { //kalau isbn lepas gmn?
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
                    } else if(request('status') == 'lepas') {
                        $jml_hlm = request('jml_hlm');
                    }
                    
                    $urls = "";
                    if(request('status') == 'jilid'){
                        $jilids = ""; 
                        if(request('isbn-jilid') == ""){
                            $jilids = "no.jil.lengkap¦";
                            $urls = "¦";
                        }
                        $jilids .= implode('¦', request('keterangan_jilid'));
                        $urls .= implode('¦', request('url'));    
                    } else {
                        $urls = implode('¦', request('url'));    
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
                            [ "name"=>"DISTRIBUTOR", "Value"=> request('distributor') ],
                            [ "name"=>"TEMPAT_TERBIT", "Value"=> request('tempat_terbit') ],
                            [ "name"=>"JENIS_KELOMPOK", "Value"=> request('jenis_kelompok') ],
                            [ "name"=>"JENIS_MEDIA", "Value"=> request('jenis_media') ],
                            //[ "name"=>"JENIS_TERBITAN", "Value"=> request('jenis_terbitan') ],
                            //[ "name"=>"JENIS_PENELITIAN", "Value"=> request('jenis_penelitian') ],
                            [ "name"=>"JENIS_PUSTAKA", "Value"=> request('jenis_pustaka') ],
                            [ "name"=>"JENIS_KATEGORI", "Value"=> request('jenis_kategori') ],
                            [ "name"=>"KETEBALAN", "Value"=> request('ketebalan')],
                            [ "name"=>"PENGAJUAN_KDT", "Value"=> request('pengajuan_kdt') ? request('pengajuan_kdt') : 0 ],
                            //[ "name"=>"JML_JILID", "Value" => request('jumlah_jilid_total')  ]
                            [ "name"=>"PUBLICATION_PROV_ID", "Value"=> request('publication_prov_id') ],
                            [ "name"=>"PUBLICATION_CITY_ID", "Value"=> request('publication_city_id') ],
                    ];
                    $IsbnResi = [
                        [ "name" => "NORESI", "Value" => $noresi ],
                        [ "name" => "LINK_BUKU", "Value" => $urls ],
                        [ "name" => "SOURCE", "Value" => "web" ],
                    ];
                    
                    if(request('status') == 'jilid'){
                        array_push($IsbnResi, [ "name" => "JML_JILID_REQ", "Value" => count(request('keterangan_jilid'))]);
                        array_push($IsbnResi, 
                            [ "name"=> "KETERANGAN_JILID", "Value"=> $jilids ]
                        );
                    } else {
                        array_push($IsbnResi, [ "name" => "JML_JILID_REQ", "Value" => 1]);
                    }
                    if(request('isbn-jilid') == ""){
                        array_push($IsbnResi,  [ "name" =>"JENIS", "Value" => request('status')]);
                    } else {
                        array_push($IsbnResi,  [ "name" =>"JENIS", "Value" => "jilid"]);
                    }
                    
                    if(request('penerbit_terbitan_id') != ''){
                        // EDIT DATA PERMOHONAN
                        array_push($ListData, 
                                [ "name"=>"UPDATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                                [ "name"=>"UPDATEDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
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
                        if(request('isbn-jilid') != ""){
                            //ISBN JILID LANJUTAN EDIT TABEL PENERBIT_TERBITAN
                            array_push($ListData, 
                                [ "name" => "LAST_MOHON_CREATEDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
                                [ "name" => "LAST_MOHON_CREATEBY","Value"=> session('penerbit')["USERNAME"] ],
                                [ "name" => "LAST_MOHON_CREATETERMINAL","Value"=> \Request::ip() ],
                                [ "name" => "UPDATEBY", "Value"=> session('penerbit')["USERNAME"]], 
                                [ "name" => "UPDATETERMINAL", "Value"=> \Request::ip()]
                            );
                            $id = request('isbn-jilid');
                            $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=PENERBIT_TERBITAN&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));
                        } else {
                            array_push($ListData, 
                                    [ "name"=>"MOHON_DATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
                                    [ "name"=>"PENERBIT_ID", "Value"=> session('penerbit')["ID"] ], 
                                    [ "name"=>"IS_KDT_VALID", "Value"=> '0' ],
                                    [ "name"=>"CREATEBY", "Value"=> session('penerbit')["USERNAME"]], 
                                    [ "name"=>"CREATEDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
                                    [ "name"=>"CREATETERMINAL", "Value"=> \Request::ip()]
                            );
                            // INSERT KE TABEL PENERBIT_TERBITAN
                            $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=PENERBIT_TERBITAN&issavehistory=0&ListAddItem=" . urlencode(json_encode($ListData)));
                            $id = $res['Data']['ID'];
                        }
                        
                        if(request('isbn-jilid') != ""){
                            // INSERT KE TABEL ISBN_RESI
                            array_push($IsbnResi, 
                                [ "name" => "MOHON_DATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
                                [ "name" => "PENERBIT_ID", "Value"=> session('penerbit')["ID"] ] ,
                                [ "name" => "PENERBIT_TERBITAN_ID", "Value" => $id],
                                [ "name" => "STATUS", "Value"=> "lanjutan"],
                                [ "name" => "CREATEBY", "Value"=> session('penerbit')["USERNAME"]], 
                                [ "name" => "CREATETERMINAL", "Value"=> \Request::ip()]
                            );
                            $res2 =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=ISBN_RESI&issavehistory=1&ListAddItem=" . urlencode(json_encode($IsbnResi)));
                            $id_resi = $res2['Data']['ID'];

                            //INSERT HISTORY
                            $history = [
                                [ "name" => "TABLENAME", "Value"=> "PENERBIT_TERBITAN"],
                                [ "name" => "IDREF", "Value"=> $id],
                                [ "name" => "ACTION" , "Value"=> "Update"],
                                [ "name" => "ACTIONBY" , "Value"=> session('penerbit')["USERNAME"]],
                                [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
                                [ "name" => "NOTE", "Value"=> "Permohonan lanjutan"],
                            ];

                            $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
                        } else {
                            // INSERT KE TABEL ISBN_RESI
                            array_push($IsbnResi, 
                                [ "name" => "MOHON_DATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
                                [ "name" => "PENERBIT_ID", "Value"=> session('penerbit')["ID"] ] ,
                                [ "name" => "PENERBIT_TERBITAN_ID", "Value" => $id],
                                [ "name" => "STATUS", "Value"=> "permohonan"],
                                [ "name" => "CREATEBY", "Value"=> session('penerbit')["USERNAME"]], 
                                [ "name" => "CREATEDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
                                [ "name" => "CREATETERMINAL", "Value"=> \Request::ip()]
                            );
                            $res2 =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=ISBN_RESI&issavehistory=1&ListAddItem=" . urlencode(json_encode($IsbnResi)));
                            $id_resi = $res2['Data']['ID'];

                            //INSERT HISTORY
                            $history = [
                                [ "name" => "TABLENAME", "Value"=> "PENERBIT_TERBITAN"],
                                [ "name" => "IDREF", "Value"=> $id],
                                [ "name" => "ACTION" , "Value"=> "Add"],
                                [ "name" => "ACTIONBY" , "Value"=> session('penerbit')["USERNAME"]],
                                [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
                                [ "name" => "NOTE", "Value"=> "Permohonan baru"],
                            ];
                            $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
                        }
                    }
                    /* ------------------------------------------------ simpan file ------------------------------------------*/
                    if(request('status') == 'lepas') {
                        $file = [
                            'file_dummy' => $request->input('file_dummy')[0] ?? null,
                            'file_lampiran' => $request->input('file_lampiran')[0] ?? null,
                            'file_cover' => $request->input('file_cover')[0] ?? null,
                        ];

                        if(request('penerbit_terbitan_id') != '' && isset($request->input('file_dummy')[0])){
                            //ganti file dummy kalau ada
                            if(isset($request->input('file_dummy_id')[0])) {
                                $params = [
                                    'penerbitisbnfileid' => $request->input('file_dummy_id')[0],
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
                                    'penerbitisbnfileid' => $request->input('file_cover_id')[0],
                                    'actionby' => session('penerbit')['USERNAME'],
                                    'terminal' => \Request::ip()
                                ];
                                kurl("post", "deletefilelampiran",'', '', $params);
                            }
                        }
                        //if(request('penerbit_isbn_masalah_id' != '')) {
                            //kalau bermasalah, lampirannya ga usah dihapus
                        //    $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), '', $id_resi, true);    
                        //} else {
                            //kalau mau ganti lampiran permohonan 
                            if(request('penerbit_terbitan_id') != '' && isset($request->input('file_lampiran')[0])) {
                            //if(request('penerbit_isbn_masalah_id') == '' && isset($request->input('file_lampiran')[0])) {
                                if(isset($request->input('file_lampiran_id')[0])) {
                                    $params = [
                                        'penerbitisbnfileid' => $request->input('file_lampiran_id')[0],
                                        'actionby' => session('penerbit')['USERNAME'],
                                        'terminal' => \Request::ip()
                                    ];
                                    kurl("post", "deletefilelampiran",'', '', $params);
                                }
                            }
                            $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), '', $id_resi);    
                        //}
                    } else {     
                        if(request('isbn-jilid') != ""){
                            $start = ($jumlah_jilid - count(request('file_lampiran')));
                        } else {
                            $start = 0;
                        }
                        //upload file jilid               
                        for($i = $start; $i < $jumlah_jilid; $i++){
                            $file = [
                                'file_dummy' => $request->input('file_dummy')[$i - $start] ?? null,
                                'file_lampiran' => $request->input('file_lampiran')[$i - $start] ?? null,
                                'file_cover' => $request->input('file_cover')[$i - $start] ?? null
                            ];
                            if(request('penerbit_terbitan_id') != '' && isset($request->input('file_dummy')[$i])){
                                //ganti file dummy kalau ada
                                if(isset($request->input('file_dummy_id')[$i - $start])) {
                                    $params = [
                                        'penerbitisbnfileid' => $request->input('file_dummy_id')[$i - $start],
                                        'actionby' => session('penerbit')['USERNAME'],
                                        'terminal' => \Request::ip()
                                    ];
                                    kurl("post", "deletefilelampiran",'', '', $params);
                                }
                            }
                            if(request('penerbit_terbitan_id') != '' && isset($request->input('file_cover')[$i - $start])){
                                //ganti file cover kalau ada
                                if(isset($request->input('file_cover_id')[$i - $start])) {
                                    $params = [
                                        'penerbitisbnfileid' => $request->input('file_cover_id')[$i - $start],
                                        'actionby' => session('penerbit')['USERNAME'],
                                        'terminal' => \Request::ip()
                                    ];
                                    kurl("post", "deletefilelampiran",'', '', $params);
                                }
                            }
                            //if(request('penerbit_isbn_masalah_id' != '')) {
                                //kalau bermasalah, lampirannya ga usah dihapus
                            //    $keterangan = "perbaikan jilid " . $i + 1;   
                            //    $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), $keterangan, $id_resi, true);    
                            //} else {
                                //kalau mau ganti lampiran permohonan 
                                if(request('penerbit_terbitan_id') == '' && isset($request->input('file_lampiran')[$i - $start])) {
                                    if(isset($request->input('file_lampiran_id')[$i - $start])) {
                                        $params = [
                                            'penerbitisbnfileid' => $request->input('file_lampiran_id')[$i - $start],
                                            'actionby' => session('penerbit')['USERNAME'],
                                            'terminal' => \Request::ip()
                                        ];
                                        kurl("post", "deletefilelampiran",'', '', $params);
                                    }
                                }
                                $keterangan = "jilid " . $i + 1;   
                                $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), $keterangan, $id_resi);     
                            //}                   
                        }
                        
                    }

                    //KIRIM EMAIL NOTIFIKASI
                    switch(request('jenis_media')){
                        case '1': $jenis_media = 'Cetak'; break;
                        case '2': $jenis_media = 'Digital (PDF)'; break;
                        case '3': $jenis_media = 'Digital (EPUB)'; break;
                        case '4': $jenis_media = 'Audio Book'; break;
                        case '5': $jenis_media = 'Audio Visual Book'; break;
                        default: $jenis_media = ''; break;
                    }
                    $params = [
                        ["name" => "NoResi", "Value" => $noresi],
                        ["name" => "JenisPermohonan", "Value" => request('status')],
                        ["name" => "NamaPenerbit", "Value" => session('penerbit')['NAME']],
                        ["name" => "Title", "Value" => '<b>' . request('title') . '</b>'],
                        ["name" => "Kepeng", "Value" => $authors ],
                        ["name" => "BulanTahunTerbit", "Value" => request('bulan_terbit') . '-' . request('tahun_terbit')],
                        ["name" => "JenisTerbitan", "Value" => $jenis_media ],
                        ["name" => "Sinopsis", "Value" => request('deskripsi') ],
                        ["name" => "Distributor", "Value"=> request('distributor') ],
                        ["name" => "TempatTerbit", "Value"=> request('tempat_terbit') ],
                    ];
                    sendMail(14, $params, session('penerbit')['EMAIL'], 'PERMOHONAN ISBN BARU [#'.$noresi.']');

                    return response()->json([
                        'status' => 'Success',
                        'message' => 'Data permohonan berhasil disimpan.',
                        'noresi' => $noresi
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Akun anda terkunci. Tidak bisa mengubah data.',
                    'noresi' => $noresi
                ], 500);
            }
        } catch(\Exception $e){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data permohonan gagal disimpan. Server Error!' . $e->getMessage(),
                'err' => $e->getMessage()
            ], 500);
        }
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
            [ "name" => "NOTE", "Value"=> "Set status batal"],
        ];
        $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
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
                File::delete($filePath_one);
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
                File::delete($filePath_one);
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
                kurl_upload('post', $penerbit, $terbitan_id, "dummy_buku", $file_two, $ip, $keterangan, $resi_id);
            }
            File::delete($filePath_two);
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
                kurl_upload('post', $penerbit, $terbitan_id, "cover", $file_3, $ip, $keterangan, $resi_id);
            }
            File::delete($filePath_3);
        }
    }


    function detail($noresi)
    {
        if(session('penerbit')['IS_LOCK'] == '1') {
            return view('akun_lock', $data);
        }
        $detail = kurl("get","getlistraw", "", "SELECT ir.id, ir.penerbit_terbitan_id, pt.title, pt.author, pt.distributor, pt.kepeng, 
        pt.publication_prov_id, pt.publication_city_id, pt.pengajuan_kdt, 
        case when pt.jml_jilid is null then 1
        when pt.jml_jilid = 0 then 1
        else pt.jml_jilid end jml_jilid,
            pt.bulan_terbit, pt.tahun_terbit, pt.tempat_terbit, ir.noresi, ir.createdate, ir.mohon_date,   ir.jml_jilid_req, ir.jenis, 
            ir.status, ir.link_buku, ir.keterangan_jilid, pt.jenis_media, pt.jenis_kategori, pt.jenis_kelompok, pt.jenis_pustaka,  
            pt.sinopsis, pt.jml_hlm, pt.ketebalan, pt.edisi, pt.seri, pt.is_kdt_valid, pt.jenis_penelitian, pt.jenis_terbitan,
            pt.jenis_kelompok, ir.createdate, ir.createterminal, ir.createby         
          FROM  ISBN_RESI ir JOIN PENERBIT_TERBITAN pt ON ir.penerbit_terbitan_id = pt.id WHERE NORESI='$noresi'", 'sql', '');


        if(!isset($detail["Data"]["Items"][0])) {
            $detail = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_TERBITAN WHERE ID=$noresi", 'sql', '');
        }
       
      
        $id = $detail['Data']['Items'][0]['ID'];
        $id_penerbit_terbitan = $detail['Data']["Items"][0]["PENERBIT_TERBITAN_ID"];
        $file = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_ISBN_FILE WHERE PENERBIT_TERBITAN_ID='$id_penerbit_terbitan'", 'sql', '');
        $masalah = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT_ISBN_MASALAH WHERE PENERBIT_TERBITAN_ID='$id_penerbit_terbitan' AND IS_SOLVE=0 ", 'sql', '');
        $data = [
            'jenis' =>  $detail["Data"]["Items"][0]["JENIS"],
            'status' =>  $detail["Data"]["Items"][0]["STATUS"],
            'detail' => $detail["Data"]["Items"][0],
            'noresi' => $noresi,
            'file' => $file,
            'masalah' => $masalah,
        ];
        if($detail["Data"]["Items"][0]["STATUS"] == 'lanjutan'){
            $data_jilid_lengkap = kurl("get","getlistraw", "", "SELECT pi.isbn_no, pt.title, pt.ID 
                FROM PENERBIT_ISBN pi 
                JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id 
                WHERE (pi.keterangan_jilid LIKE '%lengkap' OR pi.keterangan LIKE '%lengkap') 
                AND pi.penerbit_id = " . session('penerbit')['ID'] . " AND pt.id=" .$detail["Data"]["Items"][0]["PENERBIT_TERBITAN_ID"] , 'sql', '')["Data"]["Items"][0];
            $data = array_merge($data, [
                                'isbnjilidlanjutan' => $data_jilid_lengkap['ISBN_NO'] . ' | '.$data_jilid_lengkap['TITLE'], 
                                'isbnjilid'=> $detail["Data"]["Items"][0]['PENERBIT_TERBITAN_ID']
                            ]);
        } else {
            $data = array_merge($data, [
                'isbnjilidlanjutan' => '', 
                'isbnjilid'=> ''
            ]);
        }
        return view('edit_isbn', $data);
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
    function getDetailJilid($id)
    {
        $detail = kurl("get","getlistraw", "", "SELECT pt.* FROM PENERBIT_TERBITAN pt JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id WHERE pt.ID='$id' ", 'sql', '');
        
        if(count($detail["Data"]["Items"]) > 1){
            $status = "jilid";
        } else {
            $status = "lepas";
        }        
        $data = [
            'status' => $status,
            'detail' => $detail["Data"]["Items"][0],
            'jml_jilid' => count($detail["Data"]["Items"])
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
        $data = kurl("get","getlistraw", "", "SELECT pi.isbn_no, pt.title, pt.ID 
                FROM PENERBIT_ISBN pi 
                JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id 
                WHERE (pi.keterangan_jilid LIKE '%lengkap' OR pi.keterangan LIKE '%lengkap') 
                AND pi.penerbit_id = $id", 'sql', '')["Data"]["Items"];
        $arr = [];
        foreach($data as $d){
            array_push($arr, [
                'id' => $d['ID'],
                'nama' => $d['ISBN_NO'],
                'text'=> $d['ISBN_NO'] . ' | '. $d['TITLE']
            ]);
        }
        return $arr;
    }

    function checkTitleExists(Request $request)
    {
        $title = $request->input('title');
        $penerbit_id = session('penerbit')['ID'];
        if($request->input('penerbit_terbitan_id') != ""){
            $penerbit_terbitan_id = $request->input('penerbit_terbitan_id');
        } else {
            $penerbit_terbitan_id = 0;
        }
        $count = checkTitle($title, $penerbit_id, $penerbit_terbitan_id);
        if($count > 0){
            return response()->json([
                'valid' => false,
                'message' => 'Judul buku "' . $title . '" sudah ada!'
            ]);
        } else {
            return response()->json([
                'valid' => true,
                'message' => 'Judul buku ' . $title . ' dapat digunakan.',
            ]);
        }
    }

    function checkBulanTerbitMin(Request $request)
    {
        $bulan_terbit = $request->input('bulan_terbit');
        $tahun_terbit = $request->input('tahun_terbit');
        if($request->input('bulan_terbit')) {
            if(strtotime(date('Y-m')) <= strtotime($tahun_terbit .'-'. str($bulan_terbit))){
                return response()->json([
                    'valid' => true,
                    'message' => 'ok!'
                ]);
            } else {
                return response()->json([
                    'valid' => false,
                    'message' => 'Bulan terbit yang Anda masukan tidak boleh kurang dari bulan ' . date('F Y'),
                ]);
            }
        } else {
            return response()->json([
                'valid' => true,
                'message' => 'ok!'
            ]);
        }
    }

    function checkTahunTerbitMin(Request $request)
    {
        $tahun_terbit = $request->input('tahun_terbit');
        if(strtotime($tahun_terbit) >= strtotime(date('Y')) ){
            return response()->json([
                'valid' => true,
                'message' => 'ok!'
            ]);
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'Tahun terbit yang Anda masukan tidak boleh kurang dari tahun ' . date('Y'),
            ]);
        }
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
