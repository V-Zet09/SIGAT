<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // ✅ IMPORTAR

class UserController extends Controller
{
    // Mostrar CRUD con todos los usuarios
    public function index(Request $request)
    {
        $query = $request->input('search');

        $usuarios = User::query()
            ->when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%")
              ->orWhere('cargo', 'like', "%{$query}%")
              ->orWhere('area', 'like', "%{$query}%");
             })
            ->with('roles')
            ->get();
        return view('dashboard-users', compact('usuarios'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        $roles = Role::all(); // ✅ Pasar roles a la vista
        return view('dashboard-crear-usuario', compact('roles'));
    }

    // Guardar usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sexo' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'cargo' => 'required|string',
            'area' => 'required|string',
            'rol' => 'required|exists:roles,name', // ✅ Validar rol
        ]);

        $avatar = 'default.jpg';

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $avatar = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $avatar);
        }

        $user = User::create([
            'name' => $request->name,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cargo' => $request->cargo,
            'area' => $request->area,
            'avatar' => $avatar,
        ]);

        $user->assignRole($request->rol); // ✅ Asignar rol

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        $usuario = User::with('roles', 'permissions')->findOrFail($id); // ✅ Cargar roles
        return view('vista-ver-usuarios', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = User::with('roles')->findOrFail($id); // ✅ Cargar roles
        $roles = Role::all(); // ✅ Pasar todos los roles
        return view('vista-editar-usuario', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sexo' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'cargo' => 'required|string',
            'area' => 'required|string',
            'rol' => 'required|exists:roles,name', // ✅ Validar rol
        ]);

        $usuario = User::findOrFail($id);
        
        // Actualizar datos básicos
        $usuario->update([
            'name' => $request->name,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'cargo' => $request->cargo,
            'area' => $request->area,
        ]);
        
        // ✅ Actualizar rol
        $usuario->syncRoles([$request->rol]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        if ($id == auth()->id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta');
        }

        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente');
    }

    // Gestión de roles
    public function roles()
    {
        $roles = Role::with('permissions')->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('roles', compact('roles', 'permissions'));
    }

    public function guardarPermisos(Request $request, $rolId)
    {
        $request->validate([
            'permisos' => 'required|array',
            'permisos.*' => 'exists:permissions,id'
        ]);

        $rol = Role::findOrFail($rolId);
        $permisos = \Spatie\Permission\Models\Permission::whereIn('id', $request->permisos)->pluck('name');
        
        $rol->syncPermissions($permisos);

        return response()->json(['success' => true]);
    }
}
