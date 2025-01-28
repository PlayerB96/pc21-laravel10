<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SolicitudUser extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';
    protected $table = 'solicitudes_user'; 
    protected $primaryKey = 'id_solicitudes_user';

    protected $fillable = [
        'id_usuario',
        'id_solicitudes',
        'cod_solicitud',
        'cod_base',
        'id_gerencia',
        'anio',
        'fec_desde',
        'fec_hasta',
        'dif_dias',
        'fec_solicitud',
        'hora_salida',
        'hora_retorno',
        'horar_salida',
        'horar_retorno',
        'user_horar_salida',
        'user_horar_entrada',
        'id_motivo',
        'destino',
        'tramite',
        'especificacion_destino',
        'especificacion_tramite',
        'motivo',
        'estado_solicitud',
        'user_aprob',
        'fec_apro',
        'sin_ingreso',
        'sin_retorno',
        'mediodia',
        'observacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    // Definir las fechas para que el modelo pueda manejarlas automáticamente
    protected $dates = ['fec_solicitud', 'fec_apro', 'fec_reg', 'fec_act', 'fec_eli'];

    // Si no estás usando timestamps automáticos, puedes desactivar la propiedad
    public $timestamps = false;

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(UserIntranet::class, 'user_reg', 'id_usuario');
    }

    // Relación con el modelo Destino
    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destino', 'id_destino');
    }

    // Relación con el modelo Tramite
    public function tramite()
    {
        return $this->belongsTo(Tramite::class, 'tramite', 'id_tramite');
    }

    public function get_list_papeletas_salida($estado_solicitud = null)
    {
        $id_usuario = Session::get('id_usuario');

        // Construir la consulta usando Eloquent
        $query = SolicitudUser::with(['user', 'destino', 'tramite'])
            ->where('estado', 1)
            ->where('id_solicitudes', 2)
            ->where('id_usuario', $id_usuario);

        // Filtrar por estado_solicitud
        if ($estado_solicitud > 0) {
            if ($estado_solicitud == 1) {
                $query->whereIn('estado_solicitud', [1, 4, 5]);
            } else {
                $query->where('estado_solicitud', $estado_solicitud);
            }
        }

        // Seleccionar los campos necesarios
        $result = $query->orderBy('fec_reg', 'DESC')
            ->get()
            ->map(function ($solicitud) {
                // Incluir todos los campos de la tabla solicitudes_user
                return $solicitud->toArray() + [
                    'usuario_nombres' => $solicitud->user->usuario_nombres ?? null,
                    'usuario_apater' => $solicitud->user->usuario_apater ?? null,
                    'usuario_amater' => $solicitud->user->usuario_amater ?? null,
                    'usuario_email' => $solicitud->user->usuario_email ?? null,
                    'centro_labores' => $solicitud->user->centro_labores ?? null,
                    'nom_area' => $solicitud->user->puesto->area->nom_area ?? null,
                    'foto' => $solicitud->user->foto ?? null,
                    'num_doc' => $solicitud->user->num_doc ?? null,
                    'destino' => $solicitud->id_motivo == 1 || $solicitud->id_motivo == 2
                        ? ($solicitud->destino->nom_destino ?? $solicitud->destino)
                        : $solicitud->destino,
                    'tramite' => $solicitud->id_motivo == 1 || $solicitud->id_motivo == 2
                        ? ($solicitud->tramite->nom_tramite ?? $solicitud->tramite)
                        : $solicitud->tramite,
                    'fec_reg' => $solicitud->fec_reg,
                    'estado_solicitud' => $solicitud->estado_solicitud,
                ];
            });

        return $result->toArray();
    }

    public function get_list_papeletas_salida_uno()
    {
        $id_usuario = Session::get('id_usuario');

        // Construir la consulta usando Eloquent
        $solicitud = SolicitudUser::with([
            'user.puesto.area.subGerencia.gerencia', 
            'destino',
            'tramite'
        ])
            ->where('estado', 1) 
            ->where('estado_solicitud', 1) 
            ->where('id_solicitudes', 2) 
            ->where('id_usuario', $id_usuario) 
            ->orderBy('fec_reg', 'DESC')
            ->first(); 

        // Si no se encuentra la solicitud, retornar un array vacío
        if (!$solicitud) {
            return [];
        }

        // Formatear el resultado
        return [
            'id_solicitudes_user' => $solicitud->id_solicitudes_user,
            'usuario_nombres' => $solicitud->user->usuario_nombres ?? null,
            'usuario_apater' => $solicitud->user->usuario_apater ?? null,
            'usuario_amater' => $solicitud->user->usuario_amater ?? null,
            'usuario_email' => $solicitud->user->usuario_email ?? null,
            'nom_area' => $solicitud->user->puesto->area->nom_area ?? null,
            'foto' => $solicitud->user->foto ?? null,
            'num_doc' => $solicitud->user->num_doc ?? null,
            'destino' => $solicitud->id_motivo == 1 || $solicitud->id_motivo == 2
                ? ($solicitud->destino->nom_destino ?? $solicitud->destino)
                : $solicitud->destino,
            'tramite' => $solicitud->id_motivo == 1 || $solicitud->id_motivo == 2
                ? ($solicitud->tramite->nom_tramite ?? $solicitud->tramite)
                : $solicitud->tramite,
            'fec_reg' => $solicitud->fec_reg,
            'estado_solicitud' => $solicitud->estado_solicitud,
        ];
    }

    public function verificacion_papeletas()
    {
        // Usar la conexión definida en el modelo
        DB::connection($this->getConnectionName())->statement("CALL Papeletas_de_Salida(NULL)");
    }
}
