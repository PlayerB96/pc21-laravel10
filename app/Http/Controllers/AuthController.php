<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserIntranet;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function auth(Request $request)
    {

        // Validación de los datos recibidos
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Debe ingresar username.',
            'password.required' => 'Debe ingresar password.',

        ]);
        // Buscar el usuario en la base de datos externa
        $user = UserIntranet::where('usuario_codigo', $request->username)->first();

        if (!$user) {
            // Si no se encuentra el usuario
            return response()->json(['error' => 'Usuario no encontrado.'], 401);
        }
        // Verificar si la contraseña es correcta
        if (password_verify($request->password, $user->usuario_password) == true) {
            // Concatenar el nombre completo
            $fullName = $user->usuario_nombres . ' ' . $user->usuario_apater . ' ' . $user->usuario_amater;
            // Obtener el valor de registro_masivo desde permiso_papeletas_salida
            $registroMasivo = $user->permisoPapeletasSalida->registro_masivo ?? null;

            // Guardar los datos en la sesión
            Session::put('usuario_codigo', $user->usuario_codigo);
            Session::put('nombre_completo', $fullName);
            Session::put('correo', $user->usuario_email);
            Session::put('id_puesto', $user->id_puesto);
            Session::put('id_nivel', $user->id_nivel);
            Session::put('id_usuario', $user->id_usuario);
            Session::put('emailp', $user->emailp);
            Session::put('foto', $user->foto);
            Session::put('registro_masivo', $registroMasivo);

            // Respuesta exitosa
            // $sessionData = Session::all();
            // dump($sessionData);
            return response()->json([
                'message' => 'Autenticación exitosa.',
                'nombre_completo' => $fullName,
                'foto' => $user->foto,
            ], 200);
        } else {
            return response()->json(['error' => 'Contraseña Incorrecta.'], 401);
        }
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
