<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class RopaUsuario extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';
    protected $table = 'ropa_usuario';

    protected $primaryKey = 'id_ropa_usuario';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'polo',
        'camisa',
        'pantalon',
        'zapato',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
