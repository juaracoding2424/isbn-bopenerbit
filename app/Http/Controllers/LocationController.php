<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    function getProvince()
    {
        $data = kurl("get","getlistraw", "", "SELECT ID, NAMAPROPINSI NAME FROM PROPINSI", 'sql', '')["Data"]["Items"];
        $arr = [];
        foreach($data as $d){
            array_push($arr, [
                'id' => $d['ID'],
                'nama' => $d['NAME'],
                'text'=>$d['NAME']
            ]);
        }
        return $arr;
    }

    function getKabupaten($id)
    {
        $data = kurl("get","getlistraw", "", "SELECT ID, NAMAKAB NAME  FROM KABUPATEN WHERE PROPINSIID=$id", 'sql', '')["Data"]["Items"];
        $arr = [];
        foreach($data as $d){
            array_push($arr, [
                'id' => $d['ID'],
                'nama' => $d['NAME'],
                'text'=>$d['NAME']
            ]);
        }
        return $arr;
    }

    function getKecamatan($id)
    {
        $data = kurl("get","getlistraw", "", "SELECT ID, NAMAKEC NAME FROM KECAMATAN WHERE KABUPATENID=$id", 'sql', '')["Data"]["Items"];
        $arr = [];
        $arr = [];
        foreach($data as $d){
            array_push($arr, [
                'id' => $d['ID'],
                'nama' => $d['NAME'],
                'text'=>$d['NAME']
            ]);
        }
        return $arr;
    }

    function getKelurahan($id)
    {
        $data = kurl("get","getlistraw", "", "SELECT ID, NAMAKEL NAME FROM KELURAHAN WHERE KECAMATANID=$id", 'sql', '')["Data"]["Items"];
        $arr = [];
        $arr = [];
        foreach($data as $d){
            array_push($arr, [
                'id' => $d['ID'],
                'nama' => $d['NAME'],
                'text'=>$d['NAME']
            ]);
        }
        return $arr;
    }
}
