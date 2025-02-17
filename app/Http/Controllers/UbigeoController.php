<?php

// app/Http/Controllers/UbigeoController.php
namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Distrito;
use Illuminate\Http\Request;

class UbigeoController extends Controller
{
    // Obtener todos los departamentos
    public function getDepartamentos()
    {
        $departamentos = Departamento::where('estado', 1)->get();
        return response()->json($departamentos);
    }

    // Obtener provincias por departamento
    public function getProvincias(Request $request)
    {
        $provincas = Provincia::where('id_departamento', $request->id_departamento)
            ->where('estado', 1)
            ->get();
        return response()->json($provincas);
    }

    // Obtener distritos por provincia
    public function getDistritos(Request $request)
    {
        $distritos = Distrito::where('id_provincia', $request->id_provincia)
            ->where('estado', 1)
            ->get();
        return response()->json($distritos);
    }

    // Obtener distritos por departamento (usando relaciones)
    public function getDistritosByDepartamento(Request $request)
    {
        $departamento = Departamento::with(['provincias.distritos' => function ($query) {
            $query->where('estado', 1);
        }])->find($request->id_departamento);

        return response()->json($departamento);
    }
}
