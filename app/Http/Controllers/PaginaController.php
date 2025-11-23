<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginaController extends Controller
{
    public function inicio()
    {
        return view('inicio');
    }

    public function ayuntamiento()
    {
        return view('ayuntamiento'); 
    }

    public function sala()
    {
        return view('sala-de-prensa'); 
    }

    public function gobierno()
    {
        return view('gobierno');
    }
}
