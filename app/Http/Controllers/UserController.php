<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\AuditLog; // ← AGREGADO

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
        $roles = Role::all();
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
            'rol' => 'required|exists:roles,name',
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

        $user->assignRole($request->rol);

        // ✅ REGISTRAR LOG DE CREACIÓN DE USUARIO (el Auditable trait ya lo hace, pero agregamos info del rol)
        AuditLog::log(
            action: 'crear',
            description: "Creó el usuario: {$request->name} - Cargo: {$request->cargo} - Rol: {$request->rol}",
            modelType: 'App\Models\User',
            modelId: $user->id,
            newValues: [
                'cargo' => $request->cargo,
                'area' => $request->area,
                'rol' => $request->rol
            ]
        );

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        $usuario = User::with('roles', 'permissions')->findOrFail($id);
        
        // ✅ REGISTRAR LOG DE VISUALIZACIÓN DE USUARIO
        AuditLog::log(
            action: 'ver',
            description: "Visualizó el perfil del usuario: {$usuario->name}",
            modelType: 'App\Models\User',
            modelId: $usuario->id
        );
        
        return view('vista-ver-usuarios', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = User::with('roles')->findOrFail($id);
        $roles = Role::all();
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
            'rol' => 'required|exists:roles,name',
        ]);

        $usuario = User::findOrFail($id);
        
        // ✅ Guardar valores anteriores para el log
        $cambios = [];
        if ($usuario->name !== $request->name) {
            $cambios[] = "nombre: {$usuario->name} → {$request->name}";
        }
        if ($usuario->email !== $request->email) {
            $cambios[] = "email: {$usuario->email} → {$request->email}";
        }
        if ($usuario->cargo !== $request->cargo) {
            $cambios[] = "cargo: {$usuario->cargo} → {$request->cargo}";
        }
        if ($usuario->area !== $request->area) {
            $cambios[] = "área: {$usuario->area} → {$request->area}";
        }
        
        // Verificar si cambió el rol
        $rolActual = $usuario->roles->first()?->name;
        if ($rolActual !== $request->rol) {
            $cambios[] = "rol: {$rolActual} → {$request->rol}";
        }
        
        // Actualizar datos básicos
        $usuario->update([
            'name' => $request->name,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'cargo' => $request->cargo,
            'area' => $request->area,
        ]);
        
        // Actualizar rol
        $usuario->syncRoles([$request->rol]);

        // ✅ REGISTRAR LOG DE EDICIÓN (el Auditable trait registra cambios generales, agregamos detalles)
        if (!empty($cambios)) {
            AuditLog::log(
                action: 'editar',
                description: "Editó el usuario: {$usuario->name} - Cambios: " . implode(', ', $cambios),
                modelType: 'App\Models\User',
                modelId: $usuario->id,
                newValues: ['cambios' => $cambios]
            );
        }

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
        $nombreUsuario = $usuario->name;
        $cargoUsuario = $usuario->cargo;
        
        $usuario->delete();

        // ✅ LOG DE ELIMINACIÓN (se hace automáticamente con Auditable trait)
        // Pero podemos agregar un log adicional con más contexto
        AuditLog::log(
            action: 'eliminar',
            description: "Eliminó el usuario: {$nombreUsuario} - Cargo: {$cargoUsuario}",
            modelType: 'App\Models\User',
            modelId: $id,
            oldValues: [
                'nombre' => $nombreUsuario,
                'cargo' => $cargoUsuario
            ]
        );

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
        
        // ✅ Guardar permisos anteriores para el log
        $permisosAnteriores = $rol->permissions->pluck('name')->toArray();
        
        $rol->syncPermissions($permisos);

        // ✅ REGISTRAR LOG DE CAMBIO DE PERMISOS
        AuditLog::log(
            action: 'editar',
            description: "Actualizó permisos del rol: {$rol->name}",
            modelType: 'Spatie\Permission\Models\Role',
            modelId: $rol->id,
            oldValues: ['permisos' => $permisosAnteriores],
            newValues: ['permisos' => $permisos->toArray()]
        );

        return response()->json(['success' => true]);
    }
}
