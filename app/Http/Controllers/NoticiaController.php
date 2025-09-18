<?php

namespace App\Http\Controllers;

use App\Models\Noticia;

class NoticiaController extends Controller
{
    public function show($id)
    {
        // Busca la noticia por id o falla si no existe
        $noticia = Noticia::findOrFail($id);

        // Retorna la vista con la noticia
        return view('noticias.show', compact('noticia'));
    }
  public function index()
{
    // Obtener la noticia más reciente como principal
    $noticiaPrincipal = Noticia::latest('fecha')->first(); 
    // 'fecha' es la columna que contiene la fecha de creación de la noticia

    // Obtener las demás noticias sin incluir la principal
    $noticiasSecundarias = Noticia::where('id', '!=', $noticiaPrincipal->id)
                                  ->latest('fecha')
                                  ->take(3)
                                  ->get();

    // Retornar la vista con ambas colecciones
    return view('inicio', compact('noticiaPrincipal', 'noticiasSecundarias'));
}
public function todos()
{
    // Obtener todas las noticias, ordenadas de la más reciente a la más antigua
    $noticias = Noticia::latest()->paginate(10); // 10 noticias por página

    // Retornar la vista con las noticias
    return view('noticias.todos', compact('noticias'));
}



}
