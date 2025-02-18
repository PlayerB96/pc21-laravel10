<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'cuenta_bancaria'; // Specify the table name if it's not pluralized

    protected $primaryKey = 'id_cuenta_bancaria'; // Specify the primary key

    public $timestamps = false; // Disable timestamps if you're managing them manually

    protected $fillable = [
        'id_usuario',
        'id_banco',
        'cuenta_bancaria',
        'num_cuenta_bancaria',
        'num_codigo_interbancario',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}
