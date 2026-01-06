<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        $loginHistory = $user->login_history
            ? json_decode($user->login_history, true)
            : [];

        if (!is_array($loginHistory)) {
            $loginHistory = [];
        }

        array_unshift($loginHistory, [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);

        $loginHistory = array_slice($loginHistory, 0, 10);

        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
            'login_history' => json_encode($loginHistory),
        ]);

        AuditLog::log(
            action: 'login',
            description: "Inició sesión en el sistema - Cargo: {$user->cargo}",
            modelType: 'App\Models\User',
            modelId: $user->id
        );

        return match ($user->cargo) {
            'Administrador' => redirect('/dashboard-administrador'),
            'Presidente' => redirect('/dashboard-presidente-municipal'),
            'Sindico' => redirect('/dashboard-sindico-procurador'),
            'Regidor' => redirect('/dashboard-regidor'),
            'Director' => redirect('/dashboard-director-de-area'),
            'Auxiliar' => redirect('/dashboard-auxiliar-de-area'),
            default => redirect()->route('usuarios.index'),
        };
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            AuditLog::log(
                action: 'logout',
                description: 'Cerró sesión',
                modelType: 'App\Models\User',
                modelId: auth()->id()
            );
        }

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
