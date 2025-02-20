<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreguntaInduccion extends Model
{

    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'pregunta_induccion';  // Nombre correcto de la tabla

    protected $primaryKey = 'id_pregunta';  // Clave primaria personalizada

    public $timestamps = false;  // Deshabilita timestamps automáticos (created_at, updated_at)

    protected $fillable = [
        'pregunta',
        'orden',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function respuestas()
    {
        return $this->hasMany(RespuestaInduccion::class, 'id_pregunta', 'id_pregunta');
    }
}
