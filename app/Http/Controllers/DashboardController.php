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
            $sql = "SELECT count(*) JUMLAH FROM ISBN_RESI IR 
                    WHERE PENERBIT_ID='$id' AND (status='' OR status='permohonan' OR status is NULL OR status='lanjutan') ";
        } 
        if($status == 'pending') {
            $sql = "SELECT count(*) JUMLAH
                FROM PENERBIT_ISBN_MASALAH m LEFT JOIN ISBN_RESI ir on ir.id = m.isbn_resi_id
                WHERE m.IS_SOLVE = 0 AND ir.PENERBIT_ID='$id' AND ir.status='pending'";
        }
        if($status == 'diterima'){
            $sql  = "SELECT count(*) JUMLAH FROM PENERBIT_ISBN pi 
                    WHERE pi.PENERBIT_ID='$id'";
        }
        if($status == 'batal') {
            $sql = "SELECT count(*) JUMLAH FROM ISBN_RESI IR 
                    WHERE PENERBIT_ID='$id' AND status='batal' ";
        }
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0]["JUMLAH"];
        return $data;
    }

    public function getYear()
    {
        $id = session('penerbit')['ID'];   
        /*$sql = "SELECT to_char(VALIDATION_DATE, 'YYYY') year
                    FROM PENERBIT_TERBITAN 
                    WHERE PENERBIT_ID = '$id'
                    GROUP BY to_char(VALIDATION_DATE, 'YYYY')
                    ORDER BY to_char(VALIDATION_DATE, 'YYYY')";*/
        $sql = "SELECT to_char(ACCEPTDATE, 'YYYY') year
                    FROM PENERBIT_ISBN 
                    WHERE PENERBIT_ID = '$id'
                    GROUP BY to_char(ACCEPTDATE, 'YYYY')
                    ORDER BY to_char(ACCEPTDATE, 'YYYY')";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
        return $data;
    }

    public function getStatistikIsbn()
    {
        $year = request('year');   
        $id = session('penerbit')['ID'];  
        $sql = "SELECT count(*) jumlah, to_char(ACCEPTDATE, 'MON') month, to_char(ACCEPTDATE, 'MM') month_numb
                    FROM PENERBIT_ISBN
                    WHERE PENERBIT_ID = '$id'
                    AND ACCEPTDATE BETWEEN TO_DATE('01-01-$year','dd-mm-yyyy') AND TO_DATE('31-12-$year','dd-mm-yyyy')
                    GROUP BY to_char(ACCEPTDATE, 'MON'), to_char(ACCEPTDATE, 'MM')
                    ORDER BY to_char(ACCEPTDATE, 'MM')";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"];
        return $data;
    }

    public function getBerita()
    {   
        $sql = "SELECT * FROM ISBN_MST_BERITA WHERE ROWNUM <= 10 ORDER BY TANGGAL DESC";
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

        $sql_total = "SELECT count(*) jumlah FROM PENERBIT_ISBN
                    WHERE PENERBIT_ID = '$id' ";
        $data_total = kurl("get","getlistraw", "", $sql_total, 'sql', '')["Data"]["Items"][0]["JUMLAH"];

        $kepatuhan = number_format(intval($data) / intval($data_total) * 100, 2, '.', '')  ; 

        return [$data, $kepatuhan];
    }

    public function getKckrProvinsi()
    {
        $year = request('year');   
        $id = session('penerbit')['ID'];  
        $sql = "SELECT count(*) jumlah FROM PENERBIT_ISBN
                    WHERE PENERBIT_ID = '$id' AND RECEIVED_DATE_PROV IS NOT NULL ";
        $data = kurl("get","getlistraw", "", $sql, 'sql', '')["Data"]["Items"][0]["JUMLAH"];

        $sql_total = "SELECT count(*) jumlah FROM PENERBIT_ISBN
                    WHERE PENERBIT_ID = '$id' ";
        $data_total = kurl("get","getlistraw", "", $sql_total, 'sql', '')["Data"]["Items"][0]["JUMLAH"];

        $kepatuhan = number_format(intval($data) / intval($data_total) * 100, 2, '.', '')  ; 
        return [$data, $kepatuhan];
    }
    
}
