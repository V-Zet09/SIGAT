<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
{
    return match (auth()->user()->cargo) {
        'Administrador' => '/dashboard-administrador',
        'Presidente' => '/dashboard-presidente-municipal',
        'Sindico' => '/dashboard-sindico-procurador',
        'Regidor' => '/dashboard-regidor',
        'Director' => '/dashboard-director-de-area',
        'Auxiliar' => '/dashboard-auxiliar-area',
        default => '/home',
    };
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
