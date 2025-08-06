<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresidenteMunicipalController extends Controller
{
    public function index()
    {
        return view('dashboard-presidente-municipal');
    }
}
