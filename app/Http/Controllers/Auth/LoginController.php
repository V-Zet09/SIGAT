<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\AuditLog; // ← AGREGADO

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirection after login depending on user role (cargo).
     */
    protected function authenticated(Request $request, $user)
    {
        // ✅ Registrar historial de sesión
        $loginHistory = $user->login_history ?? [];
        
        // Agregar nuevo inicio de sesión al historial (máximo 10)
        array_unshift($loginHistory, [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
        
        // Mantener solo los últimos 10 inicios de sesión
        $loginHistory = array_slice($loginHistory, 0, 10);
        
        // Actualizar usuario
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
            'login_history' => $loginHistory,
        ]);
        
        // ✅ REGISTRAR LOG DE LOGIN
        AuditLog::log(
            action: 'login',
            description: "Inició sesión en el sistema - Cargo: {$user->cargo}",
            modelType: 'App\Models\User',
            modelId: $user->id
        );
        
        // Redirección según cargo
        return match ($user->cargo) {
            'Administrador' => redirect('/dashboard-administrador'),
            'Presidente'   => redirect('/dashboard-presidente-municipal'),
            'Sindico'      => redirect('/dashboard-sindico-procurador'),
            'Regidor'      => redirect('/dashboard-regidor'),
            'Director'     => redirect('/dashboard-director-de-area'),
            'Auxiliar'     => redirect('/dashboard-auxiliar-de-area'),
            default        => redirect()->route('usuarios.index'),
        };
    }

    /**
     * ✅ SOBRESCRIBIR MÉTODO LOGOUT PARA REGISTRAR
     */
    public function logout(Request $request)
    {
        // Registrar logout ANTES de cerrar sesión
        if (auth()->check()) {
            AuditLog::log(
                action: 'logout',
                description: 'Cerró sesión',
                modelType: 'App\Models\User',
                modelId: auth()->id()
            );
        }
        
        // Ejecutar logout normal
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
