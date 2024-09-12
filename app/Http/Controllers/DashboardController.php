<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"],
        ];
        return view('dashboard', $data);
    }
    public function notValid()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"],
        ];
        return view('perlu_verifikasi', $data);
    }

    public function getTotalIsbn()
    {
        $status = request('status'); 
        $id = session('penerbit')['ID'];
        if($status == 'permohonan'){
            $sql = "SELECT count(*) JUMLAH FROM PENERBIT_TERBITAN pt  WHERE pt.PENERBIT_ID='$id' AND (pt.status='' OR pt.status='permohonan' OR pt.status is NULL) ";
        } 
        if($status == 'pending') {
            $sql = "SELECT count(*) JUMLAH
                FROM PENERBIT_ISBN_MASALAH m JOIN PENERBIT_TERBITAN pt
                ON m.PENERBIT_TERBITAN_ID = pt.ID 
                WHERE m.IS_SOLVE = 0 AND pt.PENERBIT_ID='$id' AND pt.status='pending'";
        }
        if($status == 'diterima'){
            $sql  = "SELECT count(*) JUMLAH FROM PENERBIT_ISBN pi 
                    JOIN PENERBIT_TERBITAN pt ON pt.ID = pi.PENERBIT_TERBITAN_ID WHERE pi.PENERBIT_ID='$id'";
        }
        
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        return $data;
    }

    public function getYear()
    {
        $id = session('penerbit')['ID'];   
        $sql = "SELECT to_char(VALIDATION_DATE, 'YYYY') year
                    FROM PENERBIT_TERBITAN 
                    WHERE PENERBIT_ID = '$id'
                    GROUP BY to_char(VALIDATION_DATE, 'YYYY')
                    ORDER BY to_char(VALIDATION_DATE, 'YYYY')";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
        return $data;
    }

    public function getStatistikIsbn()
    {
        $year = request('year');   
        $id = session('penerbit')['ID'];  
        $sql = "SELECT count(*) jumlah, to_char(VALIDATION_DATE, 'MON') month, to_char(VALIDATION_DATE, 'MM') month_numb
                    FROM PENERBIT_TERBITAN 
                    WHERE PENERBIT_ID = '$id'
                    AND VALIDATION_DATE BETWEEN TO_DATE('01-01-$year','dd-mm-yyyy') AND TO_DATE('31-12-$year','dd-mm-yyyy')
                    GROUP BY to_char(VALIDATION_DATE, 'MON'), to_char(VALIDATION_DATE, 'MM')
                    ORDER BY to_char(VALIDATION_DATE, 'MM')";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
        return $data;
    }

    public function getBerita()
    {   
        $sql = "SELECT * FROM ISBN_MST_BERITA WHERE ROWNUM <= 5 ORDER BY TANGGAL DESC";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
        return $data;
    }

    public function getKckrPerpusnas()
    {
        $year = request('year');   
        $id = session('penerbit')['ID'];  
        $sql = "SELECT count(*) jumlah FROM PENERBIT_ISBN
                    WHERE PENERBIT_ID = '$id' AND RECEIVED_DATE_KCKR IS NOT NULL ";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        return $data;
    }

    public function getKckrProvinsi()
    {
        $year = request('year');   
        $id = session('penerbit')['ID'];  
        $sql = "SELECT count(*) jumlah FROM PENERBIT_ISBN
                    WHERE PENERBIT_ID = '$id' AND RECEIVED_DATE_PROV IS NOT NULL ";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        return $data;
    }
    
}
