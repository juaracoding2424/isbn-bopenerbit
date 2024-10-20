<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use \Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{
    function getDetail()
    {
        $id = session('penerbit')['ID'];
        if(session('penerbit')['STATUS'] == 'valid') {
            $sql = "SELECT 'VALID' STATUS, PROPINSI.NAMAPROPINSI,  KABUPATEN.NAMAKAB, KABUPATEN.CODE_SORT CODEKAB,
                        P.NAME NAMA_PENERBIT, P.EMAIL1 ADMIN_EMAIL, P.EMAIL2 ALTERNATE_EMAIL, P.PROVINCE_ID, P.CITY_ID, P.DISTRICT_ID, P.VILLAGE_ID,
                        P.ALAMAT ALAMAT_PENERBIT, P.ID, P.TELP1 ADMIN_PHONE, P.TELP2 ALTERNATE_PHONE, P.NAMA_GEDUNG, P.ISBN_USER_NAME USER_NAME,
                        P.FILE_AKTE_NOTARIS, P.FILE_SP as FILE_SURAT_PERNYATAAN, P.KONTAK1 ADMIN_CONTACT_NAME, P.KONTAK2 ALTERNATE_CONTACT_NAME,
                        P.WEBSITE WEBSITE_URL, P.KODEPOS
              FROM PENERBIT P 
                        LEFT JOIN PROPINSI on propinsi.id = P.PROVINCE_ID
                        LEFT JOIN KABUPATEN ON KABUPATEN.id = P.CITY_ID
                        WHERE P.ID=$id";
            $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0];
        } else {
            $sql = "SELECT 'NOTVALID' STATUS, IR.*,
                        PROPINSI.NAMAPROPINSI, KABUPATEN.NAMAKAB FROM ISBN_REGISTRASI_PENERBIT IR 
                        LEFT JOIN PROPINSI on propinsi.id = IR.PROVINCE_ID
                        LEFT JOIN KABUPATEN ON KABUPATEN.id = IR.CITY_ID
                        WHERE IR.ID=$id";
            $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0];
        }
        return $data;
    }

    function submit(Request $request)
    {
        try {
            $id = session('penerbit')['ID'];
            $validator = \Validator::make(request()->all(),[
                'phone' => 'required',
                'alamat_penerbit' => 'required',
                //'nama_gedung' => 'required',
                'provinsi' => 'required',
                'kabkot' => 'required',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                'admin' => 'required',
                'kodepos' => 'required',
                'website'   =>'required'
                ],[
                'phone.required' => 'Anda belum mengisi nomor telp/hp kantor yang bisa dihubungi',
                //'phone.numeric' => 'Nomor telp/hp kantor hanya boleh diisi oleh angka!',
                'alamat_penerbit.required' => 'Anda belum mengisi alamat kantor',
                //'nama_gedung.required' => 'Anda belum mengisi nama gedung',
                'provinsi.required' => 'Anda belum mengisi provinsi tempat domisili kantor',
                'kabkot.required' => 'Anda belum mengisi kota/kabupaten tempat domisili kantor',
                'kecamatan.required' => 'Anda belum mengisi kecamatan tempat domisili kantor',
                'kelurahan.required' => 'Anda belum mengisi kelurahan tempat domisili kantor',
                'admin.required' => 'Anda belum mengisi nama admin pengelola ISBN',
                'kodepos.required' => 'Anda belum mengisi kodepos domisili kantor',
                'website.required' => 'Anda belum mengisi alamat website. Website diperlukan untuk pengecekan buku yang akan Anda terbitkan.',
            ]);
            if($validator->fails()){
                return response()->json([
                    'status' => 'Failed',
                    'message'   => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                    'err' => $validator->errors(),
                ], 422);
            } else {  
                $perbaikan = false;
                $file = [
                    'file_surat_pernyataan' => $request->input('file_surat_pernyataan') ?? null,
                    'file_akte_notaris' => $request->input('file_akte_notaris') ?? null,
                ];
                $foto = null;
                if(session('penerbit')['STATUS'] == 'valid'){
                    $ListData = [
                        //[ "name"=>"NAME", "Value"=> request('name') ],
                        //[ "name"=>"ISBN_USER_NAME", "Value"=> request('username') ],
                        [ "name"=>"TELP1", "Value"=> request('phone')],
                        [ "name"=>"ALAMAT", "Value"=> request('alamat_penerbit')],
                        [ "name"=>"NAMA_GEDUNG", "Value"=> request('nama_gedung') ],
                        [ "name"=>"PROVINCE_ID", "Value"=> request('provinsi') ],
                        [ "name"=>"CITY_ID", "Value"=> request('kabkot') ],
                        [ "name"=>"DISTRICT_ID", "Value"=> request('kecamatan') ],
                        [ "name"=>"VILLAGE_ID", "Value"=> request('kelurahan') ],
                        [ "name"=>"TELP2", "Value"=> request('phone_alternatif')],
                        [ "name"=>"KONTAK1", "Value"=> request('admin')],
                        [ "name"=>"KONTAK2", "Value"=> request('admin_alternatif') ],
                        [ "name"=>"WEBSITE", "Value"=> request('website')],
                        [ "name"=>"KODEPOS", "Value"=> request('kodepos')],
                        [ "name"=>"UPDATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                        [ "name"=>"UPDATETERMINAL", "Value"=> \Request::ip()]
                    ];
                    $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=PENERBIT&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));

                    //ganti file avatar kalau ada
                    if($request->hasFile('avatar')) {
                        $params = [
                            'penerbitid' => $id,
                            'actionby' => session('penerbit')['USERNAME'],
                            'terminal' => \Request::ip()
                        ];
                        kurl("post", "deletepenerbitfoto",'', '','', $params);            
                        $foto = kurl_upload_file_penerbit('post','uploadpenerbitfoto', session('penerbit'), 'penerbitid', $request->file('avatar'), \Request::ip());
                        if($foto["Status"] == "Success"){
                            $foto = config('app.isbn_file_location') . $foto["Data"];
                            $type = pathinfo($foto, PATHINFO_EXTENSION);
                            $data = file_get_contents($foto);
                            $foto = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    }
                    //ganti file file_akte_notaris kalau ada
                    if($file['file_akte_notaris']) {
                        $params = [
                            'penerbitid' => $id,
                            'actionby' => session('penerbit')['USERNAME'],
                            'terminal' => \Request::ip()
                        ];
                        kurl("post", "deletefileaktenotaris",'', '','', $params);
                        $filePath_an = public_path('file_tmp_upload/'.$file['file_akte_notaris']);
                        $file_an = new UploadedFile(
                            $filePath_an,
                            $file['file_akte_notaris'],
                            File::mimeType($filePath_an),
                            null,
                            true
                        );
                        $response = kurl_upload_file_penerbit('post','uploadfileaktenotaris', session('penerbit'), 'penerbitid', $file_an, \Request::ip());
                        if($response["Status"] == "Success"){
                            $file['file_akte_notaris'] = config('app.isbn_file_location') . $response["Data"];
                        }
                    }
                    
                    //ganti file surat pernyataan jika ada
                    if($file['file_surat_pernyataan'] ) {
                        $params = [
                            'penerbitid' => $id,
                            'actionby' => session('penerbit')['USERNAME'],
                            'terminal' => \Request::ip()
                        ];
                        kurl("post", "deletefilesuratpernyataan",'', '', '', $params);
                        $filePath_sp = public_path('file_tmp_upload/'.$file['file_surat_pernyataan']);
                        $file_sp = new UploadedFile(
                            $filePath_sp,
                            $file['file_surat_pernyataan'],
                            File::mimeType($filePath_sp),
                            null,
                            true
                        );
                        $response =  kurl_upload_file_penerbit('post','uploadfilesuratpernyataan', session('penerbit'), 'penerbitid', $file_sp, \Request::ip());
                        if($response["Status"] == "Success"){
                            $file['file_surat_pernyataan'] = config('app.isbn_file_location') . $response["Data"];
                        }
                    }
                    $penerbit = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT WHERE ID = ".session('penerbit')['ID'], 'sql', '')["Data"]["Items"][0];
                    session([
                        'penerbit' => [
                            'STATUS' => 'valid',
                            'ID' => $penerbit['ID'],
                            'USERNAME' => $penerbit['ISBN_USER_NAME'],
                            'EMAIL' => $penerbit['EMAIL1'],
                            'NAME' => $penerbit['NAME'],
                            'PROVINCE_ID' => $penerbit['PROVINCE_ID'],
                            'CITY_ID' => $penerbit['CITY_ID'],
                            'DISTRICT_ID' => $penerbit['DISTRICT_ID'],
                            'VILLAGE_ID' => $penerbit['VILLAGE_ID'],
                            'GROUP' => $semua_id_penerbit,
                            'IS_LOCK' => $penerbit['IS_LOCK']
                    ]]);
                } else {
                    $ListData = [
                        //[ "name"=>"NAMA_PENERBIT", "Value"=> request('name') ],
                        //[ "name"=>"USERNAME", "Value"=> request('username') ],
                        [ "name"=>"ADMIN_PHONE", "Value"=> request('phone')],
                        [ "name"=>"ALAMAT_PENERBIT", "Value"=> request('alamat_penerbit')],
                        [ "name"=>"NAMA_GEDUNG", "Value"=> request('nama_gedung') ],
                        [ "name"=>"PROVINCE_ID", "Value"=> request('provinsi') ],
                        [ "name"=>"CITY_ID", "Value"=> request('kabkot') ],
                        [ "name"=>"DISTRICT_ID", "Value"=> request('kecamatan') ],
                        [ "name"=>"VILLAGE_ID", "Value"=> request('kelurahan') ],
                        [ "name"=>"ALTERNATE_PHONE", "Value"=> request('phone_alternatif')],
                        [ "name"=>"ADMIN_CONTACT_NAME", "Value"=> request('admin')],
                        [ "name"=>"ALTERNATE_CONTACT_NAME", "Value"=> request('admin_alternatif') ],
                        [ "name"=>"WEBSITE_URL", "Value"=> request('website')],
                        [ "name"=>"KODEPOS", "Value"=> request('kodepos')],
                        [ "name"=>"UPDATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                        [ "name"=>"UPDATETERMINAL", "Value"=> \Request::ip()]
                    ];
                    if(session('penerbit')['VALIDASI'] == 'P'){
                        array_push($ListData, 
                                ["name"=>"VALIDASI", "Value"=> ''],
                                ["name"=>"KETERANGAN", "Value"=> '']
                        );
                        $params = [
                            ["name" => "NamaPenerbit", "Value" => session('penerbit')['NAME']],
                        ];
                        sendMail(18, $params, session('penerbit')['EMAIL'], 'Perbaikan pendaftaran akun penerbit ' . session('penerbit')['NAME']);
                        $perbaikan = true;
                    }
                    $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=ISBN_REGISTRASI_PENERBIT&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));
                    //ganti file avatar kalau ada
                    if($request->hasFile('avatar')) {
                        $params = [
                            'isbn_registrasi_penerbit_id' => $id,
                            'actionby' => session('penerbit')['USERNAME'],
                            'terminal' => \Request::ip()
                        ];
                        kurl("post", "deletepenerbitfoto",'', '','', $params);            
                        $foto = kurl_upload_file_penerbit('post','uploadpenerbitfoto', session('penerbit'), 'isbn_registrasi_penerbit_id', $request->file('avatar'), \Request::ip());
                        if($foto["Status"] == "Success"){
                            $foto = config('app.isbn_file_location') . $foto["Data"];
                            $type = pathinfo($foto, PATHINFO_EXTENSION);
                            $data = file_get_contents($foto);
                            $foto = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    }
                    //ganti file file_akte_notaris kalau ada
                    if($file['file_akte_notaris']) {
                        $params = [
                            'isbn_registrasi_penerbit_id' => $id,
                            'actionby' => session('penerbit')['USERNAME'],
                            'terminal' => \Request::ip()
                        ];
                        kurl("post", "deletefileaktenotaris",'', '', '', $params);
                        $filePath_an = public_path('file_tmp_upload/'.$file['file_akte_notaris']);
                        $file_an = new UploadedFile(
                            $filePath_an,
                            $file['file_akte_notaris'],
                            File::mimeType($filePath_an),
                            null,
                            true
                        );
                        $response = kurl_upload_file_penerbit('post','uploadfileaktenotaris', session('penerbit'), 'isbn_registrasi_penerbit_id', $file_an, \Request::ip());
                        if($response["Status"] == "Success"){
                            $file['file_akte_notaris'] = config('app.isbn_file_location') .$response["Data"];
                        }
                    }
                    
                    //ganti file surat pernyataan jika ada
                    if($file['file_surat_pernyataan']) {
                        $params = [
                            'isbn_registrasi_penerbit_id' => $id,
                            'actionby' => session('penerbit')['USERNAME'],
                            'terminal' => \Request::ip()
                        ];
                        kurl("post", "deletefilesuratpernyataan",'', '', '', $params);
                        $filePath_sp = public_path('file_tmp_upload/'.$file['file_surat_pernyataan']);
                        $file_sp = new UploadedFile(
                            $filePath_sp,
                            $file['file_surat_pernyataan'],
                            File::mimeType($filePath_sp),
                            null,
                            true
                        );
                        $response = kurl_upload_file_penerbit('post','uploadfilesuratpernyataan', session('penerbit'), 'isbn_registrasi_penerbit_id', $file_sp, \Request::ip());
                        if($response["Status"] == "Success"){
                            $file['file_surat_pernyataan'] = config('app.isbn_file_location') . $response["Data"];
                        }
                        
                    }
                   
                    $penerbit_belum_verifikasi = kurl("get","getlistraw", "", "SELECT * FROM ISBN_REGISTRASI_PENERBIT WHERE ID = ".session('penerbit')['ID'], 'sql', '')["Data"]["Items"][0];
                    session([
                            'penerbit' => [
                                'STATUS' => 'notvalid',
                                'ID' => $penerbit_belum_verifikasi['ID'],
                                'USERNAME' => $penerbit_belum_verifikasi['USER_NAME'],
                                'EMAIL' => $penerbit_belum_verifikasi['ADMIN_EMAIL'],
                                'NAME' => $penerbit_belum_verifikasi['NAMA_PENERBIT'],
                                'PROVINCE_ID' => $penerbit_belum_verifikasi['PROVINCE_ID'],
                                'CITY_ID' => $penerbit_belum_verifikasi['CITY_ID'],
                                'DISTRICT_ID' => $penerbit_belum_verifikasi['DISTRICT_ID'],
                                'VILLAGE_ID' => $penerbit_belum_verifikasi['VILLAGE_ID'],
                                'KETERANGAN' => $penerbit_belum_verifikasi['KETERANGAN'],
                                'VALIDASI' => $penerbit_belum_verifikasi['VALIDASI']
                            ]
                    ]);
                    session()->flash('message','Terima kasih atas pembaruan data Anda. Registrasi Anda sedang diproses kembali, harap menunggu verifikasi dari admin.');
                }
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Perubahan data akun Anda berhasil disimpan.',
                    'file' => $file,
                    'foto' => $foto,
                    'perbaikan' => $perbaikan
                ], 200);
            }
        } catch(\Exception $e){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Perubahan data akun Anda gagal disimpan. Server Error! ' .  $e->getMessage(),
            ], 500);
        }
    }

    function changeEmail(Request $request)
    {
        $id = session('penerbit')['ID'];
        $ip = $request->ip();
        $validator = \Validator::make($request->all(), [
            'confirmemailpassword'     => 'required',
            'alternateemailaddress'      => 'required',  
        ], [
            'confirmemailpassword.required' => 'Konfirmasi password diperlukan untuk mengubah email alternatif!',
            'alternateemailaddress.required' => 'Email alternatif tidak boleh kosong!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal! Cek kembali data yang Anda masukan!',
                'err' => $validator->errors(),
            ], 422);
        } 

        //encript password
        $encryptedPassword = urlencode(getMd5Hash($request->input('confirmemailpassword')));
        $encryptedPassword2 = urlencode(rijndaelEncryptPassword($request->input('confirmemailpassword'))); 
        $penerbit = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT WHERE ID='" . $id . "' AND (ISBN_PASSWORD1='$encryptedPassword' OR ISBN_PASSWORD2='$encryptedPassword2' OR ISBN_PASSWORD='$encryptedPassword')"));
        if (isset($penerbit["Data"]['Items'][0])) {
            if(checkEmail($request->input('alternateemailaddress'), 0 , 'isbn_registrasi_penerbit') > 0){
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Email ' . strtolower($request->input('alternateemailaddress')) . ' sudah dipakai!'
                ], 500);
            }
            if(checkEmail($request->input('alternateemailaddress'), $id, 'penerbit') > 0){
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Email ' . strtolower($request->input('alternateemailaddress')) . ' sudah dipakai!'
                ], 500);
            }
            $updated = [
                ["name" => "EMAIL2", "Value" => strtolower($request->input('alternateemailaddress'))],
            ];
            Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&id=$id&op=update&table=PENERBIT&ListUpdateItem=" . urlencode(json_encode($updated)));
            
            //INSERT HISTORY
            $history = [
                ["name" => "TABLENAME", "Value" => "PENERBIT"],
                ["name" => "IDREF", "Value" => $id],
                ["name" => "ACTION", "Value" => "Update"],
                ["name" => "ACTIONBY", "Value" => session('penerbit')['USERNAME']],
                ["name" => "ACTIONDATE", "Value" => now()->addHours(7)->format('Y-m-d H:i:s')],
                ["name" => "ACTIONTERMINAL", "Value" => $ip],
                ["name" => "NOTE", "Value" => "Email alternatif berhasil diganti menjadi " . strtolower($request->input('alternateemailaddress'))],
            ];
            Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
            
            return response()->json([
                'status' => 'Success',
                'message' => 'Berhasil ubah email alternatif.'
            ], 200);
        } else {
            //cari di tabel registrasi isbn
            $penerbit_belum_verifikasi = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM ISBN_REGISTRASI_PENERBIT WHERE id='" . $id . "' AND (PASSWORD='$encryptedPassword' OR PASSWORD2='$encryptedPassword2')"));
            if (isset($penerbit_belum_verifikasi["Data"]['Items'][0])) {
                if($penerbit_belum_verifikasi["Data"]['Items'][0]['VALIDASI'] == 'Y'){
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Password yang Anda masukan salah!',
                    ], 500);
                }
                if(checkEmail($request->input('alternateemailaddress'), 0 , 'penerbit') > 0){
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Email ' . strtolower($request->input('alternateemailaddress')) . ' sudah dipakai dan sudah pernah divalidasi pada akun lain!'
                    ], 500);
                }
                if(checkEmail($request->input('alternateemailaddress'), $id, 'isbn_registrasi_penerbit') > 0){
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Email ' . strtolower($request->input('alternateemailaddress')) . ' sudah dipakai!'
                    ], 500);
                }
                $penerbit_belum_verifikasi = $penerbit_belum_verifikasi["Data"]['Items'][0];
                $updated = [
                    ["name" => "ALTERNATE_EMAIL", "Value" => strtolower($request->input('alternateemailaddress'))],
                ];
                Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&id=$id&op=update&table=ISBN_REGISTRASI_PENERBIT&ListUpdateItem=" . urlencode(json_encode($updated)));
                
                //INSERT HISTORY
                $history = [
                    ["name" => "TABLENAME", "Value" => "ISBN_REGISTRASI_PENERBIT"],
                    ["name" => "IDREF", "Value" => $id],
                    ["name" => "ACTION", "Value" => "Update"],
                    ["name" => "ACTIONBY", "Value" => session('penerbit')['USERNAME']],
                    ["name" => "ACTIONDATE", "Value" => now()->addHours(7)->format('Y-m-d H:i:s')],
                    ["name" => "ACTIONTERMINAL", "Value" => $ip],
                    ["name" => "NOTE", "Value" => "Email alternatif berhasil diganti menjadi " . strtolower($request->input('alternateemailaddress'))],
                ];
                Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Berhasil ubah email alternatif.'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Password salah. Mohon cek kembali konfirmasi password yang Anda masukan!',
                ], 500);
            }
        }         
    }

    function index()
    {
        return view('profile');
    }

}
