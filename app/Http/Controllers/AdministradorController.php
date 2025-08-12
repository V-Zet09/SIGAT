<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function index()
    {
       return view('dashboard-administrador');// Asegúrate de que esta vista exista
    }
}
