<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'departamento';

    // Clave primaria
    protected $primaryKey = 'id_departamento';

    // Indicar que la clave primaria no es autoincremental
    public $incrementing = false;

    // Tipo de la clave primaria
    protected $keyType = 'string';

    // Campos asignables masivamente
    protected $fillable = [
        'id_departamento',
        'nombre_departamento',
        'estado',
    ];

    // Campos de fecha (timestamps)
    protected $dates = [
        'fec_reg',
        'fec_act',
        'fec_eli',
    ];

    // Relación con el modelo Area
    public function areas()
    {
        return $this->hasMany(Area::class, 'id_departamento', 'id_departamento');
    }
}
