<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anio extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet';
    protected $table = 'anio';
    protected $primaryKey = 'id_anio';

    public $timestamps = false;

    protected $fillable = [
        'id_anio',
        'cod_anio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
