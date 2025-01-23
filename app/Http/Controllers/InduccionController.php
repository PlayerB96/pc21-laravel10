<?php

namespace App\Http\Controllers;

use App\Models\PreguntaInduccion;
use App\Models\RespuestaInduccion;

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
    public function index_encuesta()
    {
        $preguntas = PreguntaInduccion::with('respuestas')->get();
        return view('induccion.encuesta_induccion', compact('preguntas'));
    }

    public function submitSurvey(Request $request)
{
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
    return response()->json(['porcentaje' => $porcentaje, 'preguntas' => $preguntas]);
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
