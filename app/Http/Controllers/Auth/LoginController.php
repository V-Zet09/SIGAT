<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Redirection after login depending on user role (cargo).
     */
    protected function authenticated(Request $request, $user)
    {
        return match ($user->cargo) {
            'Administrador' => redirect('/dashboard-administrador'),
            'Presidente'   => redirect('/dashboard-presidente-municipal'),
            'Sindico'      => redirect('/dashboard-sindico-procurador'),
            'Regidor'      => redirect('/dashboard-regidor'),
            'Director'     => redirect('/dashboard-director-de-area'),
            'Auxiliar'     => redirect('/dashboard-auxiliar-area'),
            default        => redirect('/home'),
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
