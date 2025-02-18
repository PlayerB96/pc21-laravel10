<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CursoComplementario extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'curso_complementario';
    protected $primaryKey = 'id_curso_complementario';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nom_curso_complementario',
        'anio',
        'certificado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    static function get_list_cursoscu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*
                    from curso_complementario rf where rf.id_usuario =".$id_usuario." and rf.estado=1";
       
        }else{
            $sql = "SELECT rf.*
                    from curso_complementario rf where rf.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
