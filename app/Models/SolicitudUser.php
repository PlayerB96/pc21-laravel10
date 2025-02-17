<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

    // METODOS

    public function verificacion_papeletas()
    {
        // Usar la conexión definida en el modelo
        DB::connection($this->getConnectionName())->statement("CALL Papeletas_de_Salida(NULL)");
    }

    public static function aprobado_papeletas_salida($dato, $id_usuario)
    {
        // $id_usuario = session('usuario')->id_usuario;
        if ($dato['id_motivo'] == 2) {
            throw new \Exception("No se puede aprobar la papeleta con motivo 2");
        } else {
            $solicitud = self::findOrFail($dato['id_solicitudes_user']);
            // Actualizar solicitud base
            $solicitud->update([
                'estado_solicitud' => 2
            ]);

            if ($dato['id_modalidad_laboral'] == 3) {
                // Actualizar con horarios si modalidad es 3
                $solicitud->update([
                    'estado_solicitud' => 2,
                    'horar_salida' => $solicitud->hora_salida,
                    'horar_retorno' => $solicitud->hora_retorno,
                    'fec_act' => Carbon::now(),
                    'user_act' => $id_usuario,
                    'fec_apro' => Carbon::now(),
                    'user_aprob' => $id_usuario,
                ]);
            } else {
                // Condición para 'sin_ingreso'
                $horarioSalida = $dato['sin_ingreso'] == 1 ? '08:00:00' : $solicitud->horar_salida;
                $solicitud->update([
                    'estado_solicitud' => 2,
                    'fec_act' => Carbon::now(),
                    'user_act' => $id_usuario,
                    'fec_apro' => Carbon::now(),
                    'user_aprob' => $id_usuario,
                    'horar_salida' => $horarioSalida
                ]);
            }

            // Insertar en `iclock_transaction` si hay horarios
            if (!empty($dato['horario']) && $dato['sin_ingreso'] == 1) {
                IclockTransaction::create([
                    'emp_code' => $dato['num_doc'],
                    'punch_time' => Carbon::now()->format('Y-m-d') . " " . $dato['horario'][0]['hora_entrada'],
                    'punch_state' => 0,
                    'verify_type' => 1,
                    'source' => 1,
                    'purpose' => 9,
                    'upload_time' => Carbon::now(),
                    'emp_id' => PersonnelEmployee::whereRaw("LPAD(emp_code, 8, '0') = ?", [$dato['num_doc']])->value('id'),
                    'is_mask' => 255,
                    'temperature' => 255.0,
                    'work_code' => 'PAPELETA SIN INGRESO'
                ]);
            }

            if (!empty($dato['horario']) && $dato['sin_retorno'] == 1) {
                IclockTransaction::create([
                    'emp_code' => $dato['num_doc'],
                    'punch_time' => Carbon::now()->format('Y-m-d') . " " . $dato['horario'][0]['hora_salida'],
                    'punch_state' => 0,
                    'verify_type' => 1,
                    'source' => 1,
                    'purpose' => 9,
                    'upload_time' => Carbon::now(),
                    'emp_id' => PersonnelEmployee::whereRaw("LPAD(emp_code, 8, '0') = ?", [$dato['num_doc']])->value('id'),
                    'is_mask' => 255,
                    'temperature' => 255.0,
                    'work_code' => 'PAPELETA SIN RETORNO'
                ]);
            }
        }
    }

    public function get_list_papeletas_salida_gestion($estado_solicitud, $id_nivel, $id_puesto, $cod_ubi, $fecha_revision, $fecha_revision_fin)
    {
        // Construcción de condiciones dinámicas
        $query = SolicitudUser::with(['user', 'user.puesto.area', 'destino', 'tramite'])
            ->whereIn('estado', [1, 3]);

        // Filtro por estado de solicitud
        if ($estado_solicitud == 0) {
            $query->whereIn('estado_solicitud', [1, 2, 3, 4, 5]);
        } else {
            if ($estado_solicitud == 1) {
                if ($id_puesto == 21 || $id_puesto == 279) {
                    $query->whereIn('estado_solicitud', [5]);
                } elseif ($id_nivel == 1 || $id_puesto == 19) {
                    $query->whereIn('estado_solicitud', [1, 4, 5]);
                } else {
                    $query->whereIn('estado_solicitud', [1, 4]);
                }
            } else {
                if (isset($estado_solicitud)) {
                    $query->where('estado_solicitud', $estado_solicitud);
                }
            }
        }

        // Filtro por puesto y nivel
        switch ($id_puesto) {
            case 19:
            case 23:
                // No se agregan filtros adicionales
                break;
            case 10:
                $query->whereHas('user.puesto.area', function ($q) {
                    $q->where('id_area', 17);
                })->where('id_motivo', 1);
                break;
            case 93:
                $query->whereHas('user', function ($q) {
                    $q->where('id_puesto', 11);
                })->where('id_motivo', 1);
                break;
            default:
                if ($id_nivel == 1) {
                    $query->where('cod_base', $cod_ubi);
                } else {
                    $query->where('cod_base', $cod_ubi);
                }
                break;
        }

        // Manejo de fechas
        if (!empty($fecha_revision) && !empty($fecha_revision_fin)) {
            $query->whereBetween('fec_solicitud', [$fecha_revision, $fecha_revision_fin]);
        }

        // Obtener la consulta generada y los bindings
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        // Reemplazar los placeholders con los valores de los bindings
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'$binding'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        // Log de la consulta generada con los valores
        // Log::info('Consulta generada con valores:', ['query' => $sql]);
        // Seleccionar los campos necesarios
        $result = $query->orderBy('fec_reg', 'DESC')->get()->map(function ($solicitud) {
            return $solicitud->toArray() + [
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
                'estado_solicitud' => $solicitud->estado_solicitud,

            ];
        });

        return $result->toArray();
    }
}
