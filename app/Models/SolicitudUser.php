<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class SolicitudUser extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'solicitudes_user'; // Nombre de la tabla
    protected $primaryKey = 'id_solicitudes_user'; // Clave primaria

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_usuario',
        'id_solicitudes',
        'estado_solicitud',
        'id_motivo',
        'destino',
        'tramite',
        'fec_reg',
        'user_reg',
        'estado',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_reg', 'id_usuario');
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
                return [
                    'id_solicitudes_user' => $solicitud->id_solicitudes_user,
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
            'user.puesto.area.subGerencia.gerencia', // Relaciones anidadas
            'destino',
            'tramite'
        ])
            ->where('estado', 1) // Filtro para estado = 1
            ->where('estado_solicitud', 1) // Filtro para estado_solicitud = 1
            ->where('id_solicitudes', 2) // Filtro para id_solicitudes = 2
            ->where('id_usuario', $id_usuario) // Filtro para el usuario en sesión
            ->orderBy('fec_reg', 'DESC') // Ordenar por fecha de registro descendente
            ->first(); // Obtener solo el primer registro

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
}
