<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Usuario extends Model
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
