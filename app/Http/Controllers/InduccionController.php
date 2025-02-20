<?php

namespace App\Http\Controllers;

use App\Models\PreguntaInduccion;
use App\Models\RespuestaInduccion;
use App\Models\UserIntranet;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class InduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('induccion/video_induccion');
    }
    public function preguntas_induccion()
    {
        $preguntas = PreguntaInduccion::with('respuestas')->get();
        // Log::info("preguntas: " . json_encode($preguntas));
        return response()->json([
            'success' => true,
            'preguntas' => $preguntas
        ], 200);
    }


    public function submit_survey(Request $request)
    {
        $id_usuario =  $request->input('id_usuario');
        Log::error('id_usuario:', ['valor' => $id_usuario]);

        $preguntas = PreguntaInduccion::with('respuestas')->get();
        $respuestasUsuario = $request->input('respuestas', []);
        $puntajeTotal = 0;
        $puntajeMaximo = 0;
        foreach ($respuestasUsuario as $idPregunta => $respuestasSeleccionadas) {
            // Obtener todas las respuestas correctas para la pregunta
            $respuestasCorrectas = RespuestaInduccion::where('id_pregunta', $idPregunta)
                ->where('correcto', 1)
                ->pluck('id_respuesta')
                ->toArray();
            $puntajeMaximo += count($respuestasCorrectas);
            // Comparar respuestas seleccionadas con las correctas
            $aciertos = array_intersect($respuestasCorrectas, $respuestasSeleccionadas);
            $puntajeTotal += count($aciertos);
        }
        // Calcular el porcentaje de aciertos
        $porcentaje = $puntajeMaximo > 0 ? ($puntajeTotal / $puntajeMaximo) * 100 : 0;
        $porcentajeEntero = intval($porcentaje);


        if ($porcentajeEntero > 10) {
            Log::error('INGRESO AUQI:', ['valor' => $id_usuario]);
            UserIntranet::where('id_usuario', $id_usuario)
                ->update([
                    'induccion' => 1, // Ya aprobo el formulario de Inducción
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);
        }

        return response()->json(['porcentaje' => $porcentaje, 'preguntas' => $preguntas]);
    }
}
