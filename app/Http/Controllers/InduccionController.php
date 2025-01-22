<?php

namespace App\Http\Controllers;

use App\Models\PreguntaInduccion;

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
        // dd($preguntas);
        return view('induccion.encuesta_induccion', compact('preguntas'));
    }

    public function submitSurvey()
    {
        return redirect()->route('home');
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
