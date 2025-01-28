<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoPapeletasSalida extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'permiso_papeletas_salida';

    protected $primaryKey = 'id_permiso_papeletas_salida';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto_permitido',
        'id_puesto_jefe',
        'registro_masivo',
        'estado',
        'user_reg',
        'fec_reg',
        'user_act',
        'fec_act',
        'user_eli',
        'fec_eli',
    ];

    protected $casts = [
        'fec_reg' => 'datetime',
        'fec_act' => 'datetime',
        'fec_eli' => 'datetime',
    ];

    public function permiso_pps_puestos_gest_dinamico()
    {
        // Obtener el id_puesto desde la sesión
        $id_puesto = session('usuario')->id_puesto;
        // Obtener los puestos permitidos relacionados con el id_puesto_jefe
        $result = PermisoPapeletasSalida::where('estado', '1')
            ->where('id_puesto_jefe', $id_puesto)
            ->join('puesto as p', 'p.id_puesto', '=', 'permiso_papeletas_salida.id_puesto_permitido')
            ->select('permiso_papeletas_salida.id_puesto_permitido')
            ->get();

        // Convertir el resultado a un array y devolverlo
        return $result->toArray();
    }
}
