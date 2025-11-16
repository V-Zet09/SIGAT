<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CarruselFoto;


class CarruselController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'titulo' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',
        'orden' => 'nullable|integer'
    ]);

    if ($request->hasFile('imagen')) {
        $path = $request->file('imagen')->store('carrusel', 'public');
        
        CarruselFoto::create([
            'imagen' => basename($path),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden ?? 0
        ]);
    }

    return redirect()->back()->with('success', 'Foto agregada al carrusel');
}

public function destroy($id)
{
    $foto = CarruselFoto::findOrFail($id);
    Storage::disk('public')->delete('carrusel/' . $foto->imagen);
    $foto->delete();

    return redirect()->back()->with('success', 'Foto eliminada');
}
}
