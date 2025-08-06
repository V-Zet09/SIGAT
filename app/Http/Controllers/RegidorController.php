<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegidorController extends Controller
{
    public function index()
    {
        return view('dashboard-regidor');
    }
}
