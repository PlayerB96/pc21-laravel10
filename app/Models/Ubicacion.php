<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet'; 
    protected $table = 'ubicacion'; 
    protected $primaryKey = 'id_ubicacion'; 
    public $timestamps = false; 
    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'cod_ubi',
        'id_sede',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];



}
