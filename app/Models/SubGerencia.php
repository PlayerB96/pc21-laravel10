<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGerencia extends Model
{
    use HasFactory;

    // Conexión a la base de datos
    protected $connection = 'mysql_intranet';
    
    // Nombre de la tabla en la base de datos
    protected $table = 'sub_gerencia'; // Cambié 'sub_categoria' por 'sub_gerencia'

    // Definir la clave primaria
    protected $primaryKey = 'id_sub_gerencia'; // Actualicé la clave primaria a 'id_sub_gerencia'

    // Si la tabla usa auto-incremento
    public $incrementing = true;

    // Desactivar los timestamps automáticos si no se usan
    public $timestamps = false;

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'id_sub_gerencia',
        'id_gerencia', // Relacionado con la tabla 'gerencia'
        'nom_sub_gerencia', // Nombre de la subgerencia
        'estado', // Estado de la subgerencia
        'fec_reg', // Fecha de registro
        'user_reg', // Usuario que registró
        'fec_act', // Fecha de actualización
        'user_act', // Usuario que actualizó
        'fec_eli', // Fecha de eliminación
        'user_eli', // Usuario que eliminó
    ];

    // Relaciones (si es necesario, por ejemplo, con la tabla 'gerencia')

}
