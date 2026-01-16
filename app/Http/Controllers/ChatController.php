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
        // Asegurar que siempre devolvemos JSON
        try {
            // Log de la petición entrante
            Log::info('=== Petición recibida en chat_response ===', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'headers' => $request->headers->all(),
                'telefono' => $request->input('telefono'),
                'nombre_completo' => $request->input('nombre_completo'),
                'todos_los_datos' => $request->all(),
                'content_type' => $request->header('Content-Type'),
                'accept' => $request->header('Accept')
            ]);

            $solicitud = $request->input('solicitud');
            $nombreCompleto = $request->input('nombre_completo', 'Usuario no Registrado');

            // Número de WhatsApp por defecto (configurar aquí)
            $numeroWhatsAppDefault = '+51986514012'; // Número por defecto para recibir solicitudes

            // Validar que se envíe la solicitud
            if (!$solicitud || trim($solicitud) === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Por favor, describe tu solicitud o consulta.',
                    'error' => 'Solicitud requerida'
                ], 400)->header('Content-Type', 'application/json');
            }

            // Generar número de ticket iterativo
            try {
                $ultimoTicket = DB::table('tickets')->whereNotNull('numero_ticket')->orderBy('numero_ticket', 'desc')->first();
                $numeroTicket = $ultimoTicket && isset($ultimoTicket->numero_ticket) ? $ultimoTicket->numero_ticket + 1 : 1;
            } catch (\Exception $e) {
                $ultimoTicket = DB::table('tickets')->orderBy('id', 'desc')->first();
                $numeroTicket = $ultimoTicket ? $ultimoTicket->id + 1 : 1;
            }

            // Insertar en la tabla tickets (sin teléfono)
            $ticketData = [
                'telefono' => 'N/A',
                'nombre_solicitante' => $nombreCompleto,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            try {
                $ticketData['numero_ticket'] = $numeroTicket;
                DB::table('tickets')->insert($ticketData);
            } catch (\Exception $e) {
                unset($ticketData['numero_ticket']);
                DB::table('tickets')->insert($ticketData);
                $ticketInsertado = DB::table('tickets')->where('nombre_solicitante', $nombreCompleto)
                    ->orderBy('id', 'desc')
                    ->first();
                if ($ticketInsertado) {
                    $numeroTicket = $ticketInsertado->id;
                }
            }

            // Construir mensaje para enviar al número de WhatsApp por defecto
            $mensajeParaWhatsApp = "📋 *Nueva Solicitud Recibida*\n\n";
            $mensajeParaWhatsApp .= "👤 *Cliente:* {$nombreCompleto}\n";
            $mensajeParaWhatsApp .= "🎫 *Ticket:* #{$numeroTicket}\n\n";
            $mensajeParaWhatsApp .= "💬 *Solicitud:*\n{$solicitud}";
            
            // Remover el + para la URL de WhatsApp
            $numeroWhatsAppSinPrefijo = str_replace('+', '', $numeroWhatsAppDefault);
            
            // Construir la URL de WhatsApp con el mensaje preformateado
            $mensajeCodificado = urlencode($mensajeParaWhatsApp);
            $whatsappUrl = 'https://wa.me/' . $numeroWhatsAppSinPrefijo . '?text=' . $mensajeCodificado;

            Log::info('Solicitud procesada exitosamente', [
                'numero_ticket' => $numeroTicket,
                'nombre_completo' => $nombreCompleto,
                'solicitud' => $solicitud,
                'whatsapp_url' => $whatsappUrl
            ]);

            return response()->json([
                'success' => true,
                'message' => "¡Tu solicitud ha sido recibida! Tu número de ticket es #{$numeroTicket}.",
                'numero_ticket' => $numeroTicket,
                'whatsapp_url' => $whatsappUrl
            ], 200)->header('Content-Type', 'application/json');
            
        } catch (\Illuminate\Database\QueryException $dbError) {
            Log::error('Error de base de datos en chat_response', [
                'error' => $dbError->getMessage(),
                'code' => $dbError->getCode(),
                'sql' => $dbError->getSql() ?? 'N/A',
                'telefono' => $telefono ?? 'N/A'
            ]);

            return response()->json([
                'message' => "Ocurrió un error con la base de datos. Por favor, intenta de nuevo más tarde.",
                'error' => 'Database error',
                'error_details' => env('APP_DEBUG') ? $dbError->getMessage() : 'Error interno'
            ], 500)->header('Content-Type', 'application/json');
            
        } catch (\Exception $e) {
            Log::error('Error general en chat_response', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'telefono' => $telefono ?? 'N/A'
            ]);

            return response()->json([
                'message' => "Ocurrió un error, intenta de nuevo más tarde.",
                'error' => 'Server error',
                'error_details' => env('APP_DEBUG') ? $e->getMessage() : 'Error interno'
            ], 500)->header('Content-Type', 'application/json');
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
