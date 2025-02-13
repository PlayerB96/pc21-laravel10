<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet'; 
    protected $table = 'permission'; 
    protected $primaryKey = 'id_permission'; 
    public $timestamps = false; 

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'name_permission',
    ];

    // Relación con UserPermission (Un permiso puede estar en muchos UserPermission)
    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class, 'id_permission');
    }
}
