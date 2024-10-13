<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DepositController extends Controller
{
    function receivedPerpusnas(Request $request)
    {
        $token = $request->input('token');
        $isbn = str_replace("-", "",$request->input('isbn'));
        $date = $request->input('datetime');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        $validator = \Validator::make($request->all(), [
            'datetime'  => 'required|date_format:Y-m-d H:i:s',
            'token'     => 'required',
            'isbn'      => 'required',      
        ], [
            'datetime.date_format' => 'Format tanggal dan waktu tidak sesuai. Format yang benar adalah Y-m-d H:i:s. Contoh: 2024-07-27 17:18:09',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                'err' => $validator->errors(),
            ], 422);
        } 
        //CHECK DATA ISBN
        $data = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT_ISBN pi LEFT JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id WHERE ISBN_NO='$isbn'"));
        if(!isset($data['Data']["Items"][0])){ //data isbn tidak ditemukan
            return response()->json([
                    'status' => 'Failed',
                    'message' => 'ISBN ' . $isbn . ' not found!',
            ], 500);
        } 
        $id = $data['Data']["Items"][0]['ID']; //penerbit_isbn 
        $id2 = $data['Data']["Items"][0]['ID1']; //penerbit_terbitan_id
        //UPDATE KE TABEL PENERBIT_ISBN
        $ListData = [
            ["name" => "RECEIVED_DATE_KCKR", "Value" => $request->input('datetime')]
        ];
        $res = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=PENERBIT_ISBN&issavehistory=1&id=$id&ListUpdateItem=" . urlencode(json_encode($ListData)));
        
        //INSERT HISTORY PENERBIT TERBITAN
        $history = [
            [ "name" => "TABLENAME", "Value"=> "PENERBIT_TERBITAN"],
            [ "name" => "IDREF", "Value"=> $id2],
            [ "name" => "ACTION" , "Value"=> "Edit"],
            [ "name" => "ACTIONDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
            [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
            [ "name" => "ACTIONBY", "Value"=> "deposit-api"],
            [ "name" => "NOTE", "Value"=> "Tandai diterima perpusnas <br/>ISBN : " . $isbn . "<br/>Tanggal penerimaan : " . $request->input('datetime')],
        ];
        $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
        return response()->json([
            'status' => 'Success',
            'message' => "Tandai diterima perpusnas <br/>ISBN : " . $isbn . "<br/>Tanggal penerimaan : " . $request->input('datetime'),
        ], 200);
    }

    function receivedProvinsi(Request $request)
    {
        $token = $request->input('token');
        $isbn = str_replace("-", "",$request->input('isbn'));
        $date = $request->input('datetime');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        $validator = \Validator::make($request->all(), [
            'datetime'  => 'required|date_format:Y-m-d H:i:s',
            'token'     => 'required',
            'isbn'      => 'required',  
        ], [
            'datetime.date_format' => 'Format tanggal dan waktu tidak sesuai. Format yang benar adalah Y-m-d H:i:s. Contoh: 2024-07-27 17:18:09'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal menyimpan data. Cek kembali data yang Anda masukan!',
                'err' => $validator->errors(),
            ], 422);
        } 
        //CHECK DATA ISBN
        $data = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT_ISBN pi LEFT JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id WHERE ISBN_NO='$isbn'"));
        if(!isset($data['Data']["Items"][0])){ //data isbn tidak ditemukan
            return response()->json([
                    'status' => 'Failed',
                    'message' => 'ISBN ' . $isbn . ' not found!',
            ], 500);
        } 
        $id = $data['Data']["Items"][0]['ID']; //penerbit_isbn 
        $id2 = $data['Data']["Items"][0]['ID1']; //penerbit_terbitan_id
        //UPDATE KE TABEL PENERBIT_ISBN
        $ListData = [
            ["name" => "RECEIVED_DATE_PROV", "Value" => $request->input('datetime')]
        ];
        $res = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=PENERBIT_ISBN&issavehistory=1&id=$id&ListUpdateItem=" . urlencode(json_encode($ListData)));
        
        //INSERT HISTORY PENERBIT TERBITAN
        $history = [
            [ "name" => "TABLENAME", "Value"=> "PENERBIT_TERBITAN"],
            [ "name" => "IDREF", "Value"=> $id2],
            [ "name" => "ACTION" , "Value"=> "Edit"],
            [ "name" => "ACTIONDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
            [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
            [ "name" => "ACTIONBY", "Value"=> "deposit-api"],
            [ "name" => "NOTE", "Value"=> "Tandai diterima provinsi <br/>ISBN : " . $isbn . "<br/>Tanggal penerimaan : " . $request->input('datetime')],
        ];
        $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
        return response()->json([
            'status' => 'Success',
            'message' => "Tandai diterima provinsi <br/>ISBN : " . $isbn . "<br/>Tanggal penerimaan : " . $request->input('datetime'),
        ], 200);
    }

    function getIsbn(Request $request)
    {
        $isbn = str_replace("-", "",$request->input('isbn'));
        $token = $request->input('token');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        $validator = \Validator::make($request->all(), [
            'token'     => 'required',
            'isbn'      => 'required',  
        ], [
            'isbn.required' => 'ISBN is required!'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal! Cek kembali data yang Anda masukan!',
                'err' => $validator->errors(),
            ], 422);
        } 
        
        $penerbit = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=getlistraw&sql=" . urlencode("SELECT * FROM PENERBIT_ISBN pi LEFT JOIN PENERBIT_TERBITAN pt ON pi.penerbit_terbitan_id = pt.id WHERE ISBN_NO='$isbn'"));

        if(isset($penerbit['Data']["Items"][0])){
            return response()->json([
                    'status' => 'Success',
                    'data' => $penerbit['Data']["Items"][0],
            ], 200);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'ISBN ' . $isbn . ' not found!',
            ], 500);
        }
    }

    function lockPenerbit(Request $request)
    {
        $id = $request->input('penerbit_id');
        $token = $request->input('token');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        $validator = \Validator::make($request->all(), [
            'token'     => 'required',
            'penerbit_id'      => 'required',  
        ], [
            'penerbit_id.required' => 'ID penerbit diperlukan!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal! Cek kembali data yang Anda masukan!',
                'err' => $validator->errors(),
            ], 422);
        } 
        
        $ListData = [
            ["name" => "IS_LOCK", "Value" => 1]
        ];
        $res = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=PENERBIT&issavehistory=1&id=$id&ListUpdateItem=" . urlencode(json_encode($ListData)));
        
        //INSERT HISTORY PENERBIT
        $history = [
            [ "name" => "TABLENAME", "Value"=> "PENERBIT"],
            [ "name" => "IDREF", "Value"=> $id],
            [ "name" => "ACTION" , "Value"=> "Edit"],
            [ "name" => "ACTIONDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
            [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
            [ "name" => "ACTIONBY", "Value"=> "deposit-api"],
            [ "name" => "NOTE", "Value"=> "Akun penerbit dikunci"],
        ];
        $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
        return response()->json([
            'status' => 'Success',
            'message' => "Akun penerbit dikunci : " . $id . "<br/>Tanggal kunci : " . now()->addHours(7)->format('Y-m-d H:i:s'),
        ], 200);
    }

    function unlockPenerbit(Request $request)
    {
        $id = $request->input('penerbit_id');
        $token = $request->input('token');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        $validator = \Validator::make($request->all(), [
            'token'     => 'required',
            'penerbit_id'      => 'required',  
        ], [
            'penerbit_id.required' => 'ID penerbit diperlukan!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Gagal! Cek kembali data yang Anda masukan!',
                'err' => $validator->errors(),
            ], 422);
        } 
        
        $ListData = [
            ["name" => "IS_LOCK", "Value" => 0]
        ];
        $res = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=update&table=PENERBIT&issavehistory=1&id=$id&ListUpdateItem=" . urlencode(json_encode($ListData)));
        
        //INSERT HISTORY PENERBIT
        $history = [
            [ "name" => "TABLENAME", "Value"=> "PENERBIT"],
            [ "name" => "IDREF", "Value"=> $id],
            [ "name" => "ACTION" , "Value"=> "Edit"],
            [ "name" => "ACTIONDATE", "Value"=> now()->addHours(7)->format('Y-m-d H:i:s') ],
            [ "name" => "ACTIONTERMINAL", "Value"=> \Request::ip()],
            [ "name" => "ACTIONBY", "Value"=> "deposit-api"],
            [ "name" => "NOTE", "Value"=> "Akun penerbit dibuka"],
        ];
        $res_his = Http::post(config('app.inlis_api_url') . "?token=" . config('app.inlis_api_token') . "&op=add&table=HISTORYDATA&ListAddItem=" . urlencode(json_encode($history)));
        return response()->json([
            'status' => 'Success',
            'message' => "Akun penerbit dibuka : " . $id . "<br/>Tanggal buka : " . now()->addHours(7)->format('Y-m-d H:i:s'),
        ], 200);
    }

    public function tagihanISBN(Request $request)
    {
        $token = $request->input('token');
        if($token != config('app.token_sso')){
            return response()->json([
                'status' => 'Failed',
                'message' => 'Token mismatch',
            ], 500);
        } 
        $page = $request->input('page') ? $request->input('page') : 1;
        $length = $request->input('length') ? $request->input('length') : 10;
        $start  = ($page - 1) * $length;
        $end = $start + $length;

        $sql = "SELECT pi.isbn_no, ir.mohon_date, ir.noresi, ir.jenis as jenis_permohonan, ir.source, pt.title, pt.jml_jilid, pt.jilid_volume, 
                pt.author, pt.kepeng, pt.sinopsis, pt.distributor, pt.tempat_terbit, pt.edisi, pt.seri, pt.bulan_terbit, pt.tahun_terbit,
                pt.jml_hlm, pt.ketebalan as dimensi, pt.subjek, pt.call_number, pi.keterangan_jilid,
                pt.jenis_media, pt.jenis_terbitan, pt.jenis_pustaka, pt.jenis_kategori, pt.jenis_kelompok, pt.jenis_penelitian,
                pt.is_kdt_valid, pi.RECEIVED_DATE_KCKR, pi.RECEIVED_DATE_PROV,pi.acceptdate, 
                PROPINSI.NAMAPROPINSI,  KABUPATEN.NAMAKAB as NAMAKABKOT,
                P.NAME, P.EMAIL1, P.EMAIL2, P.PROVINCE_ID, P.CITY_ID, P.DISTRICT_ID, P.VILLAGE_ID,
                P.ALAMAT, P.ID as PENERBIT_ID, P.TELP1, P.TELP2, P.NAMA_GEDUNG,
                P.KONTAK1, P.KONTAK2, P.WEBSITE, P.KODEPOS
                FROM penerbit_isbn pi
                JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                LEFT JOIN isbn_resi ir on ir.penerbit_terbitan_id = pt.id
                LEFT JOIN penerbit p on pt.penerbit_id = p.id 
                LEFT JOIN PROPINSI on propinsi.id = P.PROVINCE_ID
                LEFT JOIN KABUPATEN ON KABUPATEN.id = P.CITY_ID
                WHERE 1=1 ";
       
        $sqlFiltered = "SELECT pt.id FROM penerbit_isbn pi
                        JOIN penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
                        LEFT JOIN ISBN_RESI ir on ir.penerbit_terbitan_id = pt.id
                        WHERE 1 = 1 ";
        $sqlWhere = "";
        $query = [];
        if($request->input('provinsi')){
            $sqlWhere .= " AND UPPER(PROPINSI.NAMAPROPINSI) LIKE '%" . strtoupper($request->input('provinsi')) . "%')";
            array_push($query, [
                "field" => "provinsi",
                "value" => $request->input('provinsi')
            ]);
        }
        if($request->input('kabkot')){
            $sqlWhere .= " AND UPPER(KABUPATEN.NAMAKAB) LIKE '%" . strtoupper($request->input('kabkot')) . "%')";
            array_push($query, [
                "field" => "kabkot",
                "value" => $request->input('kabkot')
            ]);
        }

        if($request->input('title')){
            $sqlWhere .= " AND (CONCAT('WIN',(upper(pt.TITLE))) like 'WIN%".strtoupper($request->input('title'))."%')";
            array_push($query, [
                "field" => "title",
                "value" => $request->input('title')
            ]);
        }
        if($request->input('distributor')){
            $sqlWhere .= " AND (CONCAT('WIN',(upper(ir.distributor))) like 'WIN%".strtoupper($request->input('distributor'))."%')";
            array_push($query, [
                "field" => "noresi",
                "value" => $request->input('distributor')
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
            $sqlWhere .= " AND VALIDATE_DATE >= TO_DATE('".$request->input('date_start')."', 'yyyy-mm-dd')";
             array_push($query, [
                "field" => "date_start",
                "value" => $request->input('date_start')
            ]);
        }
        if($request->input('date_end')){
            $sqlWhere .= " AND VALIDATE_DATE <= TO_DATE('".$request->input('date_end')."', 'yyyy-mm-dd')";
            array_push($query, [
                "field" => "date_end",
                "value" => $request->input('date_end')
            ]);
        }
        if($request->input('status_kckr') !=''){
            switch($request->input('status_kckr')) {
                case "1-perpusnas": 
                    $sqlFiltered .= " AND pi.received_date_kckr is not null ";
                    $sql .= " AND pi.received_date_kckr is not null ";
                    break;
                case "0-perpusnas": 
                    $sqlFiltered .= " AND pi.received_date_kckr is  null ";
                    $sql .= " AND pi.received_date_kckr is  null ";
                    break;
                case "1-prov": 
                    $sqlFiltered .= " AND pi.received_date_prov is not null ";
                    $sql .= " AND pi.received_date_prov is not null ";
                    break;
                case "0-prov": 
                    $sqlFiltered .= " AND pi.received_date_prov is  null ";
                    $sql .= " AND pi.received_date_prov is  null ";
                    break;
            }
            array_push($query, [
                "field" => "status_kckr",
                "value" => $request->input('status_kckr')
            ]);
        }
        $data = kurl("get","getlistraw", "", "SELECT outer.* FROM (SELECT ROWNUM nomor, inner.* FROM ($sql $sqlWhere) inner WHERE rownum <=$end) outer WHERE nomor >$start", 'sql', '')["Data"]["Items"];  
        $totalData = kurl("get","getlistraw", "", "SELECT COUNT(*) JML FROM PENERBIT_ISBN ",'sql', '')["Data"]["Items"][0]["JML"];    
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
}
