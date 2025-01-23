<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\UserIntranet;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function auth(Request $request)
    {
        // dump($request->all());
        // Validación de los datos recibidos
        // $request->validate([
        //     'usuario_codigo' => 'required|string',  // Username
        //     'usuario_password' => 'required|string',  // Password
        // ]);
        // Buscar el usuario en la base de datos externa
        $user = UserIntranet::where('usuario_codigo', $request->username)->first();
        if (!$user) {
            // Si no se encuentra el usuario
            return response()->json(['error' => 'Usuario no encontrado.'], 401);
        }
        // Verificar si la contraseña es correcta
        // password_verify($password, $user->usuario_password)
        if (password_verify($request->password, $user->usuario_password) == true) {
            // Concatenar el nombre completo
            $fullName = $user->usuario_nombres . ' ' . $user->usuario_apater . ' ' . $user->usuario_amater;
            // Guardar los datos en la sesión
            Session::put('usuario_codigo', $user->username);
            Session::put('nombre_completo', $fullName);
            Session::put('correo', $user->usuario_email);
            Session::put('id_puesto', $user->id_puesto);
            Session::put('emailp', $user->emailp);
            Session::put('foto', $user->foto);

            // Respuesta exitosa
            return response()->json([
                'message' => 'Autenticación exitosa.',
                'nombre_completo' => $fullName,
                'foto' => $user->foto,
            ], 200);
        } else {
            // dump("entra aqui");
            return response()->json(['error' => 'Contraseña Incorrecta.'], 401);
        }
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
