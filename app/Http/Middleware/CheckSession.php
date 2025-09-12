<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckSession
{

    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si la sesión está iniciada
        if (!Session::has('id')) {
            return redirect()->route('inicio')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        return $next($request);
    }
}
