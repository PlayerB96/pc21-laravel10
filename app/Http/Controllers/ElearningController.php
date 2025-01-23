<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElearningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $videos = [
            ['url' => 'https://www.youtube.com/embed/fXJsrd-F5wQ?si=aG51Mp2k9l15etH2', 'title' => 'Video 1', 'description' => 'Descripción del video 1'],
            ['url' => 'https://www.youtube.com/embed/fXJsrd-F5wQ?si=aG51Mp2k9l15etH2', 'title' => 'Video 2', 'description' => 'Descripción del video 2'],
            ['url' => 'https://www.youtube.com/embed/fXJsrd-F5wQ?si=aG51Mp2k9l15etH2', 'title' => 'Video 3', 'description' => 'Descripción del video 3'],
            // Puedes agregar más videos aquí
        ];
        return view('elearning.cursos', compact('videos'));
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
