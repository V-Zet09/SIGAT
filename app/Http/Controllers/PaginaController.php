<?php

namespace App\Http\Controllers;
use App\Models\Noticia;


use Illuminate\Http\Request;

class PaginaController extends Controller
{
    public function inicio()
{
    // Traemos todas las noticias, ordenadas de más reciente a más antigua
    $noticias = Noticia::latest()->get();

    // Pasamos las noticias a la vista 'inicio'
    return view('inicio', compact('noticias'));
}

    public function ayuntamiento()
    {
        return view('ayuntamiento'); 
    }

  
    public function sala()
    {
        return view('sala'); 
    }


    public function gobierno()
    {
        return view('gobierno');
    }
}
