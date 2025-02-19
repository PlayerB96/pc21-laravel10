<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudUser;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Distrito;
use App\Models\PermisoPapeletasSalida;
use App\Models\Destino;
use App\Models\Tramite;
use App\Models\UserIntranet;
use App\Models\DomicilioUser;
use App\Models\GustoPreferenciaUser;
use App\Models\ReferenciaFamiliar;
use App\Models\ContactoEmergencia;
use App\Models\Hijos;
use App\Models\ConociOffice;
use App\Models\ConociIdiomas;
use App\Models\CursoComplementario;
use App\Models\ExperienciaLaboral;
use App\Models\EnfermedadUsuario;
use App\Models\GestacionUsuario;
use App\Models\AlergiaUsuario;
use App\Models\OtrosUsuario;
use App\Models\ReferenciaConvocatoria;
use App\Models\DocumentacionUsuario;
use App\Models\RopaUsuario;
use App\Models\SistPensUsuario;
use App\Models\CuentaBancaria;

use Illuminate\Support\Facades\Log;

class GestionPersonas extends Controller
{
    protected $Model_Solicitudes;
    protected $Model_Permiso;


    public function __construct(SolicitudUser $Model_Solicitudes, PermisoPapeletasSalida $Model_Permiso)
    {
        $this->Model_Solicitudes = $Model_Solicitudes;
        $this->Model_Permiso = $Model_Permiso;
    }


    public function index()
    {
        return view('gestionpersonas.gestionpersonas');
    }



    public function buscar_papeletas(Request $request)
    {

        $estado_solicitud = $request->estado_solicitud;
        $id_nivel = $request->id_nivel;
        $id_puesto = $request->id_puesto;
        $cod_ubi = $request->cod_ubi;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;

        $this->Model_Solicitudes->verificacion_papeletas();
        // $list_papeletas_salida = $this->Model_Solicitudes->get_list_papeletas_salida($estado_solicitud, $id_usuario);
        $list_papeletas_salida = $this->Model_Solicitudes->get_list_papeletas_salida_gestion($estado_solicitud, $id_nivel, $id_puesto, $cod_ubi, $fecha_inicio, $fecha_fin);
        // Log::error('list_papeletas_salida:',$list_papeletas_salida);

        // Retornar los datos en formato JSON
        return response()->json([
            'list_papeletas_salida' => $list_papeletas_salida
        ]);
    }

    public function cambiar_motivo(Request $request)
    {
        $motivo = $request->query('motivo');
        $destinos = Destino::where('id_motivo', $motivo)->get(['id_destino as id', 'nom_destino as nombre']);
        return response()->json($destinos);
    }

    public function traer_tramite(Request $request)
    {
        $id_destino = $request->query('id_destino');
        $tramites = Tramite::where('id_destino', $id_destino)->get(['id_tramite as id', 'nom_tramite as nombre']);
        return response()->json($tramites);
    }


