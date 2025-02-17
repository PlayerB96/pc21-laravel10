<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DomicilioUser extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet'; // Conexión a la base de datos externa

    protected $table = 'domicilio_users';
    protected $primaryKey = 'id_domicilio_users';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_departamento',
        'id_provincia',
        'id_distrito',
        'id_tipo_via',
        'nom_via',
        'num_via',
        'kilometro',
        'manzana',
        'lote',
        'interior',
        'departamento',
        'piso',
        'id_zona',
        'nom_zona',
        'referencia',
        'id_tipo_vivienda',
        'lat',
        'lng',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function getIdDomicilioUsers($id_usuario)
    {
        $query = DomicilioUser::query()
            ->select([
                'domicilio_users.*',
                'de.nombre_departamento',
                'pro.nombre_provincia',
                'di.nombre_distrito',
                'ti.nom_tipo_via',
                'tip.nom_tipo_vivienda',
                DB::raw("CONCAT(
                    CASE WHEN domicilio_users.id_tipo_via != 0 AND domicilio_users.id_tipo_via != 21 
                        THEN CONCAT(ti.nom_tipo_via, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.nom_via NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN CONCAT(domicilio_users.nom_via, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.num_via NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN CONCAT(domicilio_users.num_via, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.kilometro NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN CONCAT('KM ', domicilio_users.kilometro, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.manzana NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN CONCAT('MZ ', domicilio_users.manzana, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.lote NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN CONCAT('LT ', domicilio_users.lote, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.interior NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN CONCAT('INT ', domicilio_users.interior, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.departamento NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN CONCAT('DPTO ', domicilio_users.departamento, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.piso NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN CONCAT('Piso ', domicilio_users.piso, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.id_zona != 0 AND domicilio_users.id_zona != 11 
                        THEN CONCAT(zo.nom_zona, ' ') ELSE '' END,
                    CASE WHEN domicilio_users.nom_zona NOT IN ('', 'NO', 'No', 'no', '-', '.') 
                        THEN domicilio_users.nom_zona ELSE '' END
                ) AS direccion_completa")
            ])
            ->leftJoin('departamento as de', 'de.id_departamento', '=', 'domicilio_users.id_departamento')
            ->leftJoin('provincia as pro', 'pro.id_provincia', '=', 'domicilio_users.id_provincia')
            ->leftJoin('distrito as di', 'di.id_distrito', '=', 'domicilio_users.id_distrito')
            ->leftJoin('tipo_via as ti', 'ti.id_tipo_via', '=', 'domicilio_users.id_tipo_via')
            ->leftJoin('tipo_vivienda as tip', 'tip.id_tipo_vivienda', '=', 'domicilio_users.id_tipo_vivienda')
            ->leftJoin('zona as zo', 'zo.id_zona', '=', 'domicilio_users.id_zona');

        if (!is_null($id_usuario) && $id_usuario > 0) {
            $query->where('domicilio_users.id_usuario', $id_usuario);
        }

        return $query->get()->toArray(); // ✅ Retorna un array
    }
}
