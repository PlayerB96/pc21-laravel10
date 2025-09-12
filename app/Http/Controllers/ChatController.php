<?php

namespace App\Http\Controllers;

use App\Models\ChatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Agrega Log para depurar
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;


class ChatController extends Controller
{
    public function chat_response(Request $request)
    {
        $query = strtolower($request->input('message'));
        $nombreCompleto = $request->input('nombre_completo', 'Usuario no Registrado'); // 👈

        $chatbotUrl = 'http://31.97.11.235:6000/chatbot';

        $ip = $request->ip();
        $location = $this->get_location_by_ip($ip);

        try {
            $response = Http::post($chatbotUrl, [
                'message' => $query,
                'lat' => $location['lat'],
                'long' => $location['long'],
            ]);

            // Verificar la respuesta del servidor y loguearla completamente
            if ($response->successful()) {
                $responseJson = $response->json();  // Obtener la respuesta como array

                $respuestaChatbot = $responseJson['response'];
                $status = $responseJson['status'] ?? false;  // Usar null coalescing para evitar errores si no existe

                if ($status === true) {
                    // Insertar en la tabla tickets
                    DB::table('tickets')->insert([
                        'telefono' => $query,
                        'nombre_solicitante' => $nombreCompleto,


                    ]);
                }
                return response()->json([
                    'message' => $respuestaChatbot,
                    'content' => ''
                ]);
            }

            return response()->json([
                'message' => "Error al obtener respuesta del chatbot.",
                'error_details' => [
                    'status_code' => $response->status(),
                    'body' => $response->body()
                ]
            ], 500);
        } catch (\Exception $e) {
            // Enviar la respuesta con más detalles
            return response()->json([
                'message' => "Ocurrió un error, intenta de nuevo más tarde.",
                'error_details' => [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]
            ], 500);
        }
    }



    public function getTickets()
    {
        // Recuperar todos los tickets de la base de datos
        $tickets = Ticket::all();
        // Devolver los tickets en formato JSON
        return response()->json($tickets);
    }

    public function getTicketsByUser(Request $request)
    {
        $telefono = $request->query('telefono');
        Log::info('telefono:', ['telefono' => $telefono]);

        // Validar que venga el parámetro
        if (!$telefono) {
            return response()->json(['error' => 'Se requiere teléfono'], 400);
        }

        // Filtrar los tickets por nombre_solicitante (suponiendo que nombre_solicitante es el id o código)
        $tickets = Ticket::where('telefono', $telefono)->get();
        Log::info('Tickets:', ['tickets' => $tickets]);

        return response()->json($tickets);
    }


    /**
     * Obtener la latitud y longitud de la IP utilizando ipinfo.io
     * 
     * @param string $ip
     * @return array
     */
    private function get_location_by_ip($ip)
    {
        try {
            // $ip = '190.123.123.123';  // Una IP pública para pruebas

            // Solicitar datos de geolocalización mediante ipinfo.io
            $response = Http::get('http://ipinfo.io/' . $ip . '/json');

            // Verificar si la respuesta es exitosa
            if ($response->successful()) {
                $data = $response->json();

                // Verificar si el campo 'loc' está presente y no está vacío
                if (isset($data['loc']) && !empty($data['loc'])) {
                    $loc = $data['loc']; // 'loc' contiene latitud y longitud
                    $location = explode(",", $loc); // Separar latitud y longitud

                    // Verificar que se obtuvieron correctamente lat y long
                    if (count($location) == 2) {
                        return [
                            'lat' => $location[0] ?? null,
                            'long' => $location[1] ?? null
                        ];
                    }
                } else {
                    // Si no se encuentra 'loc' o está vacío
                    Log::warning("No se encontró la ubicación para la IP: " . $ip);
                }
            } else {
                // Si la solicitud a ipinfo.io no fue exitosa
                Log::warning("Error al obtener datos de geolocalización para la IP: " . $ip);
            }
        } catch (\Exception $e) {
            // Si ocurre una excepción en la solicitud
            Log::error("Error al obtener la ubicación para la IP: " . $ip . ". Error: " . $e->getMessage());
        }

        // Si no se pudo obtener la latitud y longitud, devolver valores nulos
        return [
            'lat' => null,
            'long' => null
        ];
    }

    public function update(Request $request, $id)
    {
        try {
            // Buscar usuario por ID
            $usuario = Usuario::findOrFail($id);

            // Validar datos
            $validated = $request->validate([
                'nombre_completo' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $usuario->id,
                'telefono' => 'required|string|max:20',
            ]);

            // Actualizar usuario
            $usuario->update($validated);

            Log::info('Usuario actualizado', ['usuario' => $usuario]);

            return response()->json($usuario, 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar usuario', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al actualizar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
