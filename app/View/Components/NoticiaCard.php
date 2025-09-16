<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NoticiaCard extends Component
{
    public $imagen;
    public $fecha;
    public $titulo;
    public $url;

    public function __construct($imagen, $fecha, $titulo, $url)
    {
        $this->imagen = $imagen;
        $this->fecha = $fecha;
        $this->titulo = $titulo;
        $this->url = $url;
    }

    public function render()
    {
        return view('components.noticia-card');
    }
}
