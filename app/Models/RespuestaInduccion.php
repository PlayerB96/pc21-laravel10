<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaInduccion extends Model
{
    protected $table = 'respuesta_induccion';  // Nombre correcto de la tabla

    protected $primaryKey = 'id_respuesta';  // Clave primaria personalizada

    public $timestamps = false;  // Deshabilita timestamps automáticos (created_at, updated_at)

    protected $fillable = [
        'id_pregunta',
        'desc_respuesta',
        'correcto',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    /**
     * Relación con la tabla PreguntaInduccion.
     */
    public function pregunta()
    {
        return $this->belongsTo(PreguntaInduccion::class, 'id_pregunta', 'id_pregunta');
    }
}
