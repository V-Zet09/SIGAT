<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Mostrar CRUD con todos los usuarios
    public function index()
    {
        $usuarios = User::all();
        return view('dashboard-users', compact('usuarios'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        return view('dashboard-crear-usuario');
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
        ]);
        $avatar = 'default.jpg'; // imagen por defecto en /public/images

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $avatar = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $avatar);
        }
        User::create([
            'name' => $request->name,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cargo' => $request->cargo,
            'area' => $request->area,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        return view('vista-ver-usuarios', compact('usuario'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sexo' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'cargo' => 'required|string',
            'area' => 'required|string',
        ]);

        $usuario = User::findOrFail($id);
        $usuario->update($request->all());

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado');
    }
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('vista-editar-usuario', compact('usuario'));
    }
    public function rolesSimple()
    {
        return view('roles-simple'); 
    }
}
