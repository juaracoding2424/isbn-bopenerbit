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
        
        $start = $start;
        $end = $start + $length;

        $sql  = "SELECT *
                    FROM PENERBIT_TERBITAN pt
                    WHERE pt.PENERBIT_ID='$id' AND (pt.status='' OR pt.status='permohonan' OR pt.status is NULL) ";
        $sqlFiltered = "SELECT count(*) JUMLAH FROM PENERBIT_TERBITAN pt WHERE pt.PENERBIT_ID='$id' AND (pt.status='' OR pt.status='permohonan' OR pt.status is NULL) ";

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
                if($advSearch["param"] == 'no_resi'){
                    $sqlFiltered .= " AND lower(pt.noresi) like '%".strtolower($advSearch["value"])."%'";
                    $sql .= " AND lower(pt.noresi) like '%".strtolower($advSearch["value"])."%'";
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
                "sql" => "SELECT count(*) JUMLAH FROM PENERBIT_TERBITAN WHERE PENERBIT_ID='$id' AND (status='' OR status='permohonan' OR status is NULL) "
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
                $noresi = $val['NORESI'] ? $val['NORESI'] : $val['ID'];
                $response['data'][] = [
                    $nomor,
                    $val['NORESI'],
                    $val['TITLE'],
                    $val['AUTHOR'] ? $val['AUTHOR'] . ', pengarang; ' . $val['KEPENG'] : $val['KEPENG'],
                    $val['TAHUN_TERBIT'],
                    $val['MOHON_DATE'],
                    '<a class="badge badge-info h-30px m-1" href="/penerbit/isbn/permohonan/detail/'.$noresi.'">Ubah Data</a><a class="badge badge-danger h-30px m-1" href="#" onclick="batalkanPermohonan('.$id.')">Batalkan Permohonan</a>',
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
                }
                if(request('status') == 'lepas') {
                    $ListData = [
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
                        [ "name"=>"LINK_BUKU", "Value"=> request('url')[0] ],
                        [ "name"=>"STATUS", "Value"=> 'permohonan']
                    ];
                    if(request('penerbit_terbitan_id') != ''){
                        array_push($ListData, 
                            [ "name"=>"UPDATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                            [ "name"=>"UPDATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"UPDATETERMINAL", "Value"=> \Request::ip()]
                        );
                        
                        $id = request('penerbit_terbitan_id');
                        \Log::info(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=PENERBIT_TERBITAN&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));
                        $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=PENERBIT_TERBITAN&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));
                    } else{
                        array_push($ListData, 
                            [ "name"=>"MOHON_DATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"PENERBIT_ID", "Value"=> session('penerbit')["ID"] ], //erlangga
                            [ "name"=>"IS_KDT_VALID", "Value"=> '0' ],
                            [ "name"=>"CREATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                            [ "name"=>"CREATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"CREATETERMINAL", "Value"=> \Request::ip()]
                        );
                        //\Log::info($ListData);
                        $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=PENERBIT_TERBITAN&issavehistory=1&ListAddItem=" . urlencode(json_encode($ListData)));
                        $id = $res['Data']['ID'];
                    }
                    //\Log::info($res);
                    $file = [
                        'file_dummy' => $request->input('file_dummy') ?? null,
                        'file_lampiran' => $request->input('file_lampiran') ?? null
                    ];
                    $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip());
                    //jika upload doc gagal maka akan rollback (hapus data)
                    if ($call_func['status'] == 0 ) {
                        $hapus_data = $this->rollback_permohonan($id);
                        $sts_ket = 'error';
                        $ket = 'gagal upload file';
                        //masukkan kedalam log untuk kegunaan tracking data
                    }
                    //\Log::info(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=PENERBIT_TERBITAN&issavehistory=1&ListAddItem=" . json_encode($addData));
                } else {
                    $jumlah_jilid = intval(request('jumlah_jilid'));
                    for($i = 0; $i < $jumlah_jilid; $i++){
                        $ListData = [
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
                            [ "name"=>"JML_JILID", "Value" => $jumlah_jilid],
                            [ "name"=>"STATUS", "Value"=> 'permohonan'],
                            [ "name"=>"PENERBIT_ID", "Value"=> session('penerbit')["ID"] ],
                            [ "name"=>"IS_KDT_VALID", "Value"=> '0' ],
                            [ "name"=>"CREATEBY", "Value"=> session('penerbit')["USERNAME"]], //nama user penerbit
                            [ "name"=>"CREATEDATE", "Value"=> now()->format('Y-m-d H:i:s') ],
                            [ "name"=>"CREATETERMINAL", "Value"=> \Request::ip()],
                        ];
                        $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=add&table=PENERBIT_TERBITAN&issavehistory=1&ListAddItem=" . urlencode(json_encode($addData)));
                        $id = $res['Data']['ID'];
                        $call_func = $this->upload_file($file, $penerbit, $id, \Request::ip());
                        //jika upload doc gagal maka akan rollback (hapus data)
                        if ($call_func['status'] == 0 ) {
                            $hapus_data = $this->rollback_permohonan($id);
                            $sts_ket = 'error';
                            $ket = 'gagal upload file';
                            //masukkan kedalam log untuk kegunaan tracking data
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
        } catch(\Exception $e){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Data permohonan gagal disimpan. Server Error!',
                'noresi' => $e->getMessage()
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
            'id' => $id,
        ];
        $data = kurl('get','delete', 'PENERBIT_TERBITAN', '', '' , $params);
        return $data['Status'];
    }

    //send file lampiran dan dummy
    function upload_file($file, $penerbit, $terbitan_id, $ip) 
    {
        $gagal = [];
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
                $post_pernyataan = kurl_upload('post', $penerbit, $terbitan_id, "lampiran_permohonan", $file_one, $ip);
                $res_pernyataan = $post_pernyataan;
                //res status
                $gagal['lampiran'] = $res_pernyataan['Status'] == "Success" ? 0 : 1;
            }
        }
        //file dummy
        if ($file['file_dummy']) {
            $filePath_two = public_path('file_tmp_upload/'.$file['file_dummy']);
            if (File::exists($filePath_two)) {
                $file_one = new UploadedFile(
                    $filePath_two,
                    $file['file_dummy'],
                    File::mimeType($filePath_two),
                    null,
                    true
                );
                $post_akte_notaris = kurl_upload('post', $penerbit, $terbitan_id, "dummy_buku", $file_one, $ip);
                $res_akte = $post_akte_notaris;
                //res status
                $gagal['dummy']  = $res_akte['Status'] == "Success" ? 0 : 1;
            }
        }

        $mess = '';
        $sts = '';
        foreach ($gagal as $k => $v) {
            if ($v > 0) {
                $sts = 0;
                $mess = 'gagal upload '. $k;
                break; 
            } else {
                $sts = 1;
                $mess = 'sukses upload semua files';
            }
        }
        $data = [
            // 'status' => 0, // keperluan debug untuk file yang gagal upload
            'status' => $sts,
            'message' => $mess
        ];
        return $data;
    }

    function detail($noresi)
    {
        $detail =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=SELECT * FROM PENERBIT_TERBITAN WHERE NORESI='$noresi'");
        if(!isset($detail["Data"]["Items"][0])) {
            $detail =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=SELECT * FROM PENERBIT_TERBITAN WHERE ID='$noresi'");
        }
        if(intval($detail["Data"]["Items"][0]["JML_JILID"]) > 1){
            $status = "jilid";
        } else {
            $status = "lepas";
        }        
        $data = [
            'status' => $status,
            'detail' => $detail["Data"]["Items"],
            'noresi' => $noresi,
        ];
        return view('edit_isbn', $data);
    }

    function getDetail($id)
    {
        $detail =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=getlistraw&sql=SELECT * FROM PENERBIT_TERBITAN WHERE ID='$id'");
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
}
