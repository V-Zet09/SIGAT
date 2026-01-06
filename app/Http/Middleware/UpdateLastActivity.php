<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;   // 👈 IMPORTANTE

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)  // 👈 tipado correcto
    {
        if (Auth::check()) {
            Auth::user()->update([
                'last_activity_at' => now(),
            ]);
        }

        return $next($request);
    }
}
