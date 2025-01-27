<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'nivel';

    // Clave primaria
    protected $primaryKey = 'id_nivel';

    // Campos asignables masivamente
    protected $fillable = [
        'nom_nivel',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    // Campos de fecha (timestamps)
    protected $dates = [
        'fec_reg',
        'fec_act',
        'fec_eli',
    ];

    // Relación con el modelo Puesto
    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'id_nivel', 'id_nivel');
    }
}
