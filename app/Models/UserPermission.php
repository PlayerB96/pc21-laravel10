<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet'; 
    protected $table = 'user_permission'; 
    protected $primaryKey = 'id_user_permission'; 
    public $timestamps = false; 

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'id_permission',
        'id_puesto',
        'id_area',
        'id_nivel',
        'id_sub_gerencia',
    ];

    // Relación con la tabla de permisos
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'id_permission');
    }
}
