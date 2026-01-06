<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\AuditLog;
use App\Helpers\NotificationHelper; // ✅ Importar el Helper

class UserController extends Controller
{
    // Mostrar CRUD con todos los usuarios
    public function index(Request $request)
    {
        $query  = $request->input('search');
        $estado = $request->input('estado'); // 'conectado' | 'desconectado' | null

        $usuarios = User::query()
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name',  'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->orWhere('cargo', 'like', "%{$query}%")
                        ->orWhere('area',  'like', "%{$query}%");
                });
            })
            ->when($estado === 'conectado', function ($q) {
                $q->where('last_activity_at', '>=', now()->subMinutes(5));
            })
            ->when($estado === 'desconectado', function ($q) {
                $q->where(function($sub) {
                    $sub->whereNull('last_activity_at')
                        ->orWhere('last_activity_at', '<', now()->subMinutes(5));
                });
            })
            ->with('roles')
            ->paginate(15);

        $totalUsuarios   = User::count();
        $usuariosActivos = User::where('last_activity_at', '>=', now()->subMinutes(5))->count();

        return view('dashboard-users', compact(
            'usuarios',
            'query',
            'estado',
            'totalUsuarios',
            'usuariosActivos'
        ));
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
            'name'     => 'required|string|max:255',
            'sexo'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'cargo'    => 'required|string',
            'area'     => 'required|string',
            'rol'      => 'required|exists:roles,name',
        ]);

        $avatar = 'default.jpg';

        if ($request->hasFile('avatar')) {
            $file   = $request->file('avatar');
            $avatar = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('storage/avatars'), $avatar);
        }

        $user = User::create([
            'name'     => $request->name,
            'sexo'     => $request->sexo,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'cargo'    => $request->cargo,
            'area'     => $request->area,
            'avatar'   => $avatar,
        ]);

        $user->assignRole($request->rol);

        AuditLog::log(
            action: 'crear',
            description: "Creó el usuario: {$request->name} - Cargo: {$request->cargo} - Rol: {$request->rol}",
            modelType: 'App\Models\User',
            modelId: $user->id,
            newValues: [
                'cargo' => $request->cargo,
                'area'  => $request->area,
                'rol'   => $request->rol,
            ]
        );

        // 🔔 NOTIFICAR AL ADMINISTRADOR (CREACIÓN)
        NotificationHelper::sendToRole(
            'Administrador',
            'usuario',
            'Nuevo usuario creado',
            auth()->user()->name . ' ha creado al usuario: ' . $user->name,
            [
                'icon'  => 'ri-user-add-line',
                'color' => 'green',
                'link'  => route('usuarios.show', $user->id)
            ]
        );

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        $usuario = User::with('roles', 'permissions')->findOrFail($id);

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
        $roles   = Role::all();

        return view('vista-editar-usuario', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'sexo'  => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'cargo' => 'required|string',
            'area'  => 'required|string',
            'rol'   => 'required|exists:roles,name',
        ]);

        $usuario = User::with('roles')->findOrFail($id);

        $cambios = [];

        if ($usuario->name !== $request->name) $cambios[] = "nombre";
        if ($usuario->email !== $request->email) $cambios[] = "email";
        if ($usuario->cargo !== $request->cargo) $cambios[] = "cargo";
        if ($usuario->area !== $request->area) $cambios[] = "área";

        $rolActual = $usuario->roles->first()?->name;
        if ($rolActual !== $request->rol) {
            $cambios[] = "rol ({$rolActual} → {$request->rol})";
        }

        $usuario->update([
            'name'  => $request->name,
            'sexo'  => $request->sexo,
            'email' => $request->email,
            'cargo' => $request->cargo,
            'area'  => $request->area,
        ]);

        $usuario->syncRoles([$request->rol]);

        if (! empty($cambios)) {
            AuditLog::log(
                action: 'editar',
                description: "Editó el usuario: {$usuario->name}",
                modelType: 'App\Models\User',
                modelId: $usuario->id,
                newValues: ['cambios' => $cambios]
            );

            // 🔔 NOTIFICAR AL ADMINISTRADOR (EDICIÓN)
            NotificationHelper::sendToRole(
                'Administrador',
                'usuario',
                'Usuario modificado',
                auth()->user()->name . ' ha editado al usuario: ' . $usuario->name,
                [
                    'icon'  => 'ri-user-settings-line',
                    'color' => 'orange',
                    'link'  => route('usuarios.show', $usuario->id)
                ]
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

        $usuario       = User::findOrFail($id);
        $nombreUsuario = $usuario->name;
        $cargoUsuario  = $usuario->cargo;

        $usuario->delete();

        AuditLog::log(
            action: 'eliminar',
            description: "Eliminó el usuario: {$nombreUsuario} - Cargo: {$cargoUsuario}",
            modelType: 'App\Models\User',
            modelId: $id,
            oldValues: [
                'nombre' => $nombreUsuario,
                'cargo'  => $cargoUsuario,
            ]
        );

        // 🔔 NOTIFICAR AL ADMINISTRADOR (ELIMINACIÓN)
        NotificationHelper::sendToRole(
            'Administrador',
            'usuario',
            'Usuario eliminado',
            auth()->user()->name . ' eliminó al usuario: ' . $nombreUsuario,
            [
                'icon'  => 'ri-user-unfollow-line',
                'color' => 'red',
                'link'  => null // No hay link porque el usuario ya no existe
            ]
        );

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente');
    }

    // Gestión de roles
    public function roles()
    {
        $roles       = Role::with('permissions')->get();
        $permissions = \Spatie\Permission\Models\Permission::all();

        return view('roles', compact('roles', 'permissions'));
    }

    public function guardarPermisos(Request $request, $rolId)
    {
        $request->validate([
            'permisos'   => 'required|array',
            'permisos.*' => 'exists:permissions,id',
        ]);

        $rol      = Role::findOrFail($rolId);
        $permisos = \Spatie\Permission\Models\Permission::whereIn('id', $request->permisos)->pluck('name');
        $permisosAnteriores = $rol->permissions->pluck('name')->toArray();

        $rol->syncPermissions($permisos);

        AuditLog::log(
            action: 'editar',
            description: "Actualizó permisos del rol: {$rol->name}",
            modelType: 'Spatie\Permission\Models\Role',
            modelId: $rol->id,
            oldValues: ['permisos' => $permisosAnteriores],
            newValues: ['permisos' => $permisos->toArray()]
        );

        // 🔔 OPCIONAL: Notificar cambio de permisos
        /*
        NotificationHelper::sendToRole(
            'Administrador',
            'sistema',
            'Permisos actualizados',
            'Se actualizaron los permisos del rol: ' . $rol->name
        );
        */

        return response()->json(['success' => true]);
    }
}
