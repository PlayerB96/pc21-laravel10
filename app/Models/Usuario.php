<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // Cambiar de 'usuarios' a 'users'

    protected $fillable = [
        'username', 
        'password', 
        'telefono', 
        'email', 
        'nombre_completo'
    ];
}
