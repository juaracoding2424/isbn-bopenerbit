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
                        PROPINSI.NAMAPROPINSI, KABUPATEN.NAMAKAB, KABUPATEN.CODE_SORT CODEKAB, FROM ISBN_REGISTRASI_PENERBIT IR 
                        JOIN PROPINSI on propinsi.id = IR.PROVINCE_ID
                        JOIN KABUPATEN ON KABUPATEN.id = IR.CITY_ID
                        WHERE IR.ID=$id";
            $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0];
        }
        return $data;
    }

    function index()
    {
        return view('profile');
    }
}
