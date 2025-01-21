<?php

namespace App\Http\Controllers;

use App\Models\ChatResponse;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getResponse(Request $request)
    {
        $query = strtolower($request->input('message')); // Convierte a minúsculas
        // Obtener todas las respuestas
        $responses = ChatResponse::all();
        foreach ($responses as $response) {
            $keywords = explode(',', $response->keywords); // Separar palabras clave
            foreach ($keywords as $keyword) {
                if (str_contains($query, trim($keyword))) {
                    return response()->json([
                        'response' => $response->response
                    ]);
                }
            }
        }
        return response()->json([
            'response' => "Lo siento, no entiendo tu consulta."
        ]);
    }
}