    public function store(Request $request)
    {
        $request->validate([
            'cod_ubi' => 'required',
            'id_usuario' => 'required',
            'id_gerencia' => 'required',
            'formulario.fec_solicitud' => 'required',
            'formulario.id_motivo' => 'required',
            'formulario.destino' => 'required',
            'formulario.tramite' => 'required',
            'formulario.especificacion_destino' => 'required',
            'formulario.especificacion_tramite' => 'required',
        ]);
        $cod_ubi = $request->cod_ubi;
        $id_usuario = $request->id_usuario;
        $id_gerencia = $request->id_gerencia;
        $form = $request->formulario;

        // GENERAR cod_solicitud
        $totalt = $this->Model_Solicitudes::where('id_solicitudes', 2)
            ->whereRaw("SUBSTR(cod_solicitud, 3, 4) = ?", [date('Y')])
            ->count();
        $aniof = date('Y');
        if ($totalt < 9) {
            $codigofinal = 'PP' . $aniof . "0000" . ($totalt + 1);
        } elseif ($totalt > 8 && $totalt < 99) {
            $codigofinal = 'PP' . $aniof . "000" . ($totalt + 1);
        } elseif ($totalt > 98 && $totalt < 999) {
            $codigofinal = 'PP' . $aniof . "00" . ($totalt + 1);
        } elseif ($totalt > 998 && $totalt < 9999) {
            $codigofinal = 'PP' . $aniof . "0" . ($totalt + 1);
        } else {
            $codigofinal = 'PP' . $aniof . ($totalt + 1);
        }

        // ASIGNAR ESTADO DE LA SOLICITUD EN BASE AL MOTIVO
        $estado_solicitud = $request['id_motivo'] == 1 ? 2 : 4;

        // Asignamos los datos a un arreglo para insertar
        $data = [
            'dif_dias' => 0.0,
            'user_horar_salida' => 0,
            'user_horar_entrada' => 0,
            'user_aprob' => 0,
            'mediodia' => 0,
            'observacion' => '0',
            'id_usuario' => $id_usuario,
            'id_solicitudes' => 2,
            'cod_solicitud' => $codigofinal,
            'cod_base' => $cod_ubi,
            'fec_solicitud' => $form['fec_solicitud'],
            'id_gerencia' => $id_gerencia,
            'hora_salida' => $form['hora_salida'],
            'hora_retorno' => $form['hora_retorno'],
            'id_motivo' => $form['id_motivo'],
            'motivo' => '',
            'destino' => $form['destino'],
            'tramite' => $form['tramite'],
            'especificacion_destino' => $form['especificacion_destino'],
            'especificacion_tramite' => $form['especificacion_tramite'],
            'estado_solicitud' => $estado_solicitud,
            'sin_ingreso' => $form['sin_ingreso'] ?: 0,
            'sin_retorno' => $form['sin_retorno'] ?: 0,
            'fec_reg' => now(),
            'user_reg' => $id_usuario,  // Aquí usas el id_usuario
            'estado' => 1,
            'fec_act' => now(),
            'user_act' => $id_usuario, // Usamos el id_usuario para el cambio
        ];
        SolicitudUser::create($data);
    }

    public function aprobado_papeletas_salida(Request $request)
    {
        try {
            $id_solicitudes_user = $request->id_solicitudes_user;
            $id_usuario = $request->id_usuario;
            $solicitud = SolicitudUser::findOrFail($id_solicitudes_user);
            $dato = [
                'id_solicitudes_user' => $solicitud->id_solicitudes_user,
                'id_motivo' => $solicitud->id_motivo,
                'id_modalidad_laboral' => $solicitud->user->id_modalidad_laboral,
                'sin_ingreso' => $solicitud->sin_ingreso,
                'sin_retorno' => $solicitud->sin_retorno,
                'num_doc' => $solicitud->user->num_doc,
                'horario' => [
                    [
                        'hora_entrada' => $solicitud->hora_salida,
                        'hora_salida' => $solicitud->hora_retorno
                    ]
                ]
            ];
            SolicitudUser::aprobado_papeletas_salida($dato, $id_usuario);
            return response()->json(['message' => 'Papeleta aprobada exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al aprobar papeleta.', 'error' => $e->getMessage()], 400);
        }
    }



