<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudUser;
use App\Models\PermisoPapeletasSalida;
use App\Models\FichaTecnicaProduccion;
use Illuminate\Support\Facades\DB;


class ProduccionController extends Controller
{
    protected $Model_Solicitudes;
    protected $Model_Permiso;


    public function __construct(SolicitudUser $Model_Solicitudes, PermisoPapeletasSalida $Model_Permiso)
    {
        $this->Model_Solicitudes = $Model_Solicitudes;
        $this->Model_Permiso = $Model_Permiso;
    }


    public function index()
    {
        return view('gestionpersonas.gestionpersonas');
    }

    public function buscar_fichas_tecnicas(Request $request)
    {
        $list_ficha_tecnica = FichaTecnicaProduccion::with(['user' => function ($query) {
            $query->select('id_usuario', DB::raw("CONCAT(usuario_nombres, ' ', usuario_apater, ' ', usuario_amater) AS nombre_completo"));
        }])
            ->where('estado', 1)
            ->orderBy('fec_reg', 'DESC')
            ->distinct('modelo')
            ->get(['id_ft_produccion', 'fec_reg', 'user_reg', 'modelo', 'img_ft_produccion']);

        return response()->json([
            'list_ficha_tecnica' => $list_ficha_tecnica
        ]);
    }
}
