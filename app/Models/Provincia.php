<?php

// app/Models/Provincia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'provincia';
    protected $primaryKey = 'id_provincia';
    public $timestamps = false;

    protected $fillable = ['id_provincia', 'nombre_provincia', 'id_departamento', 'estado'];

    // Relación con Distrito
    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'id_provincia');
    }

    // Relación con Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }
}
