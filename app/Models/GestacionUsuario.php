<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class GestacionUsuario extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet';
    protected $table = 'gestacion_usuario';

    protected $primaryKey = 'id_gestacion_usuario';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_respuesta',
        'dia_ges',
        'mes_ges',
        'anio_ges',
        'fec_ges',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    
}
