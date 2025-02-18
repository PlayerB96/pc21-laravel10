<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hijos extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'hijos';
    protected $primaryKey = 'id_hijos';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nom_hijo',
        'id_genero',
        'dia_nac',
        'mes_nac',
        'anio_nac',
        'fec_nac',
        'num_doc',
        'id_biologico',
        'documento',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    static function get_list_hijosu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_genero, p.nom_genero from hijos rf
                    LEFT JOIN genero p on p.id_genero=rf.id_genero
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_genero, p.nom_genero from hijos rf
            LEFT JOIN genero p on p.id_genero=rf.id_genero
            where rf.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_hijosd($id_hijos=null){
        if(isset($id_hijos) && $id_hijos > 0){
            $sql = "SELECT rf.*, p.id_genero, p.nom_genero, u.hijos
                    from hijos rf
        LEFT JOIN users u on u.id_usuario=rf.id_usuario
        LEFT JOIN genero p on p.id_genero=rf.id_genero
        where rf.id_hijos =".$id_hijos." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_genero, p.nom_genero from hijos rf
            LEFT JOIN genero p on p.id_genero=rf.id_genero
            where rf.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
