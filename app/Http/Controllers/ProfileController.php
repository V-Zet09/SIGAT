<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\AuditLog;

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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo debe ser válido',
            'email.unique' => 'Este correo ya está en uso',
            'avatar.image' => 'El archivo debe ser una imagen',
            'avatar.mimes' => 'Solo se permiten formatos: jpeg, png, jpg, gif',
            'avatar.max' => 'La imagen no debe pesar más de 2MB',
        ]);

        $user = Auth::user();
        
        // ✅ Detectar cambios para el log
        $cambios = [];
        if ($user->name !== $request->name) {
            $cambios[] = "nombre: {$user->name} → {$request->name}";
        }
        if ($user->email !== $request->email) {
            $cambios[] = "email: {$user->email} → {$request->email}";
        }
        
        // Actualizar información básica
        $user->update($request->only(['name', 'email']));
        
        // 📸 Manejar avatar si se subió uno nuevo
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior (si no es default)
            if ($user->avatar && $user->avatar !== 'default.jpg') {
                $oldPath = public_path('images/' . $user->avatar);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            
            // Guardar nuevo avatar en public/images/
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // Mover a public/images
            $file->move(public_path('images'), $filename);
            
            $user->update(['avatar' => $filename]);
            
            // ✅ Registrar cambio de avatar
            AuditLog::log(
                action: 'editar',
                description: 'Actualizó su foto de perfil',
                modelType: 'App\Models\User',
                modelId: $user->id
            );
        }
        
        // 🗑️ Manejar eliminación de avatar
        if ($request->delete_avatar == '1') {
            if ($user->avatar && $user->avatar !== 'default.jpg') {
                $oldPath = public_path('images/' . $user->avatar);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            
            $user->update(['avatar' => 'default.jpg']);
            
            // ✅ Registrar eliminación de avatar
            AuditLog::log(
                action: 'editar',
                description: 'Eliminó su foto de perfil',
                modelType: 'App\Models\User',
                modelId: $user->id
            );
        }

        // ✅ Registrar cambios de información personal
        if (!empty($cambios)) {
            AuditLog::log(
                action: 'editar',
                description: 'Actualizó su información personal: ' . implode(', ', $cambios),
                modelType: 'App\Models\User',
                modelId: $user->id
            );
        }

        return redirect()->route('perfil.index')
            ->with('success', '✅ Información actualizada correctamente');
    }

    // Cambiar contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'password.required' => 'La nueva contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // ✅ Registrar cambio de contraseña
        AuditLog::log(
            action: 'editar',
            description: 'Cambió su contraseña',
            modelType: 'App\Models\User',
            modelId: $user->id
        );

        return redirect()->route('perfil.index')
            ->with('success', '✅ Contraseña actualizada correctamente');
    }

    // Cambiar avatar (método alternativo)
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'avatar.required' => 'Debes seleccionar una imagen',
            'avatar.image' => 'El archivo debe ser una imagen',
            'avatar.mimes' => 'Solo se permiten formatos: jpeg, png, jpg, gif',
            'avatar.max' => 'La imagen no debe pesar más de 2MB',
        ]);

        $user = Auth::user();

        // Eliminar avatar anterior
        if ($user->avatar && $user->avatar !== 'default.jpg') {
            $oldPath = public_path('images/' . $user->avatar);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        // Guardar nuevo avatar en public/images/
        $file = $request->file('avatar');
        $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);

        $user->update(['avatar' => $filename]);

        // ✅ Registrar cambio de avatar
        AuditLog::log(
            action: 'editar',
            description: 'Actualizó su foto de perfil',
            modelType: 'App\Models\User',
            modelId: $user->id
        );

        return redirect()->route('perfil.index')
            ->with('success', '✅ Foto de perfil actualizada correctamente');
    }

    // Eliminar avatar (volver a default)
    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && $user->avatar !== 'default.jpg') {
            $oldPath = public_path('images/' . $user->avatar);
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
        }

        $user->update(['avatar' => 'default.jpg']);

        // ✅ Registrar eliminación de avatar
        AuditLog::log(
            action: 'editar',
            description: 'Eliminó su foto de perfil',
            modelType: 'App\Models\User',
            modelId: $user->id
        );

        return redirect()->route('perfil.index')
            ->with('success', '✅ Foto de perfil eliminada correctamente');
    }

    // Cerrar todas las sesiones
    public function logoutAllDevices(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ], [
            'password.required' => 'La contraseña es obligatoria',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'La contraseña es incorrecta']);
        }

        // ✅ Registrar cierre de sesiones
        AuditLog::log(
            action: 'logout',
            description: 'Cerró todas las sesiones activas',
            modelType: 'App\Models\User',
            modelId: $user->id
        );

        $user->update([
            'login_history' => []
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Se han cerrado todas las sesiones activas');
    }
}