<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'nama_penerbit' => $this->penerbit["NAME"]
        ];
        return view('dashboard', $data);
    }

    public function getTotalIsbn()
    {
        $status = request('status'); 
        $id = $this->penerbit['ID'];
        $data = Http::get(config('app.inlis_api_url'), [
            "token" => config('app.inlis_api_token'),
            "op" => "getlistraw",
            "sql" => "SELECT count(*) JUMLAH FROM PENERBIT_ISBN pi JOIN PENERBIT_TERBITAN pt ON pt.id = pi.penerbit_terbitan_id WHERE pi.PENERBIT_ID='$id' AND pt.status='$status'"
        ])->json()["Data"]["Items"][0]["JUMLAH"];
        return $data;
    }

    public function getStatistikIsbn()
    {
        $year = request('year');   
        $id = $this->penerbit['ID'];    
        $data = Http::get(config('app.inlis_api_url'), [
            "token" => config('app.inlis_api_token'),
            "op" => "getlistraw",
            "sql" => "SELECT count(*) jumlah, to_char(VALIDATION_DATE, 'MON') month, to_char(VALIDATION_DATE, 'MM') month_numb
                    FROM PENERBIT_TERBITAN 
                    WHERE PENERBIT_ID = '$id'
                    AND VALIDATION_DATE BETWEEN TO_DATE('01-01-$year','dd-mm-yyyy') AND TO_DATE('31-12-$year','dd-mm-yyyy')
                    GROUP BY to_char(VALIDATION_DATE, 'MON'), to_char(VALIDATION_DATE, 'MM')
                    ORDER BY to_char(VALIDATION_DATE, 'MM')"
        ])->json()["Data"]["Items"];
        return $data;
    }

    public function getBerita()
    {   
        $data = Http::get(config('app.inlis_api_url'), [
            "token" => config('app.inlis_api_token'),
            "op" => "getlistraw",
            "sql" => "SELECT * FROM ISBN_MST_BERITA WHERE ROWNUM <= 5 ORDER BY TANGGAL DESC"
        ])->json()["Data"]["Items"];
        return $data;
    }
    
}
