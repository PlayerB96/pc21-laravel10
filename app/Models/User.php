<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'user';  // Nombre de la tabla en la base de datos

    protected $primaryKey = 'id_user';  // Clave primaria

    public $timestamps = false;  // Si no tienes columnas de timestamps como created_at y updated_at

    protected $fillable = [
        'id_user_intranet',
        'last_login',
    ];

    /**
     * Relación con el modelo de la tabla `users` de la otra base de datos
     */
    public function externalUser()
    {
        return $this->hasOne(UserIntranet::class, 'id_usuario', 'id_user_intranet');
    }
}
