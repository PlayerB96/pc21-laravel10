<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudUser;
use App\Models\PermisoPapeletasSalida;
use App\Models\Destino;
use App\Models\Tramite;
use Illuminate\Support\Facades\Log;


class GestionPersonas extends Controller
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

    public function getPapeletas(Request $request)
    {
        $id_usuario = $request->id_usuario; // Se obtiene del Middleware automáticamente
        // dump('Solicitud llegada al controlador');
        $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida(1, $id_usuario);
        return response()->json($dato['list_papeletas_salida']);
    }

    public function buscar_papeletas(Request $request)
    {

        $estado_solicitud = $request->estado_solicitud;
        $id_nivel = $request->id_nivel;
        $id_puesto = $request->id_puesto;
        $cod_ubi = $request->cod_ubi;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        Log::info('Contenido del request:', $request->all());

        $this->Model_Solicitudes->verificacion_papeletas();
        // $list_papeletas_salida = $this->Model_Solicitudes->get_list_papeletas_salida($estado_solicitud, $id_usuario);
        $list_papeletas_salida = $this->Model_Solicitudes->get_list_papeletas_salida_gestion($estado_solicitud, $id_nivel, $id_puesto, $cod_ubi, $fecha_inicio, $fecha_fin);
        // Log::error('list_papeletas_salida:',$list_papeletas_salida);

        // Retornar los datos en formato JSON
        return response()->json([
            'list_papeletas_salida' => $list_papeletas_salida
        ]);
    }

    public function cambiar_motivo(Request $request)
    {
        $motivo = $request->query('motivo');
        $destinos = Destino::where('id_motivo', $motivo)->get(['id_destino as id', 'nom_destino as nombre']);
        return response()->json($destinos);
    }

    public function traer_tramite(Request $request)
    {
        $id_destino = $request->query('id_destino');
        $tramites = Tramite::where('id_destino', $id_destino)->get(['id_tramite as id', 'nom_tramite as nombre']);
        return response()->json($tramites);
    }


    public function store(Request $request)
    {
        $request->validate([
            'cod_ubi' => 'required',
            'id_usuario' => 'required',
            'id_gerencia' => 'required',
            'formulario.fec_solicitud' => 'required',
            'formulario.id_motivo' => 'required',
            'formulario.destino' => 'required',
            'formulario.tramite' => 'required',
            'formulario.especificacion_destino' => 'required',
            'formulario.especificacion_tramite' => 'required',
        ]);
        $cod_ubi = $request->cod_ubi;
        $id_usuario = $request->id_usuario;
        $id_gerencia = $request->id_gerencia;
        $form = $request->formulario;

        // GENERAR cod_solicitud
        $totalt = $this->Model_Solicitudes::where('id_solicitudes', 2)
            ->whereRaw("SUBSTR(cod_solicitud, 3, 4) = ?", [date('Y')])
            ->count();
        $aniof = date('Y');
        if ($totalt < 9) {
            $codigofinal = 'PP' . $aniof . "0000" . ($totalt + 1);
        } elseif ($totalt > 8 && $totalt < 99) {
            $codigofinal = 'PP' . $aniof . "000" . ($totalt + 1);
        } elseif ($totalt > 98 && $totalt < 999) {
            $codigofinal = 'PP' . $aniof . "00" . ($totalt + 1);
        } elseif ($totalt > 998 && $totalt < 9999) {
            $codigofinal = 'PP' . $aniof . "0" . ($totalt + 1);
        } else {
            $codigofinal = 'PP' . $aniof . ($totalt + 1);
        }

        // ASIGNAR ESTADO DE LA SOLICITUD EN BASE AL MOTIVO
        $estado_solicitud = $request['id_motivo'] == 1 ? 2 : 4;

        // Asignamos los datos a un arreglo para insertar
        $data = [
            'dif_dias' => 0.0,
            'user_horar_salida' => 0,
            'user_horar_entrada' => 0,
            'user_aprob' => 0,
            'mediodia' => 0,
            'observacion' => '0',
            'id_usuario' => $id_usuario,
            'id_solicitudes' => 2,
            'cod_solicitud' => $codigofinal,
            'cod_base' => $cod_ubi,
            'fec_solicitud' => $form['fec_solicitud'],
            'id_gerencia' => $id_gerencia,
            'hora_salida' => $form['hora_salida'],
            'hora_retorno' => $form['hora_retorno'],
            'id_motivo' => $form['id_motivo'],
            'motivo' => '',
            'destino' => $form['destino'],
            'tramite' => $form['tramite'],
            'especificacion_destino' => $form['especificacion_destino'],
            'especificacion_tramite' => $form['especificacion_tramite'],
            'estado_solicitud' => $estado_solicitud,
            'sin_ingreso' => $form['sin_ingreso'] ?: 0,
            'sin_retorno' => $form['sin_retorno'] ?: 0,
            'fec_reg' => now(),
            'user_reg' => $id_usuario,  // Aquí usas el id_usuario
            'estado' => 1,
            'fec_act' => now(),
            'user_act' => $id_usuario, // Usamos el id_usuario para el cambio
        ];
        SolicitudUser::create($data);
    }

    public function aprobado_papeletas_salida(Request $request)
    {
        try {
            $id_solicitudes_user = $request->id_solicitudes_user;
            $id_usuario = $request->id_usuario;
            $solicitud = SolicitudUser::findOrFail($id_solicitudes_user);
            $dato = [
                'id_solicitudes_user' => $solicitud->id_solicitudes_user,
                'id_motivo' => $solicitud->id_motivo,
                'id_modalidad_laboral' => $solicitud->user->id_modalidad_laboral,
                'sin_ingreso' => $solicitud->sin_ingreso,
                'sin_retorno' => $solicitud->sin_retorno,
                'num_doc' => $solicitud->user->num_doc,
                'horario' => [
                    [
                        'hora_entrada' => $solicitud->hora_salida,
                        'hora_salida' => $solicitud->hora_retorno
                    ]
                ]
            ];
            SolicitudUser::aprobado_papeletas_salida($dato, $id_usuario);
            return response()->json(['message' => 'Papeleta aprobada exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al aprobar papeleta.', 'error' => $e->getMessage()], 400);
        }
    }



    public function index_rpo()
    {
        return view('gestionpersonas.postulantes.index');
    }

    public function store_rpo()
    {
        return view('gestionpersonas.postulantes.index');
    }
}
