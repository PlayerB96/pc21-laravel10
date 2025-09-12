<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Hash;


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
    
        // Buscar usuario en SQLite
        $user = Usuario::where('username', $request->username)->first();
    
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }
    
        // Verificar la contraseña
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Contraseña Incorrecta.'], 401);
        }
    
        // Construir objeto de sesión
        $sessionData = [
            'id' => $user->id,
            'nombre_completo' => $user->nombre_completo,
            'email' => $user->email,
            'telefono' => $user->telefono,
            'username' => $user->username,
        ];
    
        return response()->json([
            'message' => 'Autenticación exitosa.',
            'sessionData' => $sessionData
        ], 200);
    }
    

    public function register(Request $request)
    {
        // Asegurar que el email no tenga espacios extra
        $request->merge(['email' => trim($request->email)]);
           Log::info("Archivo subido exitosamente: $request->email");
        $request->validate([
            'username' => 'required|unique:users',
            'telefono' => 'sometimes|unique:users',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users',
            'nombre_completo' => 'required',
        ], [
            'email.email' => 'El formato del correo no es válido.',
        ]);
    
        $user = Usuario::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'nombre_completo' => $request->nombre_completo,
            'telefono' => $request->telefono ?? null,
        ]);
    
        return response()->json([
            'message' => 'Usuario registrado exitosamente.',
            'user' => $user
        ], 201);
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


    
}
