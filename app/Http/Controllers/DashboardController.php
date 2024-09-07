<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => session('penerbit')["NAME"]
        ];
        return view('dashboard', $data);
    }

    public function getTotalIsbn()
    {
        $status = request('status'); 
        if($status == 'permohonan'){
            $status = "AND (pt.status='' OR pt.status='permohonan' OR pt.status is NULL)";
        } else {
            $status = "AND pt.status='$status'";
        }
        $id = session('penerbit')['ID'];
        $sql = "SELECT count(*) JUMLAH FROM PENERBIT_ISBN pi JOIN PENERBIT_TERBITAN pt ON pt.id = pi.penerbit_terbitan_id WHERE pi.PENERBIT_ID='$id' " . $status;
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
    
}
