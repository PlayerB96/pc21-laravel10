<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReferenciaFamiliar extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'referencia_familiar';
    protected $primaryKey = 'id_referencia_familiar';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nom_familiar',
        'id_parentesco',
        'dia_nac',
        'mes_nac',
        'anio_nac',
        'fec_nac',
        'celular1',
        'celular2',
        'fijo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    static function get_list_referenciafu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from referencia_familiar rf
                    LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }else{
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from referencia_familiar rf
            LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
            where rf.estado=1";
        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_referenciaf($id_referencia_familiar=null){
        if(isset($id_referencia_familiar) && $id_referencia_familiar > 0){
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from referencia_familiar rf
                    LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
                    where rf.id_referencia_familiar =".$id_referencia_familiar." and rf.estado=1";
        }else{
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from referencia_familiar rf
            LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
            where rf.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
