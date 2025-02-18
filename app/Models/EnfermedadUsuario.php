<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EnfermedadUsuario extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';
    protected $table = 'enfermedad_usuario';
    protected $primaryKey = 'id_enfermedad_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_respuestae',
        'nom_enfermedad',
        'dia_diagnostico',
        'mes_diagnostico',
        'anio_diagnostico',
        'fec_diagnostico',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
    
    static function get_list_enfermedadu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*
                    from enfermedad_usuario rf where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else{
            $sql = "SELECT rf.*
            from enfermedad_usuario rf where rf.estado=1";
        }
        
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_enfermedade($id_enfermedad_usuario=null){
        if(isset($id_enfermedad_usuario) && $id_enfermedad_usuario > 0){
            $sql = "SELECT rf.*
                from enfermedad_usuario rf where 
                rf.id_enfermedad_usuario =".$id_enfermedad_usuario." 
                and rf.estado=1";
        }else{
            $sql = "SELECT rf.*
                    from enfermedad_usuario rf where rf.estado=1";
        }
        
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
