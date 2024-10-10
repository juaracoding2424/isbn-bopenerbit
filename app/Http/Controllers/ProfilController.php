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
                        P.FILE_AKTE_NOTARIS, P.FILE_SP as FILE_SURAT_PERNYATAAN
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
                //'name' => 'required:min:8',
                //'username' => 'required|min:6',
                'phone' => 'required',
                'alamat_penerbit' => 'required',
                //'nama_gedung' => 'required',
                'provinsi' => 'required',
                'kabkot' => 'required',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                ],[
                //'name.required' => 'Anda belum mengisi nama penerbit',
                //'name.min' => 'Nama penerbit minimum terdiri dari 8 karakter',
                //'username.required' => 'Anda belum mengisi username',
                //'username.min' => 'Username minimal terdiri dari 6 karakter',
                'phone.required' => 'Anda belum mengisi nomor telp/hp kantor yang bisa dihubungi',
                //'phone.numeric' => 'Nomor telp/hp kantor hanya boleh diisi oleh angka!',
                'alamat_penerbit.required' => 'Anda belum mengisi alamat kantor',
                //'nama_gedung.required' => 'Anda belum mengisi nama gedung',
                'provinsi.required' => 'Anda belum mengisi provinsi tempat domisili kantor',
                'kabkot.required' => 'Anda belum mengisi kota/kabupaten tempat domisili kantor',
                'kecamatan.required' => 'Anda belum mengisi kecamatan tempat domisili kantor',
                'kelurahan.required' => 'Anda belum mengisi kelurahan tempat domisili kantor',
            ]);
            if($validator->fails()){
                return response()->json([
                    'status' => 'Failed',
                    'message'   => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                    'err' => $validator->errors(),
                ], 422);
            } else {  
                $file = [
                    'file_surat_pernyataan' => $request->file('file_surat_pernyataan') ?? null,
                    'file_akte_notaris' => $request->file('file_akte_notaris') ?? null,
                ];

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
                        [ "name"=>"UPDATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                        [ "name"=>"UPDATETERMINAL", "Value"=> \Request::ip()]
                    ];
                    $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=PENERBIT&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));
                  
                    //ganti file file_akte_notaris kalau ada
                    if($request->hasFile('avatar')) {
                        $params = [
                            'penerbitid' => $id,
                            'actionby' => session('penerbit')['USERNAME'],
                            'terminal' => \Request::ip()
                        ];
                        kurl("post", "deletepenerbitfoto",'', '','', $params);
                        \Log::info($request->input('avatar'));
                        /*$file_foto = new UploadedFile(
                            $filePath_an,
                            $file['file_akte_notaris'],
                            File::mimeType($filePath_an),
                            null,
                            true
                        );*/
                        kurl_upload_file_penerbit('uploadpenerbitfoto', session('penerbit'), 'penerbitid', $request->file('avatar'), \Request::ip());
                    }
                    //ganti file file_akte_notaris kalau ada
                    if($request->hasFile('file_akte_notaris')) {
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
                        kurl_upload_file_penerbit('uploadfileaktenotaris', session('penerbit'), 'penerbitid', $file_an, \Request::ip());
                    }
                    
                    //ganti file surat pernyataan jika ada
                    if($request->hasFile('file_surat_pernyataan') ) {
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
                        kurl_upload_file_penerbit('uploadfilesuratpernyataan', session('penerbit'), 'penerbitid', $file_sp, \Request::ip());
                    }
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
                        [ "name"=>"UPDATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                        [ "name"=>"UPDATETERMINAL", "Value"=> \Request::ip()]
                    ];
                    if(session('penerbit')['VALIDASI'] == 'P'){
                        array_push($ListData,  [ "name"=>"VALIDASI", "Value"=> '']);
                        $params = [
                            ["name" => "NamaPenerbit", "Value" => session('penerbit')['NAME']],
                        ];
                        sendMail(18, $params, session('penerbit')['EMAIL'], 'Perbaikan pendaftaran akun penerbit ' . session('penerbit')['NAME']);
                    }
                    $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=ISBN_REGISTRASI_PENERBIT&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));
                     //ganti file file_akte_notaris kalau ada
                     if($request->hasFile('file_akte_notaris') !== null) {
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
                        kurl_upload_file_penerbit('uploadfileaktenotaris', session('penerbit'), 'isbn_registrasi_penerbit_id', $file_an, \Request::ip());
                    }
                    
                    //ganti file surat pernyataan jika ada
                    if($request->hasFile('file_surat_pernyataan') !== null ) {
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
                        kurl_upload_file_penerbit('uploadfilesuratpernyataan', session('penerbit'), 'isbn_registrasi_penerbit_id', $file_sp, \Request::ip());
                    }
                }
                

                return response()->json([
                    'status' => 'Success',
                    'message' => 'Perubahan data akun Anda berhasil disimpan.',
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
