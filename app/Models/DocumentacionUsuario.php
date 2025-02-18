<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentacionUsuario extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';
    protected $table = 'documentacion_usuario';

    public $timestamps = false;

    protected $primaryKey = 'id_documentacion_usuario';

    protected $fillable = [
        'id_usuario',
        'cv_doc',
        'dni_doc',
        'recibo_doc',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
