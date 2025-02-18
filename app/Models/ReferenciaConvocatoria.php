<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ReferenciaConvocatoria extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';
    protected $table = 'referencia_convocatoria';
    protected $primaryKey = 'id_referencia_convocatoria';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_referencia_laboral',
        'otros',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
