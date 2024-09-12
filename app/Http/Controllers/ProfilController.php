<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    function getDetail()
    {
        $id = session('penerbit')['ID'];
        if(session('penerbit')['STATUS'] == 'valid') {
            $sql = "SELECT 'VALID' STATUS, PROPINSI.NAMAPROPINSI,  KABUPATEN.NAMAKAB, KABUPATEN.CODE_SORT CODEKAB,
                        P.NAME NAMA_PENERBIT, P.EMAIL1 ADMIN_EMAIL, P.EMAIL2 ALTERNATE_EMAIL, P.PROVINCE_ID, P.CITY_ID, P.DISTRICT_ID, P.VILLAGE_ID,
                        P.ALAMAT ALAMAT_PENERBIT, P.ID, P.TELP1 ADMIN_PHONE, P.TELP2 ALTERNATE_PHONE, P.NAMA_GEDUNG, P.ISBN_USER_NAME USER_NAME
              FROM PENERBIT P 
                        JOIN PROPINSI on propinsi.id = P.PROVINCE_ID
                        JOIN KABUPATEN ON KABUPATEN.id = P.CITY_ID
                        WHERE P.ID=$id";
            $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0];
        } else {
            $sql = "SELECT 'NOTVALID' STATUS, IR.*,
                        PROPINSI.NAMAPROPINSI, KABUPATEN.NAMAKAB FROM ISBN_REGISTRASI_PENERBIT IR 
                        JOIN PROPINSI on propinsi.id = IR.PROVINCE_ID
                        JOIN KABUPATEN ON KABUPATEN.id = IR.CITY_ID
                        WHERE IR.ID=$id";
            $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0];
        }
        return $data;
    }

    function submit()
    {
        $penerbit = session('penerbit');
        
        $validator = \Validator::make(request()->all(),[
            'name' => 'required',
            'username' => 'required|min:6',
            'phone' => 'required|number',
            'alamat_penerbit' => 'required',
            'nama_gedung' => 'required',
            'provinsi' => 'required',
            'kabkot' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            ],[
            'name.required' => 'Anda belum mengisi nama penerbit',
            'username.required' => 'Anda belum mengisi username',
            'username.min' => 'Username minimal terdiri dari 6 karakter',
            'phone.required' => 'Anda belum mengisi nomor telp/hp kantor yang bisa dihubungi',
            'alamat_penerbit.required' => 'Anda belum mengisi alamat kantor',
            'nama_gedung.required' => 'Anda belum mengisi jenis terbitan buku',
            'provinsi.required' => 'Anda belum mengisi provinsi tempat domisili kantor',
            'kabkot.required' => 'Anda belum mengisi kota/kabupaten tempat domisili kantor',
            'kecamatan.required' => 'Anda belum mengisi kecamatan tempat domisili kantor',
            'kelurahan.required' => 'Anda belum mengisi kelurahan tempat domisili kantor',
        ]);
        if(session('penerbit')['STATUS'] == 'VALID'){
            $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=PENERBIT&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));
        } else {
            $res =  Http::post(config('app.inlis_api_url') ."?token=" . config('app.inlis_api_token')."&op=update&table=ISBN_REGISTRASI_PENERBIT&id=$id&issavehistory=1&ListUpdateItem=" . urlencode(json_encode($ListData)));
        }
    }

    function index()
    {
        return view('profile');
    }
}
