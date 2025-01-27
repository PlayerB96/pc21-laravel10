<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet'; // Conexión a la base de datos externa
    protected $table = 'tramite'; // Nombre de la tabla
    protected $primaryKey = 'id_tramite'; // Clave primaria

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_destino',
        'nom_tramite',
        'cantidad_uso',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    // Relación con el modelo Destino
    public function destino()
    {
        return $this->belongsTo(Destino::class, 'id_destino', 'id_destino');
    }
}
