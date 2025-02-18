<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class SistPensUsuario extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';
    protected $table = 'sist_pens_usuario';
    protected $primaryKey = 'id_sist_pens_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_respuestasp',
        'id_sistema_pensionario',
        'id_afp',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}

