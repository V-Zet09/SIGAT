<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class OrganigramaController extends Controller
{
    public function index()
    {
        // Obtener el presidente (jerarquía 1)
        $presidente = Cargo::where('jerarquia', 1)
                          ->where('orden_visual', 1)
                          ->with('subordinados')
                          ->first();

        return view('ayuntamiento', compact('presidente'));
    }

    public function actualizar(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'puesto' => 'required|string|max:255',
            'departamento' => 'nullable|string|max:255',
        ]);

        $cargo->update($validated);

        return redirect()->route('ayuntamiento')
                        ->with('success', 'Cargo actualizado exitosamente');
    }

    public function eliminar($id)
    {
        $cargo = Cargo::findOrFail($id);
        
        // Marcar como inactivo en lugar de eliminar
        $cargo->update([
            'nombre' => null,
            'puesto' => null,
            'departamento' => null,
        ]);

        return redirect()->route('ayuntamiento')
                        ->with('success', 'Cargo eliminado. La posición quedó disponible.');
    }
}
