<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario envió los datos desde localStorage en la cabecera
        if ($request->hasHeader('X-User-Data')) {
            $userData = json_decode($request->header('X-User-Data'), true);

            // Hacer disponibles los datos del usuario en todas las rutas
            $request->merge([
                'id_usuario' => $userData['id_usuario'] ?? null,
                'id_puesto' => $userData['id_puesto'] ?? null,
                'id_nivel' => $userData['id_nivel'] ?? null,
                'registro_masivo' => $userData['registro_masivo'] ?? null,
                'cod_ubi' => $userData['cod_ubi'] ?? null,
                'id_gerencia' => $userData['id_gerencia'] ?? null,
            ]);
        }

        return $next($request);
    }
}
