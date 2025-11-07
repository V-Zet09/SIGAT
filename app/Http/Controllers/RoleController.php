<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Mostrar la vista de gestión de roles
     */
    public function index()
{
    $roles = Role::with('permissions')->get();
    $permissions = Permission::all();
    
    return view('roles', compact('roles', 'permissions')); 
}

    /**
     * Actualizar permisos de un rol
     */
    public function updatePermissions(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->syncPermissions($request->permisos ?? []);
            
            return response()->json([
                'success' => true,
                'message' => 'Permisos actualizados correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}