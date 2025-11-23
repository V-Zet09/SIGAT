<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
        
        // Redirección según cargo
        return match ($user->cargo) {
            'Administrador' => redirect('/dashboard-administrador'),
            'Presidente'   => redirect('/dashboard-presidente-municipal'),
            'Sindico'      => redirect('/dashboard-sindico-procurador'),
            'Regidor'      => redirect('/dashboard-regidor'),
            'Director'     => redirect('/dashboard-director-de-area'),
            'Auxiliar'     => redirect('/dashboard-auxiliar-area'),
            default        => redirect()->route('usuarios.index'),
        };
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}