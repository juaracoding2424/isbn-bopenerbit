<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use \Illuminate\Http\UploadedFile;

class PermohonanController extends Controller
{
    function submit(Request $request)
    {
        $penerbit = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT WHERE JWT='".$request->bearerToken()."'", 'sql', '')["Data"]["Items"][0];
        //\Log::info(request()->all());
        try{  
            \Validator::extend('valArrayNotEmpty', function ($attribute, $value, $parameters, $validator) {
                $arrs = json_decode($value, true);
                foreach($arrs as $arr){
                    foreach($arr as $key => $val) {
                        if(trim($val)== "") {
                            return false;
                        } else {
                            return true;
                        }
                    }
                }
            });
            \Validator::extend('keyArrayNotEmpty', function ($attribute, $value, $parameters, $validator) {
                $arrs = json_decode($value, true);
                foreach($arrs as $arr){
                    foreach($arr as $key => $val) {
                        if(trim($key)== "") {
                            return false;
                        } else {
                            return true;
                        }
                    }
                }
            });
            \Validator::extend('title_exists', function ($attribute, $value, $parameters, $validator) {
                if($this->checkTitle($value, $parameters[0]) > 0) {
                    return false;
                } else {
                    return true;
                }
            });
            
            if(request('jenis_permohonan') == 'lepas') {
                $val = $this->validasiLepas($penerbit['ID']);
                $validator = \Validator::make(request()->all(),$val[0], $val[1]);
            } else {
                $val = $this->validasiJilid($penerbit['ID']);
                $validator = \Validator::make(request()->all(),$val[0], $val[1]);
            }
                

            if($validator->fails()){
                return response()->json([
                    'status' => 'Failed',
                    'message'   => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                    'err' => $validator->errors(),
                ], 422);
            } else {  
                $authors = "";
                $arrs = json_decode($request->input('kepeng'), true);
                for($i = 0; $i< count($arrs); $i++){
                    foreach($arrs[$i] as $key => $val) {
                        $authors .= $key.", " . $val;
                    }
                    if(isset($arrs[$i+1])){
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
                if(request('jenis_permohonan') == 'jilid') { 
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
                if(request('jenis_permohonan') == 'jilid') {
                    for($i = 0; $i < count(request('url')); $i++) {
                        $urls .= request('link_buku')[$i];
                        $jilids .= "jilid " . $i+1;
                        if(isset(request('link_buku')[$i+1])){
                            $urls .= "¦";
                            $jilids .= "¦";
                        }
                    }
                } else {
                    $urls = request('link_buku');
                }
                
                $ListData = [
                        [ "name"=>"TITLE", "Value"=> request('title') ],
                        [ "name"=>"KEPENG", "Value"=> $authors ],
                        [ "name"=>"EDISI", "Value"=> request('edisi')],
                        [ "name"=>"SERI", "Value"=> request('seri')],
                        [ "name"=>"SINOPSIS", "Value"=> request('deskripsi') ],
                        [ "name"=>"JML_HLM", "Value"=> $jml_hlm ],
                        [ "name"=>"DISTRIBUTOR", "Value"=> request('distributor') ],
                        [ "name"=>"TEMPAT_TERBIT", "Value"=> request('tempat_terbit')],
                        [ "name"=>"TAHUN_TERBIT", "Value"=> request('tahun_terbit') ],
                        [ "name"=>"BULAN_TERBIT", "Value"=> request('bulan_terbit') ],
                        [ "name"=>"JENIS_KELOMPOK", "Value"=> request('jenis_kelompok') ],
                        [ "name"=>"JENIS_MEDIA", "Value"=> request('jenis_media') ],
                        [ "name"=>"JENIS_TERBITAN", "Value"=> request('jenis_terbitan') ],
                        [ "name"=>"JENIS_PENELITIAN", "Value"=> request('jenis_penelitian') ],
                        [ "name"=>"JENIS_PUSTAKA", "Value"=> request('jenis_pustaka') ],
                        [ "name"=>"JENIS_KATEGORI", "Value"=> request('jenis_kategori') ],
                        [ "name"=>"KETEBALAN", "Value"=> request('dimensi')],
                        
                ];
                $IsbnResi = [
                    [ "name" =>"NORESI", "Value" => $noresi ],
                    [ "name" => "JENIS", "Value" => request('jenis_permohonan')],
                    [ "name" => "SOURCE", "Value" => "api"],
                    [ "name" =>"JML_JILID_REQ", "Value" => $jumlah_jilid],
                    [ "name" =>"LINK_BUKU", "Value" => $urls ],
                ];
                
                if($jumlah_jilid > 1){
                    array_push($IsbnResi, 
                        [ "name"=>"KETERANGAN_JILID", "Value"=> $jilids ]
                    );
                }
                    // TAMBAH DATA PERMOHONAN
                array_push($ListData, 
                    [ "name"=>"MOHON_DATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"PENERBIT_ID", "Value"=> $penerbit["ID"] ], 
                            [ "name"=>"IS_KDT_VALID", "Value"=> '0' ],
                            [ "name"=>"CREATEBY", "Value"=> $penerbit["ISBN_USER_NAME"] . "-api"], 
                            [ "name"=>"CREATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"CREATETERMINAL", "Value"=> \Request::ip()]
                    );
                    
                // INSERT KE TABEL PENERBIT_TERBITAN
                $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=PENERBIT_TERBITAN&issavehistory=1&ListAddItem=" . urlencode(json_encode($ListData)));
                $id = $res['Data']['ID'];

                // INSERT KE TABEL ISBN_RESI
                array_push($IsbnResi, 
                        [ "name" => "MOHON_DATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                        [ "name" => "PENERBIT_ID", "Value"=> $penerbit["ID"] ] ,
                        [ "name" => "PENERBIT_TERBITAN_ID", "Value" => $id],
                        [ "name" => "STATUS", "Value"=> "permohonan"],
                        [ "name" => "CREATEBY", "Value"=> $penerbit["ISBN_USER_NAME"] . "-api"], 
                        [ "name" => "CREATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                        [ "name" => "CREATETERMINAL", "Value"=> \Request::ip()]
                );
                $res2 =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=ISBN_RESI&issavehistory=1&ListAddItem=" . urlencode(json_encode($IsbnResi)));
                $id_resi = $res2['Data']['ID'];
                    
            } 
            /* ------------------------------------------------ simpan file ------------------------------------------*/
            if(request('status') == 'lepas') {
                    $file = [
                        'file_dummy' => $request->input('file_dummy') ?? null,
                        'file_lampiran' => $request->input('file_lampiran') ?? null,
                        'file_cover' => $request->input('file_cover') ?? null,
                    ];
                    if($request->input('file_lampiran')) {
                        $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), '');    
                    }
            } else {     
                    //upload file jilid               
                for($i = 0; $i < $jumlah_jilid; $i++){
                    $file = [
                            'file_dummy' => $request->input('file_dummy')[$i] ?? null,
                            'file_lampiran' => $request->input('file_lampiran')[$i] ?? null,
                            'file_cover' => $request->input('file_cover')[$i] ?? null
                    ];
                    $keterangan = "jilid ke- " . $i + 1;   
                    $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), $keterangan);     
                }                   
            }
            //RETURN DATA YANG DIINPUT
            $sql_terbitan = "SELECT ir.noresi, ir.mohon_date, ir.jenis, ir.status, ir.createby,
                    pt.title, ir.jml_jilid_req, pt.jilid_volume, ir.link_buku, pt.author, pt.kepeng, pt.sinopsis as deskripsi,
                    pt.distributor, pt.tempat_terbit, pt.edisi, pt.seri, pt.bulan_terbit, pt.tahun_terbit,
                    pt.jml_hlm, pt.ketebalan as dimensi,  pt.jenis_media, pt.jenis_terbitan, pt.jenis_pustaka, pt.jenis_kategori, 
                    pt.jenis_kelompok, pt.jenis_penelitian
                    FROM PENERBIT_TERBITAN pt JOIN ISBN_RESI ir ON ir.penerbit_terbitan_id = pt.id WHERE ir.id=$id_resi";
            $data_terbitan = kurl("get","getlistraw", "", $sql_terbitan, 'sql', '')["Data"]["Items"][0];
                //\Log::info($res);
            return response()->json([
                    'status' => 'Success',
                    'message' => 'Data permohonan berhasil disimpan.',
                    'noresi' => $noresi,
                    'data' => $data_terbitan
            ], 200);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Server Error. Data permohonan gagal disimpan. Server Error!',
                'noresi' => $e->getMessage()
            ], 500);
        }
    } 

    function tracking($noresi)
    {
        $sql = "SELECT ir.noresi, ir.mohon_date, ir.jenis, ir.status, ir.createby,
                    pt.title, ir.jml_jilid_req, pt.jilid_volume, ir.link_buku, pt.author, pt.kepeng, pt.sinopsis as deskripsi,
                    pt.distributor, pt.tempat_terbit, pt.edisi, pt.seri, pt.bulan_terbit, pt.tahun_terbit,
                    pt.jml_hlm, pt.ketebalan as dimensi,  pt.jenis_media, pt.jenis_terbitan, pt.jenis_pustaka, pt.jenis_kategori, 
                    pt.jenis_kelompok, pt.jenis_penelitian
                    FROM PENERBIT_TERBITAN pt JOIN ISBN_RESI ir ON ir.penerbit_terbitan_id = pt.id WHERE ir.noresi='$noresi'";
        \Log::info($sql);
        $data = kurl("get","getlistraw", "", $sql,'sql', '')["Data"]["Items"];
        if(isset($data[0])){
            return response()->json($data[0]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Nomor resi tidak ditemukan',
            ], 500);
        }
    } 
    function checkTitle($title, $id)
    {
        $title = strtoupper(preg_replace("/[^a-zA-Z0-9]/", "", $title));
        $count = kurl("get","getlistraw", "", "SELECT count(*) JML FROM PENERBIT_TERBITAN WHERE  REGEXP_REPLACE(UPPER(TITLE), '[^[:alnum:]]', '') = '$title' AND penerbit_id='$id'", 'sql', '')["Data"]["Items"][0]["JML"];
        return intval($count);
    }

