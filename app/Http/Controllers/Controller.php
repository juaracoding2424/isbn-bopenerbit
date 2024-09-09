<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

abstract class Controller
{
   function __construct()
   {
        if(session('penerbit') !== null && session('penerbit')['STATUS'] == 'valid') {
            return redirect('penerbit/dashboard/notvalid');
        } 
   }
}
