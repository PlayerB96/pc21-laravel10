<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IclockTransaction extends Model
{
    protected $connection = 'zkbiotime'; // Conexión a la base de datos externa
    protected $table = 'iclock_transaction'; // Nombre de la tabla
    protected $primaryKey = 'id'; // Clave primaria
    public $timestamps = false; // Desactiva timestamps automáticos

    protected $fillable = [
        'emp_code',
        'punch_time',
        'punch_state',
        'verify_type',
        'work_code',
        'terminal_sn',
        'terminal_alias',
        'area_alias',
        'longitude',
        'latitude',
        'gps_location',
        'mobile',
        'source',
        'purpose',
        'crc',
        'is_attendance',
        'reserved',
        'upload_time',
        'sync_status',
        'sync_time',
        'emp_id',
        'terminal_id',
        'is_mask',
        'temperature'
    ];

    protected $dates = [
        'punch_time',
        'upload_time',
        'sync_time'
    ];
}