    function validasiLepas($id)
    {
        $rules = [
            'jenis_permohonan' => 'required',
            'title' => 'required|title_exists:' . $id,
            'kepeng' => 'required|val_array_not_empty|key_array_not_empty',
            'tempat_terbit' => 'required',
            'jenis_media' => 'required',
            'jenis_terbitan' => 'required',
            'jenis_kelompok' => 'required',
            'jenis_penelitian' => 'required',
            'jenis_kategori' => 'required',
            'jenis_pustaka' => 'required',
            'deskripsi' => 'required|min:100',
            'jml_hlm' => 'required|numeric|min:40',
            'file_dummy' => 'required',
            'file_lampiran' => 'required',
            'link_buku' => 'required',
        ];
        $messages = [
            'jenis_permohonan.required' => 'Anda belum mengisi jenis permohonan!',
            'title.required' => 'Anda belum mengisi judul buku',
            'title.title_exists' => 'Judul buku sudah ada, Anda tidak dapat memohon ISBN baru dengan judul yang sama.',
            'kepeng.required' => 'Anda belum mengisi kepengarangan',
            'kepeng.val_array_not_empty' => 'Nama kepengarangan tidak boleh kosong',
            'kepeng.key_array_not_empty' => "Role kepengarangan tidak boleh kosong",
            'tempat_terbit.required' => 'Anda belum mengisi tempat terbit buku',
            'jenis_media.required' => 'Anda belum mengisi jenis media terbitan buku',
            'jenis_terbitan.required' => 'Anda belum mengisi jenis terbitan buku',
            'jenis_kelompok.required' => 'Anda belum mengisi kelompok pembaca buku',
            'jenis_penelitian.required' => 'Anda belum mengisi jenis penilitian',
            'jenis_kategori.required' => 'Anda belum mengisi kategori buku terjemahan/non terjemahan',
            'jenis_pustaka.required' => 'Anda belum mengisi jenis pustaka (fiksi/non fiksi)',
            'deskripsi.required' => 'Anda belum mengisi abstrak/deskripsi buku',
            'deskripsi.min' => 'Abstrak/deskripsi buku minimal terdiri dari 100 karakter',
            'jml_hlm.numeric' => 'Jumlah halaman hanya boleh berisi angka',
            'jml_hlm.required' => 'Jumlah halaman wajiib diisi',
            'jml_hlm.min' => 'Menurut UNESCO, jumlah halaman buku paling sedikit terdiri dari 40 halaman, tidak termasuk bagian preliminaries dan postliminaries',
            'file_dummy.required' => 'Anda belum mengunggah file dummy buku',
            'file_lampiran.required' => 'Anda belum mengunggah file lampiran buku',
            'link_buku.required' => 'Anda belum mengisi URL/Link publikasi buku',
        ];
        
        return [$rules, $messages];
    }
    function validasiJilid($id)
    {
        $rules = [
            'jenis_permohonan' => 'required',
            'title' => 'required|title_exists:' . $id,
            'title.title_exists' => 'Judul buku sudah ada, Anda tidak dapat memohon ISBN baru dengan judul yang sama.',
            'kepeng' => 'val_array_not_empty|key_array_not_empty',
            'tempat_terbit' => 'required',
            'jenis_media' => 'required',
            'jenis_terbitan' => 'required',
            'jenis_kelompok' => 'required',
            'jenis_penelitian' => 'required',
            'jenis_kategori' => 'required',
            'jenis_pustaka' => 'required',
            'deskripsi' => 'required|min:100',
            'file_dummy' => 'required|array|min:1',
            'file_lampiran' => 'required|array|min:1',
            'file_dummy.*' => 'required',
            'file_lampiran.*' => 'required',
            'link_buku.*' => 'required',
            ];
        $messages = [
            'jenis_permohonan.required' => 'Anda belum mengisi jenis permohonan!',
            'title.required' => 'Anda belum mengisi judul buku',
            'kepeng.val_array_not_empty' => 'Nama kepengarangan tidak boleh kosong',
            'kepeng.key_array_not_empty' => "Role kepengarangan tidak boleh kosong",
            'tempat_terbit.required' => 'Anda belum mengisi tempat terbit buku',
            'jenis_media.required' => 'Anda belum mengisi jenis media terbitan buku',
            'jenis_terbitan.required' => 'Anda belum mengisi jenis terbitan buku',
            'jenis_kelompok.required' => 'Anda belum mengisi kelompok pembaca buku',
            'jenis_penelitian.required' => 'Anda belum mengisi jenis penilitian',
            'jenis_kategori.required' => 'Anda belum mengisi kategori buku terjemahan/non terjemahan',
            'jenis_pustaka.required' => 'Anda belum mengisi jenis pustaka (fiksi/non fiksi)',
            'deskripsi.required' => 'Anda belum mengisi abstrak/deskripsi buku',
            'deskripsi.min' => 'Abstrak/deskripsi buku minimal terdiri dari 100 karakter',
            'file_dummy.required' => 'Anda belum mengunggah file dummy buku',
            'file_lampiran.required' => 'Anda belum mengunggah file lampiran buku',
            'file_dummy.*.required' => 'Anda belum mengunggah file dummy buku',
            'file_lampiran.*.required' => 'Anda belum mengunggah file lampiran buku',
            'link_buku.*.required' => 'Anda belum mengisi URL/Link publikasi buku',
        ];
        return [$rules, $messages];
    }

    function upload_file($file, $penerbit, $terbitan_id, $ip, $keterangan, $is_masalah = false) 
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
                    kurl_upload('post', $penerbit, $terbitan_id, "lampiran_pending", $file_one, $ip, $keterangan);
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
                    kurl_upload('post', $penerbit, $terbitan_id, "lampiran_permohonan", $file_one, $ip, $keterangan);
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

}
