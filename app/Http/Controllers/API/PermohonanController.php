<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use \Illuminate\Http\UploadedFile;
//use Validator;

class PermohonanController extends Controller
{
    public function submit(Request $request)
    {
        $penerbit = kurl("get", "getlistraw", "", "SELECT * FROM PENERBIT WHERE JWT='" . $request->bearerToken() . "'", 'sql', '')["Data"]["Items"][0];

        try {

            if (request('jenis_permohonan') == 'lepas') {
                $val = $this->validasiLepas($request, $penerbit['ID'], '', false);
                $validator = \Validator::make(request()->all(), $val[0], $val[1]);
            } else {
                $val = $this->validasiJilid($request, $penerbit['ID'], '',false);
                $validator = \Validator::make(request()->all(), $val[0], $val[1]);
            }
            
            if ($validator->fails()) {
               
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                    'err' => $validator->errors(),
                ], 422);
            } else {
                $authors = "";
                $arrs = json_decode($request->input('kepeng'), true);
                for ($i = 0; $i < count($arrs); $i++) {
                    foreach ($arrs[$i] as $key => $val) {
                        $authors .= $key . ", " . $val;
                    }
                    if (isset($arrs[$i + 1])) {
                        $authors .= ";";
                    }
                }
                $noresi = now()->format('YmdHis') . strtoupper(str()->random(5));
                if (request('noresi') != "") {
                    $noresi = request('noresi');
                    if (strlen($noresi) < 19) {
                        $noresi = now()->format('YmdHis') . strtoupper(str()->random(5));
                    }
                }
                $jumlah_jilid = intval(request('jumlah_jilid')) == 0 || intval(request('jumlah_jilid')) == '' ? 1 : intval(request('jumlah_jilid'));
                //\Log::info($jumlah_jilid);
                if (request('jenis_permohonan') == 'jilid') {
                    #--------------VALIDASI JUMLAH JILID----------------------------------------------------------------
                    /*if($jumlah_jilid < 2) {
                    return response()->json([
                    'status' => 'Failed',
                    'message'   => 'Gagal menyimpan data!',
                    'err' => ["jumlah_jilid" => ["Wajib memasukan minimal 2 data buku jika merupakan terbitan jilid"]],
                    ], 422);
                    }
                    #----------------END VALIDASI -------------------------------------------------------------------------#*/
                    $jml_hlm = $jumlah_jilid . " jil"; 
                } else {
                    $jml_hlm = request('jml_hlm');
                }
                $urls = "";
                $jilids = "";
                if (request('jenis_permohonan') == 'jilid') {
                    for ($i = 1; $i <= $jumlah_jilid; $i++) {
                        $urls .= $request->input("link_buku_$i");
                        $jilids .= "jilid " . $i;
                        $next = "link_buku_" . $i + 1;
                        if ($request->input($next)) {
                            $urls .= "¦";
                            $jilids .= "¦";
                        }
                    }
                } else {
                    $urls = request('link_buku');
                }

                $ListData = [
                    ["name" => "TITLE", "Value" => request('title')],
                    ["name" => "KEPENG", "Value" => $authors],
                    ["name" => "EDISI", "Value" => request('edisi')],
                    ["name" => "SERI", "Value" => request('seri')],
                    ["name" => "SINOPSIS", "Value" => request('deskripsi')],
                    ["name" => "JML_HLM", "Value" => $jml_hlm],
                    ["name" => "DISTRIBUTOR", "Value" => request('distributor')],
                    ["name" => "TEMPAT_TERBIT", "Value" => request('tempat_terbit')],
                    ["name" => "TAHUN_TERBIT", "Value" => request('tahun_terbit')],
                    ["name" => "BULAN_TERBIT", "Value" => request('bulan_terbit')],
                    ["name" => "JENIS_KELOMPOK", "Value" => request('jenis_kelompok')],
                    ["name" => "JENIS_MEDIA", "Value" => request('jenis_media')],
                    ["name" => "JENIS_TERBITAN", "Value" => request('jenis_terbitan')],
                    ["name" => "JENIS_PENELITIAN", "Value" => request('jenis_penelitian')],
                    ["name" => "JENIS_PUSTAKA", "Value" => request('jenis_pustaka')],
                    ["name" => "JENIS_KATEGORI", "Value" => request('jenis_kategori')],
                    ["name" => "KETEBALAN", "Value" => request('dimensi')],

                ];
                $IsbnResi = [
                    ["name" => "NORESI", "Value" => $noresi],
                    ["name" => "JENIS", "Value" => request('jenis_permohonan')],
                    ["name" => "SOURCE", "Value" => "api"],
                    ["name" => "JML_JILID_REQ", "Value" => $jumlah_jilid],
                    ["name" => "LINK_BUKU", "Value" => $urls],
                ];

                if ($jumlah_jilid > 1) {
                    array_push($IsbnResi,
                        ["name" => "KETERANGAN_JILID", "Value" => $jilids]
                    );
                }
                // TAMBAH DATA PERMOHONAN
                array_push($ListData,
                    ["name" => "MOHON_DATE", "Value" => now()->format('Y-m-d H:i:s')],
                    ["name" => "PENERBIT_ID", "Value" => $penerbit["ID"]],
                    ["name" => "IS_KDT_VALID", "Value" => '0'],
                    ["name" => "CREATEBY", "Value" => $penerbit["ISBN_USER_NAME"] . "-api"],
                    ["name" => "CREATEDATE", "Value" => now()->format('Y-m-d H:i:s')],
                    ["name" => "CREATETERMINAL", "Value" => \Request::ip()]
                );

                // INSERT KE TABEL PENERBIT_TERBITAN
                $res = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=PENERBIT_TERBITAN&ListAddItem=" . urlencode(json_encode($ListData)));
                $id = $res['Data']['ID'];
                //INSERT HISTORY PENERBIT TERBITAN
                $history = [
                    [ "name" => "TABLENAME", "Value"=> "PENERBI_TERBITAN"],
                    [ "name" => "IDREF", "Value"=> $id],
                    [ "name" => "ACTION" , "Value"=> "Add"],
                    //[ "name" => "ACTIONDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                    [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
                    [ "name" => "ACTIONBY", "Value"=> $penerbit["ISBN_USER_NAME"] . "-api"],
                    [ "name" => "NOTE", "Value"=> "Permohonan baru"],
                ];
                $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
                // INSERT KE TABEL ISBN_RESI
                array_push($IsbnResi,
                    ["name" => "MOHON_DATE", "Value" => now()->format('Y-m-d H:i:s')],
                    ["name" => "PENERBIT_ID", "Value" => $penerbit["ID"]],
                    ["name" => "PENERBIT_TERBITAN_ID", "Value" => $id],
                    ["name" => "STATUS", "Value" => "permohonan"],
                    ["name" => "CREATEBY", "Value" => $penerbit["ISBN_USER_NAME"] . "-api"],
                    ["name" => "CREATEDATE", "Value" => now()->format('Y-m-d H:i:s')],
                    ["name" => "CREATETERMINAL", "Value" => \Request::ip()]
                );
                $res2 = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=ISBN_RESI&issavehistory=1&ListAddItem=" . urlencode(json_encode($IsbnResi)));
                $id_resi = $res2['Data']['ID'];
                //KIRIM EMAIL NOTIFIKASI
                if(request('notifikasi') == 'true' || request('notifikasi') == true) {
                    $params = [
                        ["name" => "NoResi", "Value" => $noresi],
                        ["name" => "NamaPenerbit", "Value" => $penerbit['NAME']],
                        ["name" => "Title", "Value" => request('title')],
                        ["name" => "Kepeng", "Value" => $authors ],
                        ["name" => "BulanTahunTerbit", "Value" => request('bulan_terbit') . '-' . request('tahun_terbit')],
                        ["name" => "JenisTerbitan", "Value" => request('jenis_permohonan') ],
                        ["name" => "Sinopsis", "Value" => request('deskripsi') ],
                        ["name" => "Distributor", "Value"=> request('distributor') ],
                        ["name" => "TempatTerbit", "Value"=> request('tempat_terbit') ],
                    ];
                    sendMail(14, $params, $penerbit['EMAIL'], 'PERMOHONAN ISBN BARU [#'+$noresi+']');
                }
            }
            // ------------------------------------------------ simpan file ------------------------------------------//
            if ($request->input('jenis_permohonan') == 'lepas') {
                $file = [
                    'file_dummy' => $request->file('file_dummy') ?? null,
                    'file_lampiran' => $request->file('file_lampiran') ?? null,
                    'file_cover' => $request->file('file_cover') ?? null,
                ];
                if ($request->hasFile('file_lampiran')) {
                    $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), '', $id_resi);
                } 
            } else {
                //upload file jilid
                for ($i = 1; $i <= $jumlah_jilid; $i++) {
                    $file = [
                        "file_dummy_$i" => $request->file("file_dummy_$i") ?? null,
                        "file_lampiran_$i" => $request->file("file_lampiran_$i") ?? null,
                        "file_cover_$i" => $request->file("file_cover_$i") ?? null,
                    ];
                    $keterangan = 'jilid ' . $i;
                    $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip(), $keterangan, $id_resi);
                }
            }
            //RETURN DATA YANG DIINPUT
            $sql_terbitan = "SELECT ir.noresi, ir.mohon_date, ir.jenis, ir.status, ir.createby,
                    pt.title, ir.jml_jilid_req, pt.jilid_volume, ir.link_buku, pt.author, pt.kepeng, pt.sinopsis as deskripsi,
                    pt.distributor, pt.tempat_terbit, pt.edisi, pt.seri, pt.bulan_terbit, pt.tahun_terbit,
                    pt.jml_hlm, pt.ketebalan as dimensi,  pt.jenis_media, pt.jenis_terbitan, pt.jenis_pustaka, pt.jenis_kategori,
                    pt.jenis_kelompok, pt.jenis_penelitian
                    FROM PENERBIT_TERBITAN pt JOIN ISBN_RESI ir ON ir.penerbit_terbitan_id = pt.id WHERE ir.id=$id_resi";
            $data_terbitan = kurl("get", "getlistraw", "", $sql_terbitan, 'sql', '')["Data"]["Items"][0];
            return response()->json([
                'status' => 'Success',
                'message' => 'Data permohonan berhasil disimpan.',
                'noresi' => $noresi,
                'data' => $data_terbitan,
            ], 200); 
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Server Error. Data permohonan gagal disimpan. Server Error!',
                'noresi' => $e->getMessage(),
            ], 500);
        }
    }
    public function perbaikan(Request $request, $noresi)  
    {
        $penerbit = kurl("get", "getlistraw", "", "SELECT * FROM PENERBIT WHERE JWT='" . $request->bearerToken() . "'", 'sql', '')["Data"]["Items"][0];
        
        try {    
            $data = kurl("get", "getlistraw", "", "SELECT * FROM ISBN_RESI JOIN PENERBIT_TERBITAN ON ISBN_RESI.PENERBIT_TERBITAN_ID = PENERBIT_TERBITAN.ID WHERE NORESI='" . $noresi . "'", 'sql', '')["Data"]["Items"];
            
            if(! isset($data[0])) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Nomor Resi ' . $noresi . ' tidak ditemukan',
                ],400);
            } else {
                $id_resi = $data[0]["ID"];
            }
            if($request->input('title') == '' || $request->input('title') == null){
                $request->merge(['title' => $data[0]['TITLE']]);
            }
            if($request->input('jml_hlm') == '' || $request->input('jml_hlm') == null ){
                $request->merge(['jml_hlm' => $data[0]['JML_HLM']]);
            }
            if($request->input('kepeng') == '' || $request->input('kepeng') == null ){
                $kepeng = explode(";", $data[0]['KEPENG']);
                $kepengs_ = [];
                foreach($kepeng as $k) { 
                    $arr = explode(",", $k); 
                    array_push($kepengs_, [$arr[0]=>trim($arr[1])]);
                }
                $request->merge(['kepeng' => json_encode($kepengs_)]);
            }
            if($request->input('deskripsi') == '' || $request->input('deskripsi') == null ){
                $request->merge(['deskripsi' => $data[0]['SINOPSIS']]);
            }
            if($request->input('jenis_kategori') == '' || $request->input('jenis_kategori') == null ){
                $request->merge(['jenis_kategori' => $data[0]['JENIS_KATEGORI']]);
            }
            if($request->input('jenis_kelompok') == '' || $request->input('jenis_kelompok') == null ){
                $request->merge(['jenis_kelompok' => $data[0]['JENIS_KELOMPOK']]);
            }
            if($request->input('jenis_terbitan') == '' || $request->input('jenis_terbitan') == null ){
                $request->merge(['jenis_terbitan' => $data[0]['JENIS_TERBITAN']]);
            }
            if($request->input('jenis_pustaka') == '' || $request->input('jenis_pustaka') == null ){
                $request->merge(['jenis_pustaka' => $data[0]['JENIS_PUSTAKA']]);
            }
            if($request->input('jenis_penelitian') == '' || $request->input('jenis_penelitian') == null ){
                $request->merge(['jenis_penelitian' => $data[0]['JENIS_PENELITIAN']]);
            }
            if($request->input('jenis_media') == '' || $request->input('jenis_media') == null ){
                $request->merge(['jenis_media' => $data[0]['JENIS_MEDIA']]);
            }
            if($request->input('bulan_terbit') == '' || $request->input('bulan_terbit') == null ){
                $request->merge(['bulan_terbit' => $data[0]['BULAN_TERBIT']]);
            }
            if($request->input('tahun_terbit') == '' || $request->input('tahun_terbit') == null ){
                $request->merge(['tahun_terbit' => $data[0]['TAHUN_TERBIT']]);
            }
            if($request->input('tempat_terbit') == '' || $request->input('tempat_terbit') == null ){
                $request->merge(['tempat_terbit' => $data[0]['TEMPAT_TERBIT']]);
            }
            if($request->input('jumlah_jilid') == '' || $request->input('jumlah_jilid') == null ){
                $request->merge(['jumlah_jilid' => $data[0]['JML_JILID_REQ']]);
            }
            

            $request->merge(['jenis_permohonan' => $data[0]['JENIS']]);
            if ($data[0]['JENIS'] == 'lepas') {
                $val = $this->validasiLepas($request,$penerbit['ID'], $data[0]["PENERBIT_TERBITAN_ID"], true);
                $validator = \Validator::make(request()->all(), $val[0], $val[1]);
            } else {
                $val = $this->validasiJilid($request, $penerbit['ID'], $data[0]["PENERBIT_TERBITAN_ID"], true);
                $validator = \Validator::make(request()->all(), $val[0], $val[1]);
            }

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                    'err' => $validator->errors(),
                ], 422);
            } else {
                $authors = "";
                $arrs = json_decode($request->input('kepeng'), true);
                for ($i = 0; $i < count($arrs); $i++) {
                    foreach ($arrs[$i] as $key => $val) {
                        $authors .= $key . ", " . $val;
                    }
                    if (isset($arrs[$i + 1])) {
                        $authors .= ";";
                    }
                }
                
                $jumlah_jilid = intval($data[0]["JML_JILID_REQ"]); //intval($request->input('jumlah_jilid'));
                
                if ($request->input('jenis_permohonan') == 'jilid') {
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
                    $jml_hlm = $request->input('jml_hlm');
                }
                $urls = "";
                $jilids = ""; $jilArr = [];
                if ($data[0]['JENIS']  == 'jilid') {
                    $link_buku_old = explode("¦", $data[0]['LINK_BUKU']);
                    for ($i = 1; $i <= $jumlah_jilid; $i++) {
                        if($request->input("link_buku_$i")){
                            $link_buku_old[$i-1] = $request->input("link_buku_$i");
                        }
                        array_push($jilArr,"jilid " . $i);
                    }
                    $jilids = implode("¦", $jilArr);
                    $urls = implode("¦", $link_buku_old);
                } else {
                    $urls = $request->input('link_buku');
                }

                $ListData = [
                    ["name" => "TITLE", "Value" => $request->input('title')],
                    ["name" => "KEPENG", "Value" => $authors],
                    ["name" => "EDISI", "Value" => $request->input('edisi')],
                    ["name" => "SERI", "Value" => $request->input('seri')],
                    ["name" => "SINOPSIS", "Value" => $request->input('deskripsi')],
                    ["name" => "JML_HLM", "Value" => $jml_hlm],
                    ["name" => "DISTRIBUTOR", "Value" => $request->input('distributor')],
                    ["name" => "TEMPAT_TERBIT", "Value" => $request->input('tempat_terbit')],
                    ["name" => "TAHUN_TERBIT", "Value" => $request->input('tahun_terbit')],
                    ["name" => "BULAN_TERBIT", "Value" => $request->input('bulan_terbit')],
                    ["name" => "JENIS_KELOMPOK", "Value" => $request->input('jenis_kelompok')],
                    ["name" => "JENIS_MEDIA", "Value" => $request->input('jenis_media')],
                    ["name" => "JENIS_TERBITAN", "Value" => $request->input('jenis_terbitan')],
                    ["name" => "JENIS_PENELITIAN", "Value" => $request->input('jenis_penelitian')],
                    ["name" => "JENIS_PUSTAKA", "Value" => $request->input('jenis_pustaka')],
                    ["name" => "JENIS_KATEGORI", "Value" => $request->input('jenis_kategori')],
                    ["name" => "KETEBALAN", "Value" => $request->input('dimensi')],

                ];
                $IsbnResi = [
                    ["name" => "JML_JILID_REQ", "Value" => $jumlah_jilid],
                    ["name" => "LINK_BUKU", "Value" => $urls],
                ];

                if ($jumlah_jilid > 1) {
                    array_push($IsbnResi,
                        ["name" => "KETERANGAN_JILID", "Value" => $jilids]
                    );
                }
                // TAMBAH DATA PERMOHONAN
                array_push($ListData,
                    ["name" => "UPDATEBY", "Value" => $penerbit["ISBN_USER_NAME"] . "-api"],
                    ["name" => "UPDATEDATE", "Value" => now()->format('Y-m-d H:i:s')],
                    ["name" => "UPDATETERMINAL", "Value" => \Request::ip()]
                );
                // INSERT KE TABEL PENERBIT_TERBITAN
                $res = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=PENERBIT_TERBITAN&id=".$data[0]['PENERBIT_TERBITAN_ID']."&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));

                // INSERT KE TABEL ISBN_RESI
                array_push($IsbnResi,
                    ["name" => "STATUS", "Value" => "permohonan"],
                    ["name" => "UPDATEBY", "Value" => $penerbit["ISBN_USER_NAME"] . "-api"],
                    ["name" => "UPDATEDATE", "Value" => now()->format('Y-m-d H:i:s')],
                    ["name" => "UPDATETERMINAL", "Value" => \Request::ip()]
                );
                $res2 = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=ISBN_RESI&id=".$data[0]['ID']."&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($IsbnResi)));

            }
            /* ------------------------------------------------ simpan file ------------------------------------------*/
            if ($data[0]['JENIS'] == 'lepas') {
                $file = [
                    'file_dummy' => $request->file('file_dummy') ?? null,
                    'file_lampiran' => $request->file('file_lampiran') ?? null,
                    'file_cover' => $request->file('file_cover') ?? null,
                ];
                $call_func = $this->upload_file($file, $penerbit, $data[0]['PENERBIT_TERBITAN_ID'], \Request::ip(), '', $data[0]['ID']);
            } else {
                 //upload file jilid
                for ($i = 1; $i <= $jumlah_jilid; $i++) {
                    $file = [
                        "file_dummy_$i" => $request->file("file_dummy_$i") ?? null,
                        "file_lampiran_$i" => $request->file("file_lampiran_$i") ?? null,
                        "file_cover_$i" => $request->file("file_cover_$i") ?? null,
                    ];
                    $keterangan = "jilid " . $i;
                    $call_func = $this->upload_file($file, $penerbit, $data[0]['PENERBIT_TERBITAN_ID'], \Request::ip(), $keterangan, $data[0]['ID']);
                }
            }
            //RETURN DATA YANG DIINPUT
            $sql_terbitan = "SELECT ir.noresi, ir.mohon_date, ir.jenis, ir.status, ir.createby,
                        pt.title, ir.jml_jilid_req, pt.jilid_volume, ir.link_buku, pt.author, pt.kepeng, pt.sinopsis as deskripsi,
                        pt.distributor, pt.tempat_terbit, pt.edisi, pt.seri, pt.bulan_terbit, pt.tahun_terbit,
                        pt.jml_hlm, pt.ketebalan as dimensi,  pt.jenis_media, pt.jenis_terbitan, pt.jenis_pustaka, pt.jenis_kategori,
                        pt.jenis_kelompok, pt.jenis_penelitian
                        FROM PENERBIT_TERBITAN pt JOIN ISBN_RESI ir ON ir.penerbit_terbitan_id = pt.id WHERE ir.id=" . $data[0]['ID'];
            $data_terbitan = kurl("get", "getlistraw", "", $sql_terbitan, 'sql', '')["Data"]["Items"][0];
            //\Log::info($res);
            return response()->json([
                'status' => 'Success',
                'message' => 'Data permohonan berhasil diubah.',
                'noresi' => $noresi,
                'data' => $data_terbitan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Server Error. Data permohonan gagal disimpan. Server Error!',
                'noresi' => $e->getMessage(),
            ], 500);
        }

    }
    public function tracking($noresi)
    {
        $sql = "SELECT ir.id, ir.noresi, ir.mohon_date, ir.jenis, ir.status, ir.createby,
                    pt.title, ir.jml_jilid_req, pt.jilid_volume, ir.link_buku, pt.author, pt.kepeng, pt.sinopsis as deskripsi,
                    pt.distributor, pt.tempat_terbit, pt.edisi, pt.seri, pt.bulan_terbit, pt.tahun_terbit,
                    pt.jml_hlm, pt.ketebalan as dimensi,  pt.jenis_media, pt.jenis_terbitan, pt.jenis_pustaka, pt.jenis_kategori,
                    pt.jenis_kelompok, pt.jenis_penelitian
                    FROM PENERBIT_TERBITAN pt JOIN ISBN_RESI ir ON ir.penerbit_terbitan_id = pt.id WHERE ir.noresi='$noresi'";
        //\Log::info($sql);
        $data = kurl("get", "getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
        if (isset($data[0])) {
            if($data[0]['STATUS'] == 'pending'){
                $masalah = kurl("get", "getlistraw", "", "SELECT * FROM PENERBIT_ISBN_MASALAH WHERE ISBN_RESI_ID=$data[0]['ID'] AND IS_SOLVE=0", 'sql', '')["Data"]["Items"];
                $data = array_merge($data, [
                    "masalah" => $masalah[0]
                ]);
            }
            return response()->json($data[0]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Nomor resi tidak ditemukan',
            ], 500);
        }
    }

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

        $sql = "SELECT ir.noresi, ir.jenis as jenis_permohonan, ir.source, ir.link_buku, ir.jml_jilid_req, ir.keterangan_jilid, ir.mohon_date, 
                pt.title,  pt.jilid_volume, pt.author, pt.kepeng, pt.sinopsis, pt.distributor, pt.tempat_terbit, pt.edisi, pt.seri, pt.bulan_terbit, pt.tahun_terbit,
                pt.jml_hlm, pt.ketebalan as dimensi, pt.jenis_media, pt.jenis_terbitan, pt.jenis_pustaka, pt.jenis_kategori, pt.jenis_kelompok, pt.jenis_penelitian
                FROM ISBN_RESI ir
                JOIN penerbit_terbitan pt on ir.penerbit_terbitan_id = pt.id
                WHERE ir.PENERBIT_ID =$id ";

        $sqlFiltered = "SELECT ir.id FROM ISBN_RESI ir JOIN PENERBIT_TERBITAN pt on ir.penerbit_terbitan_id = pt.id
                        JOIN penerbit_isbn pi on pi.penerbit_terbitan_id = pt.id
                        WHERE ir.penerbit_id = $id ";
        $sqlWhere = "";
        $query = [];
        if($request->input('noresi')){
            $sqlWhere .= " AND (CONCAT('WIN',(upper(ir.noresi))) like 'WIN%".strtoupper($request->input('noresi'))."%')";
            array_push($query, [
                "field" => "noresi",
                "value" => $request->input('noresi')
            ]);
        }
        if($request->input('distributor')){
            $sqlWhere .= " AND (CONCAT('WIN',(upper(ir.distributor))) like 'WIN%".strtoupper($request->input('distributor'))."%')";
            array_push($query, [
                "field" => "noresi",
                "value" => $request->input('noresi')
            ]);
        }
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
        if($request->input('date_start')){
            $sqlWhere .= " AND MOHON_DATE >= TO_DATE('".$request->input('date_start')."', 'yyyy-mm-dd')";
             array_push($query, [
                "field" => "date_start",
                "value" => $request->input('date_start')
            ]);
        }
        if($request->input('date_end')){
            $sqlWhere .= " AND MOHON_DATE <= TO_DATE('".$request->input('date_end')."', 'yyyy-mm-dd')";
             array_push($query, [
                "field" => "date_end",
                "value" => $request->input('date_end')
            ]);
        }

        //\Log::info("SELECT outer.* FROM (SELECT ROWNUM nomor, inner.* FROM ($sql $sqlWhere) inner) outer WHERE nomor >$start AND nomor <= $end");
        $data = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM nomor, inner.* FROM ($sql $sqlWhere) inner) outer WHERE nomor >$start AND nomor <= $end", 'sql', '')["Data"]["Items"];  
        // \Log::info("SELECT COUNT(*) JML FROM PENERBIT_ISBN WHERE PENERBIT_ID=$id");
        $totalData = kurl("get","getlistraw", "", "SELECT COUNT(*) JML FROM ISBN_RESI WHERE PENERBIT_ID=$id",'sql', '')["Data"]["Items"][0]["JML"];    
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
    public function validasiLepas($request, $id, $penerbit_terbitan_id, $perbaikan = false)
    {
        $rules = [];
        $messages = [];
        if ($perbaikan) {
            $rules = array_merge($rules, [
                'jenis_permohonan' => 'required',
                'title' => 'required|title_exists:' . $id.','.$penerbit_terbitan_id,
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
                'tahun_terbit' => 'required|tahun_terbit_min',
                'bulan_terbit' => 'required|bulan_terbit_min:' . $request->input('tahun_terbit'),
                'tahun_terbit.tahun_terbit_min' => 'Tahun terbit yang Anda masukan tidak boleh kurang dari tahun ' . date('Y'),
                'bulan_terbit.bulan_terbit_min' => 'Bulan terbit yang Anda masukan tidak boleh kurang dari bulsn ' . date('m-Y'),
            ]);
            $messages = array_merge($messages, [
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
            ]);
        } else {
            $rules = array_merge($rules, [
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
                'tahun_terbit' => 'required|tahun_terbit_min',
                'bulan_terbit' => 'required|bulan_terbit_min:' . $request->input('tahun_terbit'),
            ]);
            $messages = array_merge($messages, [
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
                'tahun_terbit.required' => 'Anda belum mengisi tahun terbit',
                'bulan_terbit.required' => 'Anda belum mengisi bulan terbit',
                'tahun_terbit.tahun_terbit_min' => 'Tahun terbit yang Anda masukan tidak boleh kurang dari tahun ' . date('Y'),
                'bulan_terbit.bulan_terbit_min' => 'Bulan terbit yang Anda masukan tidak boleh kurang dari bulsn ' . date('m-Y'),
            ]);
        }
        //\Log::info([$rules, $messages]);
        return [$rules, $messages];
    }
    public function validasiJilid(Request $request, $id, $penerbit_terbitan_id,$perbaikan = false)
    {
        $rules = [];
        $messages = [];
        if ($perbaikan) {
            $rules = array_merge($rules, [
                'jenis_permohonan' => 'required',
                'title' => 'required|title_exists:' . $id . "," . $penerbit_terbitan_id,
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
                'file_dummy' => 'array',
                'file_lampiran' => 'array',
                'tahun_terbit' => 'required|tahun_terbit_min',
                'bulan_terbit' => 'required|bulan_terbit_min:' . $request->input('tahun_terbit'),
            ]);
            $messages = array_merge($messages, [
                'jenis_permohonan.required' => 'Anda belum mengisi jenis permohonan!',
                'title.required' => 'Anda belum mengisi judul buku',
                'title.title_exists' => 'Judul buku sudah ada, Anda tidak dapat memohon ISBN baru dengan judul yang sama.',
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
                'tahun_terbit.tahun_terbit_min' => 'Tahun terbit yang Anda masukan tidak boleh kurang dari tahun ' . date('Y'),
                'bulan_terbit.bulan_terbit_min' => 'Bulan terbit yang Anda masukan tidak boleh kurang dari bulsn ' . date('m-Y'),
            ]);
        } else {
            $rules = array_merge($rules, [
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
                'tahun_terbit' => 'required|tahun_terbit_min',
                'bulan_terbit' => 'required|bulan_terbit_min:' . $request->input('tahun_terbit'),
            ]);
            $messages = array_merge($messages, [
                'jenis_permohonan.required' => 'Anda belum mengisi jenis permohonan!',
                'title.required' => 'Anda belum mengisi judul buku',
                'title.title_exists' => 'Judul buku sudah ada, Anda tidak dapat memohon ISBN baru dengan judul yang sama.',
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
                'tahun_terbit.tahun_terbit_min' => 'Tahun terbit yang Anda masukan tidak boleh kurang dari tahun ' . date('Y'),
                'bulan_terbit.bulan_terbit_min' => 'Bulan terbit yang Anda masukan tidak boleh kurang dari bulsn ' . date('m-Y'),
            ]);

            for($i = 1; $i <= intval($request->input('jumlah_jilid')); $i++){
                $rules = array_merge($rules, [
                    "file_lampiran_$i" => 'required',
                    "file_dummy_$i" => 'required',
                    "link_buku_$i" => 'required',
                ]);
                $messages = array_merge($messages, [
                    "file_lampiran_$i.required" => "File lampiran untuk jilid $i perlukan!",
                    "file_dummy_$i.required" => "File dummy untuk jilid $i diperlukan!",
                    "link_buku_$i.required" => "Link publikasi buku jilid $i diperlukan!",
                ]);
            }
        }
        return [$rules, $messages];
    }

    public function upload_file($file, $penerbit, $terbitan_id, $ip, $keterangan, $resi_id, $is_masalah = false)
    {
        //\Log::info($file);
        $gagal = [];
        if($keterangan  != "") {
            $jilid = "_" . explode("jilid ", $keterangan)[1];
        } else {
            $jilid = "";
        }
        \Log::info($jilid);
        
        if ($is_masalah) {
            //file lampiran  
            if ($file["file_lampiran" .$jilid]) {
                $filePath_one = public_path('file_tmp_upload/') . $this->uploadToLocal($file["file_lampiran" . $jilid]);
                if (File::exists($filePath_one)) {
                    $file_one = new UploadedFile(
                        $filePath_one,
                        $file["file_lampiran" . $jilid],
                        File::mimeType($filePath_one),
                        null,
                        true
                    );
                    kurl_upload('post', $penerbit, $terbitan_id, "lampiran_pending", $file_one, $ip, $keterangan, $resi_id);
                    //File::delete($filePath_one);
                }
            }
        } else {
            //file lampiran
            if ($file["file_lampiran".$jilid]) {
                \Log::info("nemu " . "file_lampiran".$jilid );
                $filePath_one = $this->uploadToLocal($file["file_lampiran" . $jilid]);
                if (File::exists(public_path('file_tmp_upload/') . $filePath_one)) {
                    $file_one = new UploadedFile(
                        public_path('file_tmp_upload/') . $filePath_one,
                        $filePath_one ,
                        File::mimeType(public_path('file_tmp_upload/') . $filePath_one),
                        null,
                        true
                    );
                    kurl_upload('post', $penerbit, $terbitan_id, "lampiran_permohonan", $file_one, $ip, $keterangan, $resi_id);
                    //File::delete(public_path('file_tmp_upload/') . $filePath_one);
                }
            } 
        }
        //file dummy
        if ($file["file_dummy".$jilid]) {
            $filePath = $this->uploadToLocal($file["file_dummy" . $jilid]);
                if (File::exists(public_path('file_tmp_upload/') . $filePath)) {
                    $file_ = new UploadedFile(
                        public_path('file_tmp_upload/') . $filePath,
                        $filePath ,
                        File::mimeType(public_path('file_tmp_upload/') . $filePath),
                        null,
                        true
                    );
                    kurl_upload('post', $penerbit, $terbitan_id, "dummy_buku", $file_, $ip, $keterangan, $resi_id);
                    //File::delete(public_path('file_tmp_upload/') . $filePath);
                }
        }
        //file cover
        if ($file["file_cover".$jilid]) {
             $filePath = $this->uploadToLocal($file["file_cover" . $jilid]);
                if (File::exists(public_path('file_tmp_upload/') . $filePath)) {
                    $file_ = new UploadedFile(
                        public_path('file_tmp_upload/') . $filePath,
                        $filePath ,
                        File::mimeType(public_path('file_tmp_upload/') . $filePath),
                        null,
                        true
                    );
                    kurl_upload('post', $penerbit, $terbitan_id, "cover", $file_, $ip, $keterangan, $resi_id);
                    //File::delete(public_path('file_tmp_upload/') . $filePath);
                }
        }
    }

    function uploadToLocal($file)
    {
        //\Log::info($file);
        $path = public_path('file_tmp_upload');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);
        return $name;
    }


}
