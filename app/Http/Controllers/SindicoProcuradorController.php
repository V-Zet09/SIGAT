<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SindicoProcuradorController extends Controller
{
    public function index()
    {
        return view('dashboard-sindico-procurador');
    }
}
