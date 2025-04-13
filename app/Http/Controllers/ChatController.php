<?php

namespace App\Http\Controllers;

use App\Models\ChatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Agrega Log para depurar
use App\Models\Ticket;

class ChatController extends Controller
{
    public function chat_response(Request $request)
    {
        $query = strtolower($request->input('message'));
        $chatbotUrl = 'http://159.223.200.169:6000/chatbot';

        $ip = $request->ip();
        $location = $this->get_location_by_ip($ip);

        Log::info('Latitud:', ['lat' => $location['lat']]);
        Log::info('Longitud:', ['long' => $location['long']]);

        try {
            $response = Http::post($chatbotUrl, [
                'message' => $query,
                'lat' => $location['lat'],
                'long' => $location['long'],
            ]);

            if ($response->successful()) {
                $responseJson = $response->json();  // Obtener la respuesta como array
                Log::info('Respuesta del chatbot:', ['response' => $responseJson]);
            
                $respuestaChatbot = $responseJson['response'];
                $status = $responseJson['status'] ?? false;  // Usar null coalescing para evitar errores si no existe
            
                Log::info('status:', ['status' => $status]);
            
                if ($status === true) {
                    // Insertar en la tabla tickets
                    DB::table('tickets')->insert([
                        'telefono' => $query,
                        'estado' => 1,  // Asegúrate de insertar el estado si es necesario
                        'fecha_registro' => now(),  // Fecha de registro automáticamente
                    ]);
                }
            
                return response()->json([
                    'message' => $respuestaChatbot,
                    'content' => ''
                ]);
            }
            
            return response()->json([
                'message' => "Error al obtener respuesta del chatbot."
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error en chat_response', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => "Ocurrió un error, intenta de nuevo más tarde."
            ], 500);
        }
    }


    public function getTickets()
    {
        // Recuperar todos los tickets de la base de datos
        $tickets = Ticket::all();
        Log::info('Tickets:', ['tickets' => $tickets]);

        // Devolver los tickets en formato JSON
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
    
}
