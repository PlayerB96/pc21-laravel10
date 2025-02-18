<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConociIdiomas extends Model
{
    use HasFactory;

    protected $connection = 'mysql_intranet';

    protected $table = 'conoci_idiomas';
    protected $primaryKey = 'id_conoci_idiomas';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nom_conoci_idiomas',
        'lect_conoci_idiomas',
        'escrit_conoci_idiomas',
        'conver_conoci_idiomas',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];


    static function get_list_idiomasu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, pl.id_nivel_instruccion as id_nivel_instruccionl, pl.nom_nivel_instruccion
                    as nom_nivel_instruccionl, pe.id_nivel_instruccion as id_nivel_instruccione,
                    pe.nom_nivel_instruccion as nom_nivel_instruccione, pc.id_nivel_instruccion as id_nivel_instruccionc,
                    pc.nom_nivel_instruccion as nom_nivel_instruccionc, i.id_idioma, i.nom_idioma
                    from conoci_idiomas rf
                    LEFT JOIN idioma i on i.id_idioma = rf.nom_conoci_idiomas
                    LEFT JOIN nivel_instruccion pl on pl.id_nivel_instruccion=rf.lect_conoci_idiomas
                    LEFT JOIN nivel_instruccion pe on pe.id_nivel_instruccion=rf.escrit_conoci_idiomas
                    LEFT JOIN nivel_instruccion pc on pc.id_nivel_instruccion=rf.conver_conoci_idiomas
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }else{
            $sql = "SELECT rf.*, pl.id_nivel_instruccion as id_nivel_instruccionl, pl.nom_nivel_instruccion
                    as nom_nivel_instruccionl, pe.id_nivel_instruccion as id_nivel_instruccione,
                    pe.nom_nivel_instruccion as nom_nivel_instruccione, pc.id_nivel_instruccion as id_nivel_instruccionc,
                    pc.nom_nivel_instruccion as nom_nivel_instruccionc, i.id_idioma, i.nom_idioma
                    from conoci_idiomas rf
                    LEFT JOIN idioma i on i.id_idioma = rf.nom_conoci_idiomas
                    LEFT JOIN nivel_instruccion pl on pl.id_nivel_instruccion=rf.lect_conoci_idiomas
                    LEFT JOIN nivel_instruccion pe on pe.id_nivel_instruccion=rf.escrit_conoci_idiomas
                    LEFT JOIN nivel_instruccion pc on pc.id_nivel_instruccion=rf.conver_conoci_idiomas
                    where rf.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_idiomase($id_conoci_idiomas=null){
        if(isset($id_conoci_idiomas) && $id_conoci_idiomas > 0){
            $sql = "SELECT rf.*, pl.id_nivel_instruccion as id_nivel_instruccionl, pl.nom_nivel_instruccion
                    as nom_nivel_instruccionl, pe.id_nivel_instruccion as id_nivel_instruccione,
                    pe.nom_nivel_instruccion as nom_nivel_instruccione, pc.id_nivel_instruccion as id_nivel_instruccionc,
                    pc.nom_nivel_instruccion as nom_nivel_instruccionc, i.id_idioma, i.nom_idioma
                    from conoci_idiomas rf
                    LEFT JOIN idioma i on i.id_idioma = rf.nom_conoci_idiomas
                    LEFT JOIN nivel_instruccion pl on pl.id_nivel_instruccion=rf.lect_conoci_idiomas
                    LEFT JOIN nivel_instruccion pe on pe.id_nivel_instruccion=rf.escrit_conoci_idiomas
                    LEFT JOIN nivel_instruccion pc on pc.id_nivel_instruccion=rf.conver_conoci_idiomas
                    where rf.id_conoci_idiomas =".$id_conoci_idiomas." and rf.estado=1";
        }else{
            $sql = "SELECT rf.*, pl.id_nivel_instruccion as id_nivel_instruccionl, pl.nom_nivel_instruccion
                    as nom_nivel_instruccionl, pe.id_nivel_instruccion as id_nivel_instruccione,
                    pe.nom_nivel_instruccion as nom_nivel_instruccione, pc.id_nivel_instruccion as id_nivel_instruccionc,
                    pc.nom_nivel_instruccion as nom_nivel_instruccionc, i.id_idioma, i.nom_idioma
                    from conoci_idiomas rf
                    LEFT JOIN idioma i on i.id_idioma = rf.nom_conoci_idiomas
                    LEFT JOIN nivel_instruccion pl on pl.id_nivel_instruccion=rf.lect_conoci_idiomas
                    LEFT JOIN nivel_instruccion pe on pe.id_nivel_instruccion=rf.escrit_conoci_idiomas
                    LEFT JOIN nivel_instruccion pc on pc.id_nivel_instruccion=rf.conver_conoci_idiomas
                    where rf.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
