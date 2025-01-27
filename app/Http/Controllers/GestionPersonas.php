<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SolicitudUser; // Importar el modelo SolicitudUser

class GestionPersonas extends Controller
{
    protected $Model_Solicitudes;

    // Inyectar el modelo en el constructor
    public function __construct(SolicitudUser $Model_Solicitudes)
    {
        $this->Model_Solicitudes = $Model_Solicitudes;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('gestionpersonas.gestionpersonas');
    }

    public function registro_papeletas()
    {
        $dato['id_puesto'] = Session::get('id_puesto');
        $dato['id_nivel'] = Session::get('id_nivel');
        $dato['registro_masivo'] = Session::get('registro_masivo');

        // Llamar a la función del modelo
        $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida(1);
        $dato['ultima_papeleta_salida_todo'] = count($this->Model_Solicitudes->get_list_papeletas_salida_uno());

        return view('gestionpersonas.registro_papeletas', $dato);
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
