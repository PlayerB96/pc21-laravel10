<?php
// app/Models/Distrito.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'distrito';
    protected $primaryKey = 'id_distrito';
    public $timestamps = false;

    protected $fillable = ['id_distrito', 'nombre_distrito', 'id_provincia', 'id_departamento', 'estado'];

    // Relación con Provincia
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'id_provincia');
    }

    // Relación con Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }
}
