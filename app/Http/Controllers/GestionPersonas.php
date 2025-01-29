<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SolicitudUser;
use App\Models\PermisoPapeletasSalida;
use App\Models\Destino;
use App\Models\Tramite;

class GestionPersonas extends Controller
{
    // Modelos utilizados en el controlador
    protected $Model_Solicitudes;
    protected $Model_Permiso;

    // Variables de sesión utilizadas en el controlador
    protected $id_puesto;
    protected $id_nivel;
    protected $registro_masivo;
    protected $id_usuario;
    protected $cod_ubi;
    protected $id_gerencia;

    // Constructor: inyección de dependencias y asignación de variables de sesión
    public function __construct(SolicitudUser $Model_Solicitudes, PermisoPapeletasSalida $Model_Permiso)
    {
        // Inyección de los modelos en el controlador
        $this->Model_Solicitudes = $Model_Solicitudes;
        $this->Model_Permiso = $Model_Permiso;

        // Asignación de las variables de sesión a las propiedades del controlador
        $this->id_puesto = Session::get('id_puesto');
        $this->id_usuario = Session::get('id_usuario');
        $this->id_nivel = Session::get('id_nivel');
        $this->registro_masivo = Session::get('registro_masivo');
        $this->cod_ubi = Session::get('cod_ubi');
        $this->id_gerencia = Session::get('id_gerencia');
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
        $dato['id_puesto'] = $this->id_puesto;
        $dato['id_nivel'] = $this->id_nivel;
        $dato['registro_masivo'] = $this->registro_masivo;
        $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida(1);
        $dato['ultima_papeleta_salida_todo'] = count($this->Model_Solicitudes->get_list_papeletas_salida_uno());

        return view('gestionpersonas.registro_papeletas.index', $dato);
    }

    public function buscar_papeletas(Request $request)
    {
        $dato['id_puesto'] = $this->id_puesto;
        $dato['id_nivel'] = $this->id_nivel;
        $dato['registro_masivo'] = $this->registro_masivo;
        $dato['ultima_papeleta_salida_todo'] = count($this->Model_Solicitudes->get_list_papeletas_salida_uno());
        $estado_solicitud = $request->estado_solicitud;
        $this->Model_Solicitudes->verificacion_papeletas();
        // Recuperamos las papeletas filtradas
        $list_papeletas_salida = $this->Model_Solicitudes->get_list_papeletas_salida($estado_solicitud);
        // dd($list_papeletas_salida);
        // Retornar los datos en formato JSON
        return response()->json([
            'list_papeletas_salida' => $list_papeletas_salida
        ]);
    }



    public function cambiar_motivo(Request $request)
    {
        $dato['id_motivo'] = $request->id_motivo;
        $dato['list_destino'] = Destino::where('id_motivo', $dato['id_motivo'])->get();
        $options = '';
        foreach ($dato['list_destino'] as $destino) {
            $options .= '<option value="' . $destino->id_destino . '">' . $destino->nom_destino . '</option>';
        }
        return response($options);
    }


    public function traer_tramite(Request $request)
    {
        $id_destino = $request->id_destino;
        $tramites = Tramite::where('id_destino', $id_destino)->get();
        $options = '';
        foreach ($tramites as $tramite) {
            $options .= '<option value="' . $tramite->id_tramite . '">' . $tramite->nom_tramite . '</option>';
        }
        return response($options);
    }

    public function store(Request $request)
    {
        $cod_ubi = $this->cod_ubi;
        $id_usuario = $this->id_usuario;
        $id_gerencia = $this->id_gerencia;

        // GENERAR cod_solicitud
        $totalt = $this->Model_Solicitudes::where('id_solicitudes', 2)
            ->whereRaw("SUBSTR(cod_solicitud, 3, 4) = ?", [date('Y')])
            ->count();
        $aniof = date('Y');
        if ($totalt < 9) {
            $codigofinal = 'PP' . $aniof . "0000" . ($totalt + 1);
        }
        if ($totalt > 8 && $totalt < 99) {
            $codigofinal = 'PP' . $aniof . "000" . ($totalt + 1);
        }
        if ($totalt > 98 && $totalt < 999) {
            $codigofinal = 'PP' . $aniof . "00" . ($totalt + 1);
        }
        if ($totalt > 998 && $totalt < 9999) {
            $codigofinal = 'PP' . $aniof . "0" . ($totalt + 1);
        }
        if ($totalt > 9998) {
            $codigofinal = 'PP' . $aniof . ($totalt + 1);
        }

        // ASIGNAR ESTADO DE LA SOLICITUD EN BASE AL MOTIVO
        if ($request['id_motivo'] == 1) {
            $estado_solicitud = 2;
        } else {
            $estado_solicitud = 4;
        }
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
            'fec_solicitud' => $request['fec_solicitud'],
            'id_gerencia' => $id_gerencia,
            'hora_salida' => $request['hora_salida'],
            'hora_retorno' => $request['hora_retorno'],
            'id_motivo' => $request['id_motivo'],
            'motivo' => '',
            'destino' => $request['destino'],
            'tramite' => $request['tramite'],
            'especificacion_destino' => $request['especificacion_destino'],
            'especificacion_tramite' => $request['especificacion_tramite'],
            'estado_solicitud' => $estado_solicitud,
            'sin_ingreso' => $request['sin_ingreso'] ?: 0,
            'sin_retorno' => $request['sin_retorno'] ?: 0,
            'fec_reg' => now(),
            'user_reg' => $id_usuario,  // Aquí usas el id_usuario
            'estado' => 1,
            'fec_act' => now(),
            'user_act' => $id_usuario, // Usamos el id_usuario para el cambio
        ];
        // dump($data);
        // Inserción utilizando Eloquent
        SolicitudUser::create($data);
        // Retornar respuesta (puedes hacer algo como redirigir o devolver un mensaje)
        return response()->json(['message' => 'Solicitud registrada exitosamente.']);
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
