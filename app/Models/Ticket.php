<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue la convención de Laravel (en este caso, se asume 'tickets')
    protected $table = 'tickets';

    // Si no usas los campos 'created_at' y 'updated_at', desactívalos
    public $timestamps = true;

    // Asegúrate de agregar los campos que serán asignables masivamente (si es necesario)
    protected $fillable = ['nombre_solicitante','telefono', 'estado', 'fecha_registro', 'numero_ticket'];

    // Puedes agregar relaciones o métodos si lo necesitas
}
