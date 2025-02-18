<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExperienciaLaboral extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'experiencia_laboral';
    protected $primaryKey = 'id_experiencia_laboral';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'empresa',
        'cargo',
        'dia_ini',
        'mes_ini',
        'anio_ini',
        'fec_ini',
        'actualidad',
        'dia_fin',
        'mes_fin',
        'anio_fin',
        'fec_fin',
        'motivo_salida',
        'remuneracion',
        'nom_referencia_labores',
        'num_contacto',
        'certificado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    static function get_list_experiencial($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*
                    from experiencia_laboral rf where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.* from experiencia_laboral rf where rf.estado=1";
            //"SELECT rf.* from experiencia_laboral rf where rf.id_usuario =".$id_usuario." and rf.estado=1";;
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_experienciale($id_experiencia_laboral=null,$id_usuario=null){
        if(isset($id_experiencia_laboral) && $id_experiencia_laboral > 0){
            $sql = "SELECT rf.*
                    from experiencia_laboral rf where rf.id_experiencia_laboral =".$id_experiencia_laboral." 
                    and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.* from experiencia_laboral rf where rf.estado=1";

        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
