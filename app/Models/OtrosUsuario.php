<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class OtrosUsuario extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'otros_usuario'; // Nombre de la tabla

    protected $primaryKey = 'id_otros_usuario'; // Clave primaria

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_grupo_sanguineo',
        'cert_covid',
        'cert_vacu_covid',
        'estado',
        'user_reg',
        'user_act',
        'user_eli',
    ];

}
