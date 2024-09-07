<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    function getDetail()
    {
        $id = session('penerbit')['ID'];
        $data = kurl("get","getlistraw", "", "SELECT * FROM PENERBIT WHERE ID=$id", 'sql', '');
        return $data;
    }

    function index()
    {
        return view('profile');
    }
}