    public function store_colaborador(Request $request)
    {
        $formulario = json_decode($request->input('formulario'), true);

        $request->id_usuario;
        $id_usuario = 1611;
        if ($formulario['personalInfo']['fecha_nacimiento']) {
            // Asegurar que la fecha tiene el formato correcto
            $timestamp = strtotime($formulario['personalInfo']['fecha_nacimiento']);
            $dia_nac = date('d', $timestamp);
            $mes_nac = date('m', $timestamp);
            $anio_nac = date('Y', $timestamp);
        }

        // // ✅ Actualizar los datos en UserIntranet
        UserIntranet::where('id_usuario', $request->id_usuario)->update([
            'usuario_apater' => addslashes($formulario['personalInfo']['apellido_paterno']),
            'usuario_amater' => addslashes($formulario['personalInfo']['apellido_materno']),
            'usuario_nombres' => addslashes($formulario['personalInfo']['nombres']),
            'id_nacionalidad' => $formulario['personalInfo']['nacionalidad'],
            'id_estado_civil' => $formulario['personalInfo']['estado_civil'],
            'fec_nac' => $formulario['personalInfo']['fecha_nacimiento'],
            'dia_nac' => $dia_nac ?? '00',
            'mes_nac' => $mes_nac ?? '00',
            'anio_nac' => $anio_nac ?? '0000',
            'id_genero' => $formulario['personalInfo']['genero'],
            'id_tipo_documento' => $formulario['personalInfo']['tipo_documento'],
            'num_doc' => $formulario['personalInfo']['numero_documento'],
            'usuario_email' => $formulario['personalInfo']['correo'],
            'num_celp' => $formulario['personalInfo']['celular'],
            'num_fijop' => $personalInfo['telefono'] ?? null,
            'fec_act' => now(),
            'user_act' => $id_usuario,
        ]);

        // ✅ Actualizar los datos en DomicilioUser
        $domicilioData = [
            'id_usuario' => $id_usuario,
            'id_departamento' => $formulario['domicilio']['id_departamento'],
            'id_provincia' => $formulario['domicilio']['id_provincia'],
            'id_distrito' => $formulario['domicilio']['id_distrito'],
            'id_tipo_via' => $formulario['domicilio']['tipo_via'],
            'nom_via' => $formulario['domicilio']['nombre_via'],
            'num_via' => $formulario['domicilio']['numero_via'],
            'id_zona' => $formulario['domicilio']['tipo_zona'],
            'nom_zona' => $formulario['domicilio']['nombre_zona'],
            'referencia' => $formulario['domicilio']['referencia_domicilio'],
            'kilometro' => $formulario['domicilio']['km'],
            'manzana' => $formulario['domicilio']['mz'],
            'lote' => $formulario['domicilio']['lote'],
            'interior' => $formulario['domicilio']['interior'],
            'departamento' => $formulario['domicilio']['numero_departamento'],
            'piso' => $formulario['domicilio']['piso'],
            'id_tipo_vivienda' => $formulario['domicilio']['tipo_vivienda'],
            //     'lat' => $domicilio['lat'],
            //     'lng' => $domicilio['lng'],
        ];

        $domicilioData['user_act'] = $domicilioData['user_reg'] = $id_usuario;
        $domicilioData['fec_act'] = now();
        $domicilioData['fec_reg'] = now();
        $domicilioData['estado'] = 1;
        DomicilioUser::create($domicilioData);

        // ✅ Actualizar los datos en GustoPreferenciaUser
        $gustosPreferenciasData = [
            'plato_postre' => addslashes($formulario['gustosPreferencias']['plato_postre_favorito']),
            'galletas_golosinas' => addslashes($formulario['gustosPreferencias']['galletas_golosinas_favoritas']),
            'ocio_pasatiempos' => addslashes($formulario['gustosPreferencias']['actividades_ocio']),
            'artistas_banda' => addslashes($formulario['gustosPreferencias']['artistas_banda_favorita']),
            'genero_musical' => addslashes($formulario['gustosPreferencias']['genero_musical_favorito']),
            'pelicula_serie' => addslashes($formulario['gustosPreferencias']['pelicula_serie_favorita']),
            'colores_favorito' => addslashes($formulario['gustosPreferencias']['colores_favoritos']),
            'redes_sociales' => addslashes($formulario['gustosPreferencias']['redes_sociales_favoritas']),
            'deporte_favorito' => addslashes($formulario['gustosPreferencias']['deporte_favorito']),
            'tiene_mascota' => $formulario['gustosPreferencias']['tiene_mascota'],
            'mascota' => addslashes($formulario['gustosPreferencias']['tipo_mascota']),
            'fec_act' => now(),
            'user_act' => $id_usuario,
        ];

        $updateData = GustoPreferenciaUser::where('id_usuario', $id_usuario)
            ->where('estado', 1)
            ->exists();

        if ($updateData) {
            GustoPreferenciaUser::where('id_usuario', $id_usuario)
                ->update($gustosPreferenciasData);
        } else {
            GustoPreferenciaUser::create([
                'id_usuario' => $id_usuario,
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'estado' => 1,
            ] + $gustosPreferenciasData); // Merge both arrays for insert
        }

        // ✅ Actualizar los datos en ReferenciaFamiliar
        foreach ($formulario['referenciasFamiliares'] as $referencia) {
            if ($referencia['fecha_nacimiento_ref']) {
                // Asegurar que la fecha tiene el formato correcto
                $timestamp = strtotime($referencia['fecha_nacimiento_ref']);
                $dia_nac = date('d', $timestamp);
                $mes_nac = date('m', $timestamp);
                $anio_nac = date('Y', $timestamp);
            }
            ReferenciaFamiliar::create([
                'id_usuario' => $id_usuario,
                'nom_familiar' => $referencia['nombre_familiar'] ?? null,
                'id_parentesco' => $referencia['parentesco'] ?? null,
                'dia_nac' => $dia_nac ?? '00',
                'mes_nac' => $mes_nac ?? '00',
                'anio_nac' => $anio_nac ?? '0000',
                'celular1' => $referencia['celular_ref'] ?? null,
                'celular2' => $referencia['celular_ref2'] ?? null,
                'fijo' => $referencia['telefono_fijo'] ?? null,
                'fec_nac' => $referencia['fecha_nacimiento_ref'] ?? null,
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'estado' => 1
            ]);
        }


        // ✅ Actualizar los datos en Hijos Y UserIntranet
        Log::info("Archivo subido formulario hijos: " . json_encode($formulario['hijos']));

        try {
            $hijos = $formulario['hijos'] ?? [];
            $id_usuario = $request->input('id_usuario', 1611);
            $archivosSubidos = [];

            // 🔹 Conectar al servidor FTP
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";

            $con_id = ftp_connect($ftp_server);
            if (!$con_id) {
                return response()->json(['error' => 'No se pudo conectar al servidor FTP'], 500);
            }
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if (!$lr) {
                ftp_close($con_id);
                return response()->json(['error' => 'Error en la autenticación FTP'], 500);
            }
            ftp_pasv($con_id, true);

            // 🔹 Si no hay hijos, solo actualiza UserIntranet y detiene el proceso
            if (empty($hijos)) {
                UserIntranet::where('id_usuario', $id_usuario)
                    ->update([
                        'hijos' => 0,  // Si no hay hijos, se guarda como 0
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);

                ftp_close($con_id);
                // return response()->json(['message' => 'Formulario procesado sin hijos'], 200);
            }

            // 🔹 Procesar cada hijo y subir su archivo
            foreach ($hijos as $index => &$hijo) {
                if ($request->hasFile("dni_file_{$index}")) {
                    $file = $request->file("dni_file_{$index}");
                    if ($file->isValid()) {
                        $source_file = $file->getPathname();
                        $extension = $file->getClientOriginalExtension();
                        $fechaHoraActual = date('Y-m-dHis');
                        $codigoUnico = strtoupper(bin2hex(random_bytes(10)));
                        $nombre = "dochijo_" . ($hijo['id_hijos'] ?? 'sin_id') . "_{$codigoUnico}_{$fechaHoraActual}.{$extension}";
                        $nombre_archivo = "PERFIL/DOCUMENTACION/DATOS_HIJOS/" . $nombre;

                        // 🔹 Subir archivo al FTP
                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $hijo['dni_file'] = $nombre; // Guardar el nombre del archivo en el array
                            $archivosSubidos[] = $nombre;
                        } else {
                            Log::error("Error en FTP al subir el archivo para el hijo ID: " . ($hijo['id_hijos'] ?? 'sin_id'));
                        }
                    } else {
                        Log::error("El archivo DNI para el hijo ID " . ($hijo['id_hijos'] ?? 'sin_id') . " no es válido.");
                    }
                }
            }

            ftp_close($con_id);

            // 🔹 Actualizar UserIntranet con la respuesta de hijos
            UserIntranet::where('id_usuario', $id_usuario)
                ->update([
                    'hijos' => $hijos[0]['respuesta'] ?? 0,  // Si existe respuesta, usa el valor; si no, usa 0
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);

            // 🔹 Crear registros en la tabla Hijos si hay datos
            foreach ($hijos as $hij) {
                if (!empty($hij['fecha_nacimiento_hijo'])) {
                    // Asegurar que la fecha tiene el formato correcto
                    $timestamp = strtotime($hij['fecha_nacimiento_hijo']);
                    $dia_nac = date('d', $timestamp);
                    $mes_nac = date('m', $timestamp);
                    $anio_nac = date('Y', $timestamp);
                }

                Hijos::create([
                    'id_usuario' => $id_usuario,
                    'nom_hijo' => $hij['nombre_hijo'],
                    'id_genero' => $hij['genero_hijo'],
                    'dia_nac' => $dia_nac ?? null,
                    'mes_nac' => $mes_nac ?? null,
                    'anio_nac' => $anio_nac ?? null,
                    'id_biologico' => $hij['biologico'],
                    'num_doc' => $hij['dni_hijo'],
                    'documento' => $hij['dni_file'] ?? null,
                    'fec_nac' => $hij['fecha_nacimiento_hijo'] ?? null,
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1,
                    'id_tipo_documento' => 0,
                    'id_vinculo' => 0,
                    'id_situacion' => 0,
                    'id_motivo_baja' => 0,
                    'id_tipo_via' => 0,
                    'id_zona' => 0,
                    'carta_medica' => 0,
                    'n_certificado_medico' => 0,
                    'nom_via' => 0,
                    'num_via' => 0,
                    'interior' => 0,
                    'nom_zona' => 0,
                    'referencia' => 0,
                    'documento_nombre' => 0,
                ]);
            }

            // return response()->json(['message' => 'Formulario procesado', 'archivos' => $archivosSubidos], 200);
        } catch (\Exception $e) {
            Log::error("Error en store_colaborador Hijos: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error en el servidor'], 500);
        }




        // ✅ Actualizar los datos en ContactoEmergencia
        foreach ($formulario['contactosEmergencia'] as $contactoE) {
            ContactoEmergencia::create([
                'id_usuario' => $id_usuario,
                'nom_contacto' => $contactoE['nombre_contacto_emergencia'],
                'id_parentesco' => $contactoE['parentesco_contacto_emergencia'],
                'celular1' => $contactoE['celular_contacto_emergencia'],
                'celular2' => $contactoE['celular2_contacto_emergencia'],
                'fijo' => $contactoE['telefono_fijo_contacto_emergencia'],
                'fec_reg' => now(),
                'user_reg' =>  $id_usuario,
                'estado' => 1,
            ]);
        }

        // ✅ Actualizar los datos en ConociOffice
        ConociOffice::create([
            'id_usuario' => $id_usuario,
            'nl_excel' => $formulario['conocimientoOffice']['nivel_excel'],
            'nl_word' => $formulario['conocimientoOffice']['nivel_word'],
            'nl_ppoint' => $formulario['conocimientoOffice']['nivel_powerpoint'],
            'fec_reg' => now(),
            'user_reg' => $id_usuario,
            'estado' => 1
        ]);

        // ✅ Actualizar los datos en ConociIdiomas
        foreach ($formulario['idiomas'] as $idioma) {
            ConociIdiomas::create([
                'id_usuario' => $id_usuario,
                'nom_conoci_idiomas' => $idioma['idioma'],
                'lect_conoci_idiomas' => $idioma['lectura'],
                'escrit_conoci_idiomas' => $idioma['escritura'],
                'conver_conoci_idiomas' => $idioma['conversacion'],
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'estado' => 1
            ]);
        }


        // ✅ Actualizar los datos en CursoComplementario
        try {
            $cursos = $formulario['cursos'] ?? [];
            $id_usuario = $request->input('id_usuario', 1611);
            $archivosSubidos = [];

            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if (!$con_id) {
                return response()->json(['error' => 'No se pudo conectar al servidor FTP'], 500);
            }
            ftp_pasv($con_id, true);
            foreach ($cursos as $index => &$curso) {
                if ($request->hasFile("certificado_{$index}")) {
                    $file = $request->file("certificado_{$index}");
                    if ($file->isValid()) {
                        $source_file = $file->getPathname();
                        $extension = $file->getClientOriginalExtension();
                        $fechaHoraActual = date('Y-m-dHis');
                        $codigoUnico = strtoupper(bin2hex(random_bytes(10)));
                        $nombre = "cursocomp_" . ($id_usuario ?? 'sin_id') . "_{$codigoUnico}_{$fechaHoraActual}.{$extension}";
                        $nombre_archivo = "PERFIL/DOCUMENTACION/CURSOS_COMPLEMENTARIOS/" . $nombre;

                        // 🔹 Subir archivo al FTP
                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            // Log::info("Archivo subido exitosamente: $nombre_archivo");
                            $curso['certificado'] = $nombre; // Guardar el nombre del archivo en el array
                            $archivosSubidos[] = $nombre;
                        } else {
                            Log::error("Error en FTP al subir el archivo para el curso ID: " . ($id_usuario ?? 'sin_id'));
                        }
                    } else {
                        Log::error("El archivo DNI para el curso ID " . ($id_usuario ?? 'sin_id') . " no es válido.");
                    }
                }
            }

            ftp_close($con_id);
            foreach ($cursos as $curs) {
                CursoComplementario::create([
                    'id_usuario' => $id_usuario,
                    'nom_curso_complementario' => $curs['curso'],
                    'anio' => $curs['anio'],
                    'certificado' => $curs['certificado'],
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'actualidad' => 0,
                    'certificado_nombre' => 0,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error en store_colaborador CursoComplementario: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error en el servidor'], 500);
        }



        // ✅ Actualizar los datos en ExperienciaLaboral
        try {
            $experiencias = $formulario['experienciasLaborales'] ?? [];
            $id_usuario = $request->input('id_usuario', 1611);
            $archivosSubidos = [];

            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if (!$con_id) {
                return response()->json(['error' => 'No se pudo conectar al servidor FTP'], 500);
            }
            ftp_pasv($con_id, true);
            foreach ($experiencias as $index => &$exp) {
                if ($request->hasFile("certificadolb_{$index}")) {
                    $file = $request->file("certificadolb_{$index}");
                    if ($file->isValid()) {
                        $source_file = $file->getPathname();
                        $extension = $file->getClientOriginalExtension();
                        $fechaHoraActual = date('Y-m-dHis');
                        $codigoUnico = strtoupper(bin2hex(random_bytes(10)));
                        $nombre = "certificadolb_" . ($id_usuario ?? 'sin_id') . "_{$codigoUnico}_{$fechaHoraActual}.{$extension}";
                        $nombre_archivo = "PERFIL/DOCUMENTACION/EXPERIENCIA_LABORAL/" . $nombre;

                        // 🔹 Subir archivo al FTP
                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            // Log::info("Archivo subido exitosamente: $nombre_archivo");
                            $exp['constancia'] = $nombre; // Guardar el nombre del archivo en el array
                            $archivosSubidos[] = $nombre;
                        } else {
                            Log::error("Error en FTP al subir el archivo para el curso ID: " . ($id_usuario ?? 'sin_id'));
                        }
                    } else {
                        Log::error("El archivo DNI para el curso ID " . ($id_usuario ?? 'sin_id') . " no es válido.");
                    }
                }
            }
            ftp_close($con_id);

            foreach ($experiencias as $exper) {
                // Asegurar que la fecha tiene el formato correcto
                $timestamp = strtotime($exper['fecha_inicio']);
                $timestampF = strtotime($exper['fecha_fin']);
                $dia_ini = date('d', $timestamp);
                $mes_ini = date('m', $timestamp);
                $anio_ini = date('Y', $timestamp);
                $dia_fin = date('d', $timestampF);
                $mes_fin = date('m', $timestampF);
                $anio_fin = date('Y', $timestampF);
                ExperienciaLaboral::create([
                    'id_usuario' => $id_usuario,
                    'empresa' => $exper['empresa'],
                    'cargo' => $exper['cargo'],
                    'dia_ini' => $dia_ini ?? '00',
                    'mes_ini' => $mes_ini ?? '00',
                    'anio_ini' => $anio_ini ?? '0000',
                    'fec_ini' => $exper['fecha_inicio'],
                    'actualidad' => 0,
                    'dia_fin' => $dia_fin ?? '00',
                    'mes_fin' => $mes_fin ?? '00',
                    'anio_fin' => $anio_fin ?? '0000',
                    'fec_fin' => $exper['fecha_fin'],
                    'motivo_salida' => $exper['motivo_salida'],
                    'remuneracion' => $exper['importe_remuneracion'],
                    'nom_referencia_labores' => $exper['nombre_referencia'],
                    'num_contacto' => $exper['numero_contacto_referencia'],
                    'certificado' => $exper['constancia'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1,
                    'certificado_nombre' => 0,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error en store_colaborador: " . $e->getMessage());
            return response()->json(['error' => 'Agregue Experiencia'], 500);
        }



        // ✅ Actualizar los datos en EnfermedadUsuario y UserIntranet
        // Verificar si `enfermedades` existe y no está vacío
        if (empty($formulario['enfermedades'])) {
            // 🔹 Si no hay enfermedades, actualizar `UserIntranet` y detener el proceso
            UserIntranet::where('id_usuario', $id_usuario)
                ->update([
                    'enfermedades' => 0, // No tiene enfermedades
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);

            // return response()->json(['message' => 'Formulario procesado sin enfermedades'], 200);
        }

        // 🔹 Si hay enfermedades, obtener el primer valor de `padece_enfermedad`
        $padeceEnfermedad = $formulario['enfermedades'][0]['padece_enfermedad'] ?? 0;

        // 🔹 Actualizar UserIntranet con el valor de `padece_enfermedad`
        UserIntranet::where('id_usuario', $id_usuario)
            ->update([
                'enfermedades' => $padeceEnfermedad,
                'fec_act' => now(),
                'user_act' => $id_usuario
            ]);

        // 🔹 Si `padece_enfermedad == 1`, registrar enfermedades
        if ($padeceEnfermedad == 1) {
            foreach ($formulario['enfermedades'] as $enfermedad) {
                if (!empty($enfermedad['fecha_diagnostico'])) {
                    $timestamp = strtotime($enfermedad['fecha_diagnostico']);
                    $dia_diagnostico = date('d', $timestamp);
                    $mes_diagnostico = date('m', $timestamp);
                    $anio_diagnostico = date('Y', $timestamp);
                } else {
                    $dia_diagnostico = $mes_diagnostico = $anio_diagnostico = null;
                }

                EnfermedadUsuario::create([
                    'id_usuario' => $id_usuario,
                    'id_respuestae' => $enfermedad['padece_enfermedad'],
                    'nom_enfermedad' => $enfermedad['enfermedad'],
                    'dia_diagnostico' => $dia_diagnostico,
                    'mes_diagnostico' => $mes_diagnostico,
                    'anio_diagnostico' => $anio_diagnostico,
                    'fec_diagnostico' => $enfermedad['fecha_diagnostico'] ?? null,
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1
                ]);
            }
        } else {
            // 🔹 Si no tiene enfermedades pero existen registros, marcarlos como `estado = 2`
            EnfermedadUsuario::where('id_usuario', $id_usuario)
                ->update([
                    'estado' => 2,
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);
        }


        // ✅ Actualizar los datos en GestacionUsuario 
        $timestamp = strtotime($formulario['gestacion']['fecha_parto']);
        $dia_ges = date('d', $timestamp);
        $mes_ges = date('m', $timestamp);
        $anio_ges = date('Y', $timestamp);
        if ($formulario['gestacion']['respuesta_gestacion'] == 1) {
            GestacionUsuario::create([
                'id_usuario' => $id_usuario,
                'id_respuesta' => $formulario['gestacion']['respuesta_gestacion'],
                'dia_ges' => $dia_ges,
                'mes_ges' =>  $mes_ges,
                'anio_ges' =>  $anio_ges,
                'fec_ges' => $formulario['gestacion']['fecha_parto'],
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'estado' => 1,
            ]);
        } else {
            GestacionUsuario::create([
                'id_usuario' => $formulario['gestacion']['id_usuario'],
                'id_respuesta' => $formulario['gestacion']['respuesta_gestacion'],
                'dia_ges' => $dia_ges,
                'mes_ges' =>  $mes_ges,
                'anio_ges' =>  $anio_ges,
                'fec_ges' => $formulario['gestacion']['fecha_parto'],
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'estado' => 1,
            ]);
        }

        // ✅ Actualizar los datos en AlergiaUsuario y UserIntranet
        if (empty($formulario['alergias'])) {
            // 🔹 Si no hay alergias, actualizar `UserIntranet` y detener el proceso
            UserIntranet::where('id_usuario', $id_usuario)
                ->update([
                    'alergia' => 0, // No tiene alergias
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);

            // return response()->json(['message' => 'Formulario procesado sin alergias'], 200);
        }
        // 🔹 Si hay alergias, obtener el primer valor de `respuesta_alergico`
        $respuestaAlergico = $formulario['alergias'][0]['respuesta_alergico'] ?? 0;
        // 🔹 Actualizar UserIntranet con el valor de `respuesta_alergico`
        UserIntranet::where('id_usuario', $id_usuario)
            ->update([
                'alergia' => $respuestaAlergico,
                'fec_act' => now(),
                'user_act' => $id_usuario
            ]);

        // 🔹 Si `respuesta_alergico == 1`, registrar alergias
        if ($respuestaAlergico == 1) {
            foreach ($formulario['alergias'] as $alergia) {
                AlergiaUsuario::create([
                    'id_usuario' => $id_usuario,
                    'nom_alergia' => $alergia['alergia'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1,
                ]);
            }
        } else {
            // 🔹 Si no tiene alergias pero existen registros, marcarlos como `estado = 2`
            AlergiaUsuario::where('id_usuario', $id_usuario)
                ->update([
                    'estado' => 2,
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);
        }



        // ✅ Actualizar los datos en OtrosUsuario
        OtrosUsuario::create([
            'id_usuario' => $id_usuario,
            'id_grupo_sanguineo' => $formulario['otros']['tipo_sangre'],
            'cert_vacu_covid' => '',
            'fec_reg' => now(),
            'user_reg' => $id_usuario,
            'estado' => 1,
        ]);

        // ✅ Actualizar los datos en ReferenciaConvocatoria
        ReferenciaConvocatoria::create([
            'id_usuario' => $id_usuario,
            'id_referencia_laboral' => $formulario['referenciaConvocatoria']['puesto_referencia'],
            'otros' => $formulario['referenciaConvocatoria']['especifique_otros'],
            'fec_reg' => now(),
            'user_reg' => $id_usuario,
            'estado' => 1
        ]);

        // ✅ Actualizar los datos en DocumentacionUsuario
        try {
            $id_usuario = $request->input('id_usuario', 1611);
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if (!$con_id) {
                return response()->json(['error' => 'No se pudo conectar al servidor FTP'], 500);
            }
            ftp_pasv($con_id, true);
            // 🔹 Procesar archivos recibidos
            $archivos = [
                'CV' => $request->file('adjuntar_cv'),
                'DNI' => $request->file('foto_dni'),
                'RECIBO' => $request->file('copia_agua_luz')
            ];
            $archivosSubidos = [
                'cv_doc' => null,
                'dni_doc' => null,
                'recibo_doc' => null
            ];
            foreach ($archivos as $key => $archivo) {
                if ($archivo && $archivo->isValid()) {
                    $source_file = $archivo->getPathname();
                    $extension = $archivo->getClientOriginalExtension();
                    $fechaHoraActual = date('Y-m-dHis');
                    $codigoUnico = strtoupper(bin2hex(random_bytes(10)));
                    $nombre = "{$key}_" . ($id_usuario ?? 'sin_id') . "_{$codigoUnico}_{$fechaHoraActual}.{$extension}";
                    $nombre_archivo = "PERFIL/DOCUMENTACION/DOCUMENTACION/" . $nombre;

                    // 🔹 Subir archivo al FTP
                    if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                        // Guardar el nombre en el array con las claves correctas para la BD
                        if ($key === 'CV') {
                            $archivosSubidos['cv_doc'] = $nombre;
                        } elseif ($key === 'DNI') {
                            $archivosSubidos['dni_doc'] = $nombre;
                        } elseif ($key === 'RECIBO') {
                            $archivosSubidos['recibo_doc'] = $nombre;
                        }
                    } else {
                        Log::error("Error en FTP al subir el archivo: $key para el usuario ID: " . ($id_usuario ?? 'sin_id'));
                    }
                } else {
                    Log::error("El archivo $key no es válido para el usuario ID: " . ($id_usuario ?? 'sin_id'));
                }
            }
            ftp_close($con_id);
            // 🔹 Guardar la información en la base de datos
            DocumentacionUsuario::insert([
                'id_usuario' => $id_usuario,
                'cv_doc' => $archivosSubidos['cv_doc'],
                'dni_doc' => $archivosSubidos['dni_doc'],
                'recibo_doc' => $archivosSubidos['recibo_doc'],
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => $id_usuario
            ]);
            return response()->json(['success' => 'Archivos subidos correctamente']);
        } catch (\Exception $e) {
            Log::error("Error en store_colaborador DocumentacionUsuario: " . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error en el servidor'], 500);
        }


        // ✅ Actualizar los datos en RopaUsuario
        RopaUsuario::insert([
            'id_usuario' => $id_usuario,
            'polo' => $formulario['uniforme']['talla_polo'],
            'camisa' => $formulario['uniforme']['talla_camisa'],
            'pantalon' => $formulario['uniforme']['talla_pantalon'],
            'zapato' => $formulario['uniforme']['talla_zapato'],
            'fec_reg' => now(),
            'user_reg' => $id_usuario,
            'estado' => 1
        ]);

        // ✅ Actualizar los datos en SistPensUsuario
        SistPensUsuario::create([
            'id_usuario' => $id_usuario,
            'id_respuestasp' => $formulario['sistemapensionario']['sistema_pensionario'],
            'id_sistema_pensionario' => $formulario['sistemapensionario']['tipo_sistema'],
            'id_afp' => $formulario['sistemapensionario']['afp'],
            'user_reg' => $id_usuario,
            'fec_reg' => now(),
            'estado' => 1,
        ]);

        // ✅ Actualizar los datos en CuentaBancaria
        CuentaBancaria::insert([
            'id_usuario' => $id_usuario,
            'id_banco' => $formulario['cuentabancaria']['entidad_bancaria'],
            'cuenta_bancaria' => $formulario['cuentabancaria']['cuenta_bancaria'],
            'num_cuenta_bancaria' => $formulario['cuentabancaria']['numero_cuenta'],
            'num_codigo_interbancario' => $formulario['cuentabancaria']['codigo_interbancario'],
            'fec_reg' => now(),
            'user_reg' => $id_usuario,
            'estado' => 1
        ]);
    }
}
