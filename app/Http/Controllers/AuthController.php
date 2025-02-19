<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserIntranet;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\UserPermission;


use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Debe ingresar username.',
            'password.required' => 'Debe ingresar password.',
        ]);

        // Buscar el usuario en la base de datos (INTRANET)
        $user = UserIntranet::where('usuario_codigo', $request->username)
            ->with(['puesto.area.subGerencia', 'ubicacion']) // Cargar relaciones
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 401);
        }

        if (!password_verify($request->password, $user->usuario_password)) {
            return response()->json(['error' => 'Contraseña Incorrecta.'], 401);
        }

        // Construir objeto sessionData con toda la información del usuario
        $sessionData = [
            'usuario_codigo' => $user->usuario_codigo,
            'nombre_completo' => "{$user->usuario_nombres} {$user->usuario_apater} {$user->usuario_amater}",
            'correo' => $user->usuario_email,
            'id_puesto' => $user->id_puesto,
            'id_nivel' => $user->id_nivel,
            'id_gerencia' => $user->puesto->area->subGerencia->id_gerencia ?? null,
            'ubicacion' => $user->ubicacion,
            'id_usuario' => $user->id_usuario,
            'emailp' => $user->emailp,
            'induccion' => $user->induccion,
            'foto' => $user->foto,
            'registro_masivo' => $user->permisoPapeletasSalida->registro_masivo ?? null,
            'cod_ubi' => $user->ubicacion->cod_ubi ?? null
        ];

        // Retornar datos al frontend para almacenarlos en localStorage
        return response()->json([
            'message' => 'Autenticación exitosa.',
            'sessionData' => $sessionData
        ], 200);
    }


    public function logout()
    {
        // Cerrar sesión del usuario autenticado
        Auth::logout();
        // Limpiar la sesión
        session()->flush();
        // Devolver una respuesta JSON indicando que la sesión se cerró exitosamente
        return response()->json(['success' => true]);
    }


    public function verificar_permisos(Request $request)
    {
        Log::error('request papeleta:', ['request' => ($request->all())]);

        $request->validate([
            'permiso' => 'required|string',
            'id_puesto' => 'required|integer',
            'id_nivel' => 'required|integer',
            'id_area' => 'required|integer',
            'id_sub_gerencia' => 'required|integer',
        ]);

        // Buscar el permiso por su nombre
        $permission = Permission::where('name_permission', $request->permiso)->first();

        if (!$permission) {
            return response()->json(['acceso' => false, 'message' => 'Permiso no encontrado'], 404);
        }

        // Construir la consulta
        $query = UserPermission::where('id_permission', $permission->id_permission)
            ->where(function ($query) use ($request) {
                $query->where('id_puesto', $request->id_puesto)
                    ->orWhere('id_nivel', $request->id_nivel)
                    ->orWhere('id_area', $request->id_area)
                    ->orWhere('id_sub_gerencia', $request->id_sub_gerencia);
            });

        // Verificar si existe coincidencia
        $exists = $query->exists();

        // Log de la consulta generada
        Log::info('Consulta generada:', ['query' => $query->toSql()]);

        // Log de los valores utilizados en la consulta
        Log::info('Valores de la consulta:', [
            'id_permission' => $permission->id_permission,
            'id_puesto' => $request->id_puesto,
            'id_nivel' => $request->id_nivel,
            'id_area' => $request->id_area,
            'id_sub_gerencia' => $request->id_sub_gerencia,
            'exists' => $exists
        ]);

        return response()->json(['acceso' => $exists]);
    }
}
