<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIntranet extends Model
{
    use HasFactory;

    // Conexión a la base de datos externa
    protected $connection = 'mysql_intranet';

    protected $table = 'users';  // Nombre de la tabla en la base de datos externa

    protected $primaryKey = 'id_usuario';  // Clave primaria

    public $timestamps = false;  // Si no tienes columnas de timestamps como created_at y updated_at

    // Definimos todos los campos de la tabla 'users' de la base de datos externa
    protected $fillable = [
        'id_usuario',
        'id_centro_labor',
        'id_ubicacion',
        'usuario_nombres',
        'usuario_apater',
        'usuario_amater',
        'usuario_codigo',
        'usuario_password',
        'password_desencriptado',
        'id_nivel',
        'usuario_email',
        'emailp',
        'num_celp',
        'num_fijop',
        'num_cele',
        'num_fijoe',
        'num_anexoe',
        'directorio',
        'asistencia',
        'id_horario',
        'horas_semanales',
        'id_puesto',
        'id_cargo',
        'id_empresa',
        'id_empresapl',
        'id_regimen',
        'id_tipo_contrato',
        'id_tipo_documento',
        'num_doc',
        'fec_emision_doc',
        'fec_vencimiento_doc',
        'id_nacionalidad',
        'id_genero',
        'id_estado_civil',
        'urladm',
        'foto',
        'foto_nombre',
        'observaciones',
        'dia_nac',
        'mes_nac',
        'anio_nac',
        'fec_nac',
        'situacion',
        'centro_labores',
        'acceso',
        'verif_email',
        'ip_acceso',
        'enfermedades',
        'alergia',
        'hijos',
        'terminos',
        'id_situacion_laboral',
        'ini_funciones',
        'fin_funciones',
        'fec_ingreso',
        'fec_termino',
        'desvinculacion',
        'fec_reg_desv',
        'induccion',
        'nota_induccion',
        'datos_completos',
        'fec_reg_ind',
        'id_modalidad_laboral',
        'home_office',
        'domiciliado',
        'asignacion_familiar',
        'aporte_voluntario',
        'neto_uss',
        'id_banco_cts',
        'cuenta_cts',
        'id_banco_haberes',
        'cuenta_haberes',
        'id_tipo_trabajador',
        'id_sector_laboral',
        'id_nivel_educativo',
        'id_ocupacion',
        'id_cargo_trabajador',
        'id_sctr_salud',
        'id_sctr_pension',
        'id_situacion_trabajador',
        'fecha_cese',
        'fec_baja',
        'cancelar_baja',
        'id_motivo_baja',
        'observaciones_baja',
        'doc_baja',
        'fec_asignacionjr',
        'id_puestojr',
        'cancelar_asignacionjr',
        'estado_asignacioncv',
        'fec_asignacioncv',
        'fec_iniciocv',
        'fec_regvc',
        'cancelar_asignacioncv',
        'id_puestocv',
        'id_regimen_pensionario',
        'fecha_inscripcion',
        'cuspp_afp',
        'id_comision_afp',
        'regimen_a',
        'jornada_trabajo',
        'trabajo_nocturno',
        'discapacidad',
        'sindicalizado',
        'renta_quinta',
        'id_tipo_pago',
        'id_periocidad',
        'id_situacion_especial_trabajador',
        'afiliado_eps',
        'id_eps',
        'ingreso_quinta',
        'ruc_quinta',
        'razon_social_quinta',
        'renta_bruta_quinta',
        'retencion_renta_quinta',
        'trabajador',
        'pensionista',
        'servicio_cuarta',
        'servicio_mod',
        'terceros',
        'ruc_categoria',
        'gusto_personales',
        'edicion_perfil',
        'perf_revisado',
        'fec_edi_perfil',
        'user_edi_perfil',
        'fec_perf_revisado',
        'user_perf_revisado',
        'accesos_email',
        'motivo_renuncia',
        'correo_bienvenida',
        'documento',
        'cursos_complementarios',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    /**
     * Relación con el modelo `User` de la base de datos 'extranet'
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user_intranet', 'id_usuario');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'id_puesto');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_centro_labor', 'id_ubicacion');
    }

    public function permisoPapeletasSalida()
    {
        return $this->hasOne(PermisoPapeletasSalida::class, 'id_puesto_jefe', 'id_puesto')
            ->where('estado', 1);
    }
}
