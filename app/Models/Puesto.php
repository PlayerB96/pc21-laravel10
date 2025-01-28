<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    // Nombre de la tabla
    protected $table = 'puesto';

    // Clave primaria
    protected $primaryKey = 'id_puesto';

    // Campos asignables masivamente
    protected $fillable = [
        'nom_puesto',
        'id_area',
        'proposito',
        'id_nivel',
        'perfil_infosap',
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

    // Relación con el modelo Area
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }

    // Relación con el modelo Nivel (si existe)
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'id_nivel', 'id_nivel');
    }
}
