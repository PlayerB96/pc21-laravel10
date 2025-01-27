<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet'; // Conexión a la base de datos externa
    protected $table = 'destino'; // Nombre de la tabla
    protected $primaryKey = 'id_destino'; // Clave primaria

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_motivo',
        'nom_destino',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    // Relación con el modelo Tramite
    public function tramites()
    {
        return $this->hasMany(Tramite::class, 'id_destino', 'id_destino');
    }
}
