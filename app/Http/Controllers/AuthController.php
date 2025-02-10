<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserIntranet;
use Illuminate\Support\Facades\Auth;

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

    // public function auth(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ], [
    //         'username.required' => 'Debe ingresar username.',
    //         'password.required' => 'Debe ingresar password.',
    //     ]);
    //     // Buscar el usuario en la base de datos (INTRANET)
    //     $user = UserIntranet::where('usuario_codigo', $request->username)
    //         ->with(['puesto.area.subGerencia', 'ubicacion']) // Cargar las relaciones de puesto -> area -> subGerencia y ubicaciones
    //         ->first();

    //     // Acceder al sub_gerencia (subGerencia es la relación definida en Area)
    //     $subGerenciaId = $user->puesto->area->subGerencia->id_gerencia ?? null;
    //     // Verificar si el usuario fue encontrado
    //     if (!$user) {
    //         return response()->json(['error' => 'Usuario no encontrado.'], 401);
    //     }
    //     // Verificar si la contraseña es correcta
    //     if (password_verify($request->password, $user->usuario_password) == true) {
    //         $fullName = $user->usuario_nombres . ' ' . $user->usuario_apater . ' ' . $user->usuario_amater;
    //         // Obtener el valor de registro_masivo desde permiso_papeletas_salida
    //         $registroMasivo = $user->permisoPapeletasSalida->registro_masivo ?? null;
    //         // Obtener los cod_ubi de las relaciones 'ubicacionCentroLabor' y 'ubicacionUbicacion'
    //         $codUbiUbicacion = $user->ubicacion->cod_ubi ?? null;
    //         // Guardar los datos en la sesión
    //         Session::put('usuario_codigo', $user->usuario_codigo);
    //         Session::put('nombre_completo', $fullName);
    //         Session::put('correo', $user->usuario_email);
    //         Session::put('id_puesto', $user->id_puesto);
    //         Session::put('id_nivel', $user->id_nivel);
    //         Session::put('id_gerencia', $subGerenciaId);
    //         Session::put('ubicacion', $user->ubicacion);
    //         Session::put('id_usuario', $user->id_usuario);
    //         Session::put('emailp', $user->emailp);
    //         Session::put('foto', $user->foto);
    //         Session::put('registro_masivo', $registroMasivo);
    //         Session::put('cod_ubi', $codUbiUbicacion);
    //         Session::save();
    //         $sessionData = Session::all();
    //         // dd($sessionData);
    //         Log::info('Estado de la solicitud:', ['dasessionDatato' => $sessionData]);

    //         // Respuesta exitosa
    //         // return response()->json([
    //         //     'message' => 'Autenticación exitosa.',
    //         //     'nombre_completo' => $fullName,
    //         //     'foto' => $user->foto,
    //         //     'session_id' => session()->getId(), // ← Guardar y enviar el ID de sesión

    //         // ], 200);
    //         return response()->json([
    //             'message' => 'Autenticación exitosa.',
    //             'nombre_completo' => $fullName,
    //             'foto' => $user->foto,
    //         ], 200)->withCookie(cookie()->forever('laravel_session', session()->getId()));
    //     } else {
    //         return response()->json(['error' => 'Contraseña Incorrecta.'], 401);
    //     }
    // }



    public function logout()
    {
        // Cerrar sesión del usuario autenticado
        Auth::logout();
        // Limpiar la sesión
        session()->flush();
        // Devolver una respuesta JSON indicando que la sesión se cerró exitosamente
        return response()->json(['success' => true]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
