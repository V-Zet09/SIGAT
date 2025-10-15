<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presidente;
use Illuminate\Support\Facades\Storage;

class PresidenteController extends Controller
{
    public function actualizar(Request $request)
    {
        $presidente = Presidente::first();
        
        $presidente->nombre = $request->nombre;
        $presidente->cargo = $request->cargo;
        $presidente->biografia = $request->biografia;
        
        // Si subió una foto nueva
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreFoto = time() . '_' . $foto->getClientOriginalName();
            
            // Guardar en storage/app/public/presidentes
            $ruta = $foto->storeAs('presidentes', $nombreFoto, 'public');
            
            $presidente->foto = $nombreFoto;
        }
        
        $presidente->save();
        
        return redirect()->back()->with('success', '✅ Información actualizada correctamente');
    }
}