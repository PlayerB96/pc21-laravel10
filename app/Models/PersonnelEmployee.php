<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonnelEmployee extends Model
{
    protected $connection = 'zkbiotime'; // Conexión a la base de datos externa
    protected $table = 'personnel_employee'; // Nombre de la tabla
    protected $primaryKey = 'id'; // Clave primaria
    public $timestamps = false; // Desactiva timestamps automáticos

    protected $fillable = [
        'create_time',
        'create_user',
        'change_time',
        'change_user',
        'status',
        'emp_code',
        'first_name',
        'last_name',
        'nickname',
        'passport',
        'driver_license_automobile',
        'driver_license_motorcycle',
        'photo',
        'self_password',
        'device_password',
        'dev_privilege',
        'card_no',
        'acc_group',
        'acc_timezone',
        'gender',
        'birthday',
        'address',
        'postcode',
        'office_tel',
        'contact_tel',
        'mobile',
        'national',
        'religion',
        'title',
        'enroll_sn',
        'ssn',
        'update_time',
        'hire_date',
        'verify_mode',
        'city',
        'is_admin',
        'emp_type',
        'enable_att',
        'enable_overtime',
        'enable_holiday',
        'deleted',
        'reserved',
        'del_tag',
        'app_status',
        'app_role',
        'email',
        'last_login',
        'is_active',
        'department_id',
        'position_id',
        'enable_payroll'
    ];

    protected $dates = [
        'create_time',
        'change_time',
        'update_time',
        'hire_date',
        'last_login'
    ];
}
