<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AlergiaUsuario extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet';
    protected $table = 'alergia_usuario';
    protected $primaryKey = 'id_alergia_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_respuestaau',
        'nom_alergia',
        'estado',
        'user_reg',
        'user_act',
        'user_eli',
    ];
    
    static function get_list_alergia($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT u.alergia, a.* FROM users u
                    LEFT JOIN alergia_usuario a on u.id_usuario=a.id_usuario
                    where u.id_usuario =".$id_usuario." and a.estado=1";
        }else{
            $sql = "SELECT u.alergia, a.* FROM users u
                    LEFT JOIN alergia_usuario a on u.id_usuario=a.id_usuario
                    where a.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

}
