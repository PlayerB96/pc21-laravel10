<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    // Nombre de la tabla
    protected $table = 'area';

    // Clave primaria
    protected $primaryKey = 'id_area';

    // Campos asignables masivamente
    protected $fillable = [
        'cod_area',
        'nom_area',
        'id_departamento',
        'puestos',
        'orden',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
        'id_base',
    ];

    // Campos de fecha (timestamps)
    protected $dates = [
        'fec_reg',
        'fec_act',
        'fec_eli',
    ];

    // Relación con el modelo Departamento (si existe)
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    // Relación con el modelo Puesto
    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'id_area', 'id_area');
    }

    public function subGerencia()
    {
        return $this->belongsTo(SubGerencia::class, 'id_departamento', 'id_sub_gerencia');
    }
}
