<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContactoEmergencia extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    // Define la tabla si no sigue la convención plural de Laravel
    protected $table = 'contacto_emergencia';

    // Define la clave primaria
    protected $primaryKey = 'id_contacto_emergencia';

    // Si la tabla tiene timestamps automáticos
    public $timestamps = false;

    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_usuario',
        'nom_contacto',
        'id_parentesco',
        'celular1',
        'celular2',
        'fijo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    static function get_list_contactoeuonlyuno($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from contacto_emergencia rf
                    LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
                    where rf.id_usuario =".$id_usuario." and rf.estado=1 limit 2";
        }else{
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from contacto_emergencia rf
            LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
            where rf.estado=1";
        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_contactoeu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from contacto_emergencia rf
                    LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from contacto_emergencia rf
            LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
            where rf.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_contactoe($id_contacto_emergencia=null){
        if(isset($id_contacto_emergencia) && $id_contacto_emergencia > 0){
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from contacto_emergencia rf
                    LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
                    where rf.id_contacto_emergencia =".$id_contacto_emergencia." and rf.estado=1";
        }else{
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from contacto_emergencia rf
            LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
            where rf.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
