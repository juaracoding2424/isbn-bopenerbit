<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

abstract class Controller
{
    protected $penerbit;

    public function __construct()
    {
        //$penerbit_id = '2162396';
        $penerbit_id = '2159312'; //masalahnya banyak
        //$penerbit_id = '2167260'; //jilidnya banyak
        $this->penerbit = Http::get(config('app.inlis_api_url'), [
            "token" => config('app.inlis_api_token'),
            "op" => "getlistraw",
            "sql" => "SELECT * FROM PENERBIT WHERE ID='$penerbit_id'"
        ])->json()["Data"]["Items"][0];
    }
}
