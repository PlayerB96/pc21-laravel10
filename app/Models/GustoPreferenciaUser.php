<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GustoPreferenciaUser extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'gusto_preferencia_users';
    protected $primaryKey = 'id_gusto_preferencia_users';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'plato_postre',
        'galletas_golosinas',
        'ocio_pasatiempos',
        'artistas_banda',
        'genero_musical',
        'pelicula_serie',
        'colores_favorito',
        'redes_sociales',
        'deporte_favorito',
        'tiene_mascota',
        'mascota',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
