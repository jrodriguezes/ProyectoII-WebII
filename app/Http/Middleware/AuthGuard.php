<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthGuard
{
    public function handle(Request $request, Closure $next)
    {
        // Si NO existe la sesion de usuario, redirige al login
        if (!Session::has('user')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
