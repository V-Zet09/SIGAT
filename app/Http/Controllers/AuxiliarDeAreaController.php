<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuxiliarDeAreaController extends Controller
{
    public function index()
    {
        return view('dashboard-auxiliar-area');
    }
}
