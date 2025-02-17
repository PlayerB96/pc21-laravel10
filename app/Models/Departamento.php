<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

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

    // Relación con Provincias
    public function provincias()
    {
        return $this->hasMany(Provincia::class, 'id_departamento');
    }

    // Relación con Distritos (a través de Provincia)
    public function distritos()
    {
        return $this->hasManyThrough(Distrito::class, Provincia::class, 'id_departamento', 'id_provincia');
    }
}
