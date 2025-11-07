<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Mostrar perfil
    public function index()
    {
        $user = Auth::user()->load('roles', 'permissions');
        return view('mi-perfil', compact('user'));
    }

    // Actualizar información personal
    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . Auth::id(),
        'sexo' => 'required|string',
        'cargo' => 'required|string',
        'area' => 'required|string',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = Auth::user();
    
    // Actualizar información básica
    $user->update($request->only(['name', 'email', 'sexo', 'cargo', 'area']));
    
    // Manejar avatar si se subió uno nuevo
    if ($request->hasFile('avatar')) {
        // Eliminar avatar anterior (si no es default)
        if ($user->avatar && $user->avatar !== 'default.jpg') {
            $oldPath = public_path('images/' . $user->avatar);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        
        // Guardar nuevo avatar
        $file = $request->file('avatar');
        $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        
        $user->update(['avatar' => $filename]);
    }
    
    // Manejar eliminación de avatar
    if ($request->delete_avatar == '1') {
        // Eliminar archivo anterior
        if ($user->avatar && $user->avatar !== 'default.jpg') {
            $oldPath = public_path('images/' . $user->avatar);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        
        $user->update(['avatar' => 'default.jpg']);
    }

    return redirect()->route('perfil.index')
        ->with('success', 'Información actualizada correctamente');
}

    // Cambiar contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('perfil.index')
            ->with('success', 'Contraseña actualizada correctamente');
    }

    // Cambiar avatar
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($user->avatar && $user->avatar !== 'default.jpg') {
            $oldPath = public_path('images/' . $user->avatar);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $file = $request->file('avatar');
        $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);

        $user->update(['avatar' => $filename]);

        return redirect()->route('perfil.index')
            ->with('success', 'Foto de perfil actualizada correctamente');
    }

    // Cerrar todas las sesiones
    public function logoutAllDevices(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'La contraseña es incorrecta']);
        }

        $user->update([
            'login_history' => []
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Se han cerrado todas las sesiones activas');
    }

    // Eliminar avatar (volver a default)
    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && $user->avatar !== 'default.jpg') {
            $oldPath = public_path('images/' . $user->avatar);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $user->update(['avatar' => 'default.jpg']);

        return redirect()->route('perfil.index')
            ->with('success', 'Foto de perfil eliminada correctamente');
    }
}
