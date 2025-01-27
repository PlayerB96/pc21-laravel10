<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoPapeletasSalida extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'permiso_papeletas_salida';

    protected $primaryKey = 'id_permiso_papeletas_salida';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto_permitido',
        'id_puesto_jefe',
        'registro_masivo',
        'estado',
        'user_reg',
        'fec_reg',
        'user_act',
        'fec_act',
        'user_eli',
        'fec_eli',
    ];

    protected $casts = [
        'fec_reg' => 'datetime',
        'fec_act' => 'datetime',
        'fec_eli' => 'datetime',
    ];
}
