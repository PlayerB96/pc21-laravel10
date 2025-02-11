@extends('layouts.app')
@section('title', 'REGISTRO POSTULANTES')
@section('content')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            .form-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: space-between;
            }

            .form-group {
                flex: 1 1 calc(33.33% - 20px);
                /* Esto crea tres columnas */
                box-sizing: border-box;
            }




            .file-preview {
                margin-top: 10px;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                max-width: 100%;
                text-align: center;
            }

            .file-preview img {
                max-width: 100%;
                height: auto;
            }

            .file-preview object {
                width: 100%;
                height: 300px;
                /* Ajusta según lo necesites */
            }



            .form-group label {
                font-weight: bold;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 8px;
                margin-top: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }



            #map {
                width: 100%;
                height: 300px;
                margin-top: 20px;
                border-radius: 5px;
            }

            .upload-container {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 150px;
                height: 150px;
                background-image: url('{{ asset('assets/imgs/upload_img.png') }}');
                background-size: cover;
                background-position: center;
                border-radius: 10px;
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }

            .upload-container input[type='file'] {
                position: absolute;
                width: 100%;
                height: 100%;
                opacity: 0;
                cursor: pointer;
            }

            .upload-container:hover {
                opacity: 0.8;
                border: 2px dashed #007bff;
            }

            .upload-container p {
                position: absolute;
                bottom: 10px;
                width: 100%;
                text-align: center;
                color: white;
                font-weight: bold;
                background: rgba(0, 0, 0, 0.5);
                padding: 5px 0;
                margin: 0;
            }

            .section-title {
                font-size: 20px;
                font-weight: bold;
                margin-top: 30px;
                border-bottom: 2px solid #ccc;
                margin-bottom: 30px;
                padding-bottom: 5px;
            }

            .section-container {
                margin-top: 30px;
            }

            /* Responsive Design for Columns */
            @media (max-width: 768px) {

                .form-group,
                .form-group-3col {
                    min-width: 100%;
                }
            }
        </style>
    </head>

    <div class="layout-container-section-content">
        <div class="page-header">
            <div class="page-title">
                <h3>Registro de POSTULANTES</h3>
            </div>
        </div>
        <div class="widget-container-section-content">
            <div class="row">
                <div class="upload-container" id="uploadContainer">
                    <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                    <p>Actualizar imagen</p>
                </div>
            </div>

            <form action="{{ route('gestionpersonas.store_rpo') }}" method="POST" id="surveyForm">
                @csrf
                <div class="form-container">
                    <div class="form-group form-group-3col">
                        <label>Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" required>
                    </div>
                    <div class="form-group form-group-3col">
                        <label>Apellido Materno</label>
                        <input type="text" name="apellido_materno" required>
                    </div>
                    <div class="form-group form-group-3col">
                        <label>Nombres</label>
                        <input type="text" name="nombres" required>
                    </div>

                    <div class="form-group form-group-3col">
                        <label>Nacionalidad</label>
                        <select name="nacionalidad" required>
                            <option value="Peruano">Peruano</option>
                            <option value="Colombiano">Colombiano</option>
                            <option value="Venezolano">Venezolano</option>
                        </select>
                    </div>
                    <div class="form-group form-group-3col">
                        <label>Estado Civil</label>
                        <select name="estado_civil" required>
                            <option value="Soltero">Soltero</option>
                            <option value="Casado">Casado</option>
                            <option value="Divorciado">Divorciado</option>
                            <option value="Viudo">Viudo</option>
                        </select>
                    </div>


                    <div class="form-group form-group-3col">
                        <label>Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" required>
                    </div>
                    <div class="form-group form-group-3col">
                        <label>Edad</label>
                        <input type="number" name="edad" required>
                    </div>
                    <div class="form-group form-group-3col">
                        <label>Género</label>
                        <select name="genero" required>
                            <option value="Soltero">Mujer</option>
                            <option value="Casado">Hombre</option>
                        </select>
                    </div>
                    <div class="form-group form-group-3col">
                        <label>Tipo de Documento</label>
                        <select name="tipo_documento" required>
                            <option value="DNI">DNI</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Número de Documento</label>
                        <input type="number" name="numero_documento" required>
                    </div>
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label>Número Celular</label>
                        <input type="number" name="celular" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono Fijo</label>
                        <input type="number" name="telefono" required>
                    </div>
                </div>

                <!-- Domicilio Section -->
                <div class="section-container">
                    <div class="section-title">Domicilio</div>
                    <div class="form-container">
                        <!-- Tres columnas en una fila -->
                        <div class="form-group form-group-3col">
                            <label>Tipo de vía</label>
                            <input type="text" name="tipo_via" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Nombre de vía</label>
                            <input type="text" name="nombre_via" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Número de vía</label>
                            <input type="text" name="numero_via" required>
                        </div>

                        <!-- Tres columnas en una fila -->
                        <div class="form-group form-group-3col">
                            <label>KM</label>
                            <input type="text" name="km" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>MZ</label>
                            <input type="text" name="mz" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Interior</label>
                            <input type="text" name="interior" required>
                        </div>

                        <!-- Tres columnas en una fila -->
                        <div class="form-group form-group-3col">
                            <label>N° Departamento</label>
                            <input type="text" name="numero_departamento" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Lote</label>
                            <input type="text" name="lote" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Piso</label>
                            <input type="text" name="piso" required>
                        </div>

                        <!-- Tres columnas en una fila -->
                        <div class="form-group form-group-3col">
                            <label>Tipo de Zona</label>
                            <input type="text" name="tipo_zona" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Nombre Zona</label>
                            <input type="text" name="nombre_zona" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Tipo de vivienda</label>
                            <input type="text" name="tipo_vivienda" required>
                        </div>

                        <!-- Dos columnas en una fila -->
                        <div class="form-group form-group-3col">
                            <label>Referencia Domicilio</label>
                            <input type="text" name="referencia_domicilio" required>
                        </div>
                        <div class="form-group form-group-3col" style="width: 100%;">
                            <label>Dirección Completa</label>
                            <input type="text" name="direccion_completa" required>
                        </div>

                    </div>
                    <div id="map"></div>
                </div>

                <!-- Gustos y Preferencias Section -->
                <div class="section-container">
                    <div class="section-title">Gustos y Preferencias</div>
                    <div class="form-container">
                        <!-- Tres columnas en una fila -->
                        <div class="form-group form-group-3col">
                            <label>Plato y postre favorito</label>
                            <input type="text" name="plato_postre_favorito" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Galletas y golosinas favoritas</label>
                            <input type="text" name="galletas_golosinas_favoritas" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Actividades de ocio o pasatiempos</label>
                            <input type="text" name="actividades_ocio" required>
                        </div>

                        <div class="form-group form-group-3col">
                            <label>Artistas o banda favorita</label>
                            <input type="text" name="artistas_banda_favorita" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Género musical favorito</label>
                            <input type="text" name="genero_musical_favorito" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Película o serie favorita</label>
                            <input type="text" name="pelicula_serie_favorita" required>
                        </div>

                        <div class="form-group form-group-3col">
                            <label>Colores favoritos</label>
                            <input type="text" name="colores_favoritos" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Redes sociales favoritas</label>
                            <input type="text" name="redes_sociales_favoritas" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Deporte favorito</label>
                            <input type="text" name="deporte_favorito" required>
                        </div>

                        <div class="form-group">
                            <label>¿Tiene mascota?</label>
                            <select name="tiene_mascota" required>
                                <option value="">Seleccione</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Qué mascota tienes?</label>
                            <input type="text" name="tipo_mascota" required>
                        </div>
                    </div>
                </div>

                <!-- Referencias Familiares Section -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Referencias Familiares</div>
                        <!-- Botón Agregar -->
                        <button type="button" id="agregarReferencia" class="btn-add">Agregar</button>
                    </div>

                    <div class="form-container">
                        <!-- Campos de entrada -->
                        <div class="form-group form-group-3col">
                            <label>Nombre de Familiar</label>
                            <input type="text" name="nombre_familiar" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Parentesco</label>
                            <select name="parentesco" required>
                                <option value="">Seleccione</option>
                                <option value="madre">Madre</option>
                                <option value="padre">Padre</option>
                                <option value="hermano">Hermano</option>
                                <option value="hermana">Hermana</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento_ref" required>
                        </div>

                        <div class="form-group form-group-3col">
                            <label>Celular</label>
                            <input type="number" name="celular_ref" required>
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Celular 2</label>
                            <input type="number" name="celular_ref2">
                        </div>
                        <div class="form-group form-group-3col">
                            <label>Teléfono Fijo</label>
                            <input type="number" name="telefono_fijo">
                        </div>


                        <!-- Tabla para mostrar las referencias -->
                        <div class="table-responsive" style="margin-top: 20px;">
                            <table id="tablaReferencias" class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Parentesco</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Celular</th>
                                        <th>Celular 2</th>
                                        <th>Teléfono Fijo</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Filas se llenarán dinámicamente con JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Datos de Hijos/as Section -->
                <div class="section-container">
                    <div class="section-title">Datos de hijos/as</div>
                    <div class="form-container">
                        <div class="form-group">
                            <label>¿Respuesta?</label>
                            <select name="respuesta" required>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nombre de Hijo/a</label>
                            <input type="text" name="nombre_hijo" required>
                        </div>
                        <div class="form-group">
                            <label>Género</label>
                            <select name="genero_hijo" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento_hijo" required>
                        </div>
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text" name="dni_hijo" required>
                        </div>
                        <div class="form-group">
                            <label>Biológico/No Biológico</label>
                            <select name="biologico" required>
                                <option value="Sí">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Adjuntar DNI</label>
                            <input type="file" name="dni_file" accept="image/*,application/pdf" required>
                        </div>
                    </div>
                </div>

                <!-- Datos de Contacto de Emergencia -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Contacto de Emergencia</div>
                        <!-- Botón Agregar -->
                        <button type="button" id="agregarContactoEmergencia" class="btn-add">Agregar</button>
                    </div>
                    <!-- Formulario de contacto de emergencia -->
                    <div class="form-container">
                        <div class="form-group">
                            <label>Nombre de Contacto</label>
                            <input type="text" name="nombre_contacto_emergencia" id="nombre_contacto_emergencia"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Parentesco</label>
                            <select name="parentesco_contacto_emergencia" id="parentesco_contacto_emergencia" required>
                                <option value="Padre">Padre</option>
                                <option value="Madre">Madre</option>
                                <option value="Hermano/a">Hermano/a</option>
                                <option value="Amigo/a">Amigo/a</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Celular</label>
                            <input type="number" name="celular_contacto_emergencia" id="celular_contacto_emergencia"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Celular 2</label>
                            <input type="number" name="celular2_contacto_emergencia" id="celular2_contacto_emergencia">
                        </div>
                        <div class="form-group">
                            <label>Teléfono Fijo</label>
                            <input type="number" name="telefono_fijo_contacto_emergencia"
                                id="telefono_fijo_contacto_emergencia">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tabla_contactos_emergencia" class="tabla">
                            <thead>
                                <tr>
                                    <th>Nombre de Contacto</th>
                                    <th>Parentesco</th>
                                    <th>Celular</th>
                                    <th>Celular 2</th>
                                    <th>Teléfono Fijo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se agregarán los contactos de emergencia -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Conocimientos de Office -->
                <div class="section-container">
                    <div class="section-title">Conocimientos de Office</div>
                    <div class="form-container">
                        <div class="form-group">
                            <label>Nivel de Excel</label>
                            <select name="nivel_excel" id="nivel_excel" required>
                                <option value="">Seleccione</option>
                                <option value="Básico">Básico</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nivel de Word</label>
                            <select name="nivel_word" id="nivel_word" required>
                                <option value="">Seleccione</option>
                                <option value="Básico">Básico</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nivel de Power Point</label>
                            <select name="nivel_powerpoint" id="nivel_powerpoint" required>
                                <option value="">Seleccione</option>
                                <option value="Básico">Básico</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Conocimientos de Idiomas -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Conocimientos de Idiomas</div>
                        <!-- Botón Agregar -->
                        <button type="button" id="agregarIdioma" class="btn-add">Agregar</button>
                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <label>Idioma</label>
                            <select name="idioma" id="idioma" required>
                                <option value="">Seleccione</option>
                                <option value="Inglés">Inglés</option>
                                <option value="Francés">Francés</option>
                                <option value="Alemán">Alemán</option>
                                <option value="Italiano">Italiano</option>
                                <option value="Portugués">Portugués</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lectura</label>
                            <select name="lectura" id="lectura" required>
                                <option value="">Seleccione</option>
                                <option value="Básico">Básico</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Escritura</label>
                            <select name="escritura" id="escritura" required>
                                <option value="">Seleccione</option>
                                <option value="Básico">Básico</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Conversación</label>
                            <select name="conversacion" id="conversacion" required>
                                <option value="">Seleccione</option>
                                <option value="Básico">Básico</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>
                        </div>


                    </div>

                    <!-- Tabla de Conocimientos de Idiomas -->
                    <div class="table-responsive">
                        <table id="tablaIdiomas">
                            <thead>
                                <tr>
                                    <th>Idioma</th>
                                    <th>Lectura</th>
                                    <th>Escritura</th>
                                    <th>Conversación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Las filas se agregarán dinámicamente aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Cursos Complementarios -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Cursos Complementarios</div>
                        <!-- Botón Agregar -->
                        <button type="button" id="agregarCurso" class="btn-add">Agregar</button>
                    </div>

                    <!-- Formulario de Cursos Complementarios -->
                    <div class="form-container">
                        <div class="form-group">
                            <label for="curso">Cursos/Conocimientos Complementarios</label>
                            <input type="text" id="curso" name="curso" required placeholder="Nombre del curso">
                        </div>
                        <div class="form-group">
                            <label for="anio">Año</label>
                            <select id="anio" name="anio" required>
                                <option value="">Seleccione</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="certificado">Adjuntar Certificado</label>
                            <input type="file" id="certificado" name="certificado" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>

                    <!-- Tabla de Cursos Complementarios -->
                    <div class="table-responsive">
                        <table id="tablaCursos">
                            <thead>
                                <tr>
                                    <th>Curso/Conocimiento</th>
                                    <th>Año</th>
                                    <th>Certificado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Las filas se agregarán dinámicamente aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Experiencia Laboral -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Experiencia Laboral</div>
                        <!-- Botón Agregar -->
                        <button type="button" id="agregarExperiencia" class="btn-add">Agregar</button>
                    </div>

                    <!-- Formulario de Experiencia Laboral -->
                    <div class="form-container">
                        <div class="form-group">
                            <label for="empresa">Empresa</label>
                            <input type="text" id="empresa" name="empresa" required
                                placeholder="Nombre de la empresa">
                        </div>
                        <div class="form-group">
                            <label for="cargo">Cargo</label>
                            <input type="text" id="cargo" name="cargo" required
                                placeholder="Cargo desempeñado">
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" required>
                        </div>
                        <div class="form-group">
                            <label for="motivo_salida">Motivo de Salida</label>
                            <input type="text" id="motivo_salida" name="motivo_salida" required
                                placeholder="Motivo de salida">
                        </div>
                        <div class="form-group">
                            <label for="importe_remuneracion">Importe de Remuneración</label>
                            <input type="number" id="importe_remuneracion" name="importe_remuneracion" required
                                placeholder="Importe">
                        </div>
                        <div class="form-group">
                            <label for="nombre_referencia">Nombre de Referencia Laboral</label>
                            <input type="text" id="nombre_referencia" name="nombre_referencia" required
                                placeholder="Nombre de referencia">
                        </div>
                        <div class="form-group">
                            <label for="numero_contacto">Número de Contacto de la Empresa</label>
                            <input type="number" id="numero_contacto" name="numero_contacto" required
                                placeholder="Número de contacto">
                        </div>
                        <div class="form-group">
                            <label for="certificado">Adjuntar Certificado</label>
                            <input type="file" id="certificado" name="certificado_exp" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>

                    <!-- Tabla de Experiencia Laboral -->
                    <div class="table-responsive">
                        <table id="tablaExperiencia">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Cargo</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Fecha de Fin</th>
                                    <th>Motivo de Salida</th>
                                    <th>Importe de Remuneración</th>
                                    <th>Referencia</th>
                                    <th>Contacto</th>
                                    <th>Certificado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Las filas se agregarán dinámicamente aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Enfermedades -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Enfermedades</div>
                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <label for="padece_enfermedad">Indique si padece alguna enfermedad</label>
                            <select id="padece_enfermedad" name="padece_enfermedad" required>
                                <option value="">Seleccione</option>
                                <option value="Si">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="enfermedad">Especifique la enfermedad</label>
                            <input type="text" id="enfermedad" name="enfermedad"
                                placeholder="Especifique la enfermedad" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_diagnostico">Fecha de Diagnóstico</label>
                            <input type="date" id="fecha_diagnostico" name="fecha_diagnostico" required>
                        </div>
                    </div>
                </div>

                <!-- Gestación -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Gestación</div>
                    </div>

                    <!-- Formulario de Gestación -->
                    <div class="form-container">
                        <div class="form-group">
                            <label for="gestacion">Indique si se encuentra en gestación</label>
                            <select id="gestacion" name="gestacion" required>
                                <option value="">Seleccione</option>
                                <option value="Si">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio_gestacion">Fecha de inicio de gestación</label>
                            <input type="date" id="fecha_inicio_gestacion" name="fecha_inicio_gestacion" required>
                        </div>
                    </div>
                </div>

                <!-- Alergias -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Alergias</div>
                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <label for="alergia_medicamento">¿Es alérgico a algún medicamento?</label>
                            <select id="alergia_medicamento" name="alergia_medicamento" required>
                                <option value="">Seleccione</option>
                                <option value="Si">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre_medicamento">Indique el nombre del medicamento</label>
                            <input type="text" id="nombre_medicamento" name="nombre_medicamento" required>
                        </div>
                    </div>
                </div>

                <!-- Otros -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Otros</div>
                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <label for="tipo_sangre">Tipo de sangre</label>
                            <select id="tipo_sangre" name="tipo_sangre" required>
                                <option value="">Seleccione</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Referencia de Convocatoria -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Referencia de Convocatoria</div>
                    </div>
                    <div class="form-container">
                        <div class="form-group">
                            <label for="referencia_convocatoria">¿Cómo te enteraste del puesto?</label>
                            <select id="referencia_convocatoria" name="referencia_convocatoria" required>
                                <option value="">Seleccione</option>
                                <option value="Redes Sociales">Redes Sociales</option>
                                <option value="Recomendación">Recomendación</option>
                                <option value="Portal de Empleo">Portal de Empleo</option>
                                <option value="Publicidad">Publicidad</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="especificar_otros">Especifique otros</label>
                            <input type="text" id="especificar_otros" name="especificar_otros"
                                placeholder="Especifique" />
                        </div>
                    </div>
                </div>

                <!-- Adjuntar Documentación -->
                <div class="section-container">
                    <div class="row" style="display: flex; gap: 20px; align-items: center;">
                        <div class="section-title">Adjuntar Documentación</div>
                    </div>

                    <!-- Formulario de Adjuntar Documentación -->
                    <div class="form-container">
                        <!-- Campo: Adjuntar Curriculum Vitae -->
                        <div class="form-group">
                            <label for="curriculum_vitae">Adjuntar Curriculum Vitae</label>
                            <input type="file" id="curriculum_vitae" name="curriculum_vitae" accept=".pdf,.doc,.docx"
                                onchange="previsualizarArchivo(this, 'cv-preview')" />
                            <div id="cv-preview" class="file-preview"></div>
                        </div>

                        <!-- Campo: Foto DNI -->
                        <div class="form-group">
                            <label for="foto_dni">Foto DNI</label>
                            <input type="file" id="foto_dni" name="foto_dni" accept="image/*"
                                onchange="previsualizarArchivo(this, 'dni-preview')" />
                            <div id="dni-preview" class="file-preview"></div>
                        </div>

                        <!-- Campo: Copia de Recibo de Agua y Luz -->
                        <div class="form-group">
                            <label for="recibo_agua_luz">Copia de Recibo de Agua y Luz</label>
                            <input type="file" id="recibo_agua_luz" name="recibo_agua_luz" accept="image/*,.pdf"
                                onchange="previsualizarArchivo(this, 'recibo-preview')" />
                            <div id="recibo-preview" class="file-preview"></div>
                        </div>
                    </div>
                </div>

                <!-- Uniforme -->
                <div class="section-container">
                    <div class="section-title">Uniforme</div>

                    <div class="form-container">
                        <div class="form-group">
                            <label for="polo">Polo</label>
                            <select id="polo" name="polo">
                                <option value="Tamaño1">Tamaño 1</option>
                                <option value="Tamaño2">Tamaño 2</option>
                                <option value="Tamaño3">Tamaño 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="camisa">Camisa</label>
                            <select id="camisa" name="camisa">
                                <option value="Tamaño1">Tamaño 1</option>
                                <option value="Tamaño2">Tamaño 2</option>
                                <option value="Tamaño3">Tamaño 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="pantalon">Pantalón</label>
                            <select id="pantalon" name="pantalon">
                                <option value="Tamaño1">Tamaño 1</option>
                                <option value="Tamaño2">Tamaño 2</option>
                                <option value="Tamaño3">Tamaño 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="zapato">Zapato</label>
                            <select id="zapato" name="zapato">
                                <option value="Tamaño1">Tamaño 1</option>
                                <option value="Tamaño2">Tamaño 2</option>
                                <option value="Tamaño3">Tamaño 3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!--Sistema Pensionario -->
                <div class="section-container">
                    <div class="section-title">Sistema Pensionario</div>

                    <div class="form-container">
                        <div class="form-group">
                            <label for="sistema_pensionario">¿Pertenece a algún sistema pensionario?</label>
                            <select id="sistema_pensionario" name="sistema_pensionario" onchange="toggleSystemInput()">
                                <option value="no">No</option>
                                <option value="si">Sí</option>
                            </select>
                        </div>

                        <div class="form-group" id="sistema-select-container" style="display:none;">
                            <label for="sistema_afp">Indique el sistema pensionario al que pertenece</label>
                            <select id="sistema_afp" name="sistema_afp" disabled>
                                <option value="AFP">AFP</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>

                        <div class="form-group" id="afp-choose-container" style="display:none;">
                            <label for="afp">Si indicó AFP, elija el sistema AFP</label>
                            <select id="afp" name="afp" disabled>
                                <option value="System1">Sistema 1</option>
                                <option value="System2">Sistema 2</option>
                                <option value="System3">Sistema 3</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Número de Cuenta -->
                <div class="section-container">
                    <div class="section-title">Número de Cuenta</div>

                    <div class="form-container">
                        <div class="form-group">
                            <label for="cuenta_bancaria">¿Cuentas con cuenta bancaria?</label>
                            <select id="cuenta_bancaria" name="cuenta_bancaria" onchange="toggleBankEntityInput()">
                                <option value="no">No</option>
                                <option value="si">Sí</option>
                            </select>
                        </div>

                        <div class="form-group" id="entidad-bancaria-container" style="display:none;">
                            <label for="entidad_bancaria">Indique la entidad bancaria</label>
                            <select id="entidad_bancaria" name="entidad_bancaria" disabled>
                                <option value="Entidad1">Entidad 1</option>
                                <option value="Entidad2">Entidad 2</option>
                                <option value="Entidad3">Entidad 3</option>
                                <option value="Entidad4">Entidad 4</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Registrar Postulante</button>
            </form>


        </div>
    </div>

    <script>
        $(document).ready(function() {
            const table_contactos_emergencia = $('#tabla_contactos_emergencia').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel'],
                responsive: true,
                searching: false,
                paging: false
            });
            const table = $('#tablaReferencias').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel'],
                responsive: true,
                searching: false,
                paging: false
            });
            const idiomasTable = $('#tablaIdiomas').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel'],
                responsive: true,
                searching: false,
                paging: false
            });

            // Inicialización de la tabla para Idiomas
            const cursosComplementariosTable = $('#tablaCursos').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel'],
                responsive: true,
                searching: false,
                paging: false
            });

            // Inicialización de la tabla para Idiomas
            const experienciaTable = $('#tablaExperiencia').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'excel'],
                responsive: true,
                searching: false,
                paging: false
            });

            // Evento para agregar nueva referencia
            document.getElementById("agregarReferencia").addEventListener("click", function() {
                const nombreFamiliar = document.querySelector('[name="nombre_familiar"]').value;
                const parentesco = document.querySelector('[name="parentesco"]').value;
                const fechaNacimiento = document.querySelector('[name="fecha_nacimiento_ref"]').value;
                const celular = document.querySelector('[name="celular_ref"]').value;
                const celular2 = document.querySelector('[name="celular_ref2"]').value;
                const telefonoFijo = document.querySelector('[name="telefono_fijo"]').value;

                if (nombreFamiliar && parentesco && fechaNacimiento && celular) {
                    // Si estamos en modo "Actualizar", no agregamos una nueva fila, solo actualizamos la existente
                    if (this.dataset.editingRow) {
                        actualizarReferencia();
                    } else {
                        // Concatenar los botones dentro de una sola celda
                        const botones =
                            `<button class="btn-edit" onclick="editarReferencia(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" fill="#007bff">
                            <path d="M362.7 19.3L315.3 66.7 445.3 196.7l47.4-47.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zM289.4 92.7L39.2 342.9c-10.5 10.5-17.7 24-20.7 38.6L.2 494.2c-1.5 7.4 5.2 14.2 12.6 12.6l112.7-18.3c14.6-3 28.1-10.2 38.6-20.7L419.3 218.6 289.4 92.7z"/>
                        </svg>
                    </button>
                    <button class="btn-delete" onclick="borrarReferencia(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20" height="20" fill="#dc3545">
                            <path d="M135.2 17.7c5.9-10.6 17.1-17.7 29.4-17.7H283.4c12.3 0 23.5 6.6 29.4 17.7l11.9 21.3H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H123.3l11.9-21.3zM53.2 467C50.9 490.2 69.6 512 93 512H355c23.4 0 42.1-21.8 39.8-45L360.2 128H87.8L53.2 467z"/>
                        </svg>
                    </button>`;

                        // Insertar una nueva fila en la tabla
                        table.row.add([
                            nombreFamiliar,
                            parentesco,
                            fechaNacimiento,
                            celular,
                            celular2,
                            telefonoFijo,
                            botones // Aquí se agregan ambos botones en una sola celda
                        ]).draw();

                        // Limpiar los campos después de agregar
                        document.querySelector('[name="nombre_familiar"]').value = "";
                        document.querySelector('[name="parentesco"]').value = "";
                        document.querySelector('[name="fecha_nacimiento_ref"]').value = "";
                        document.querySelector('[name="celular_ref"]').value = "";
                        document.querySelector('[name="celular_ref2"]').value = "";
                        document.querySelector('[name="telefono_fijo"]').value = "";
                    }
                } else {
                    alert("Por favor, completa todos los campos obligatorios.");
                }
            });

            // Evento para agregar contacto de emergencia
            document.getElementById("agregarContactoEmergencia").addEventListener("click", function() {
                const nombreFamiliar = document.querySelector('[name="nombre_contacto_emergencia"]').value;
                const parentesco = document.querySelector('[name="parentesco_contacto_emergencia"]').value;
                const celular = document.querySelector('[name="celular_contacto_emergencia"]').value;
                const celular2 = document.querySelector('[name="celular2_contacto_emergencia"]').value;
                const telefonoFijo = document.querySelector('[name="telefono_fijo_contacto_emergencia"]')
                    .value;

                if (nombreFamiliar && parentesco && celular) {
                    // Si estamos en modo "Actualizar", no agregamos una nueva fila, solo actualizamos la existente
                    if (this.dataset.editingRow) {
                        actualizarContactoEmergencia();
                    } else {
                        // Concatenar los botones dentro de una sola celda
                        const botones =
                            `<button class="btn-edit" onclick="editarContactoEmergencia(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" fill="#007bff">
                                <path d="M362.7 19.3L315.3 66.7 445.3 196.7l47.4-47.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zM289.4 92.7L39.2 342.9c-10.5 10.5-17.7 24-20.7 38.6L.2 494.2c-1.5 7.4 5.2 14.2 12.6 12.6l112.7-18.3c14.6-3 28.1-10.2 38.6-20.7L419.3 218.6 289.4 92.7z"/>
                            </svg>
                        </button>
                        <button class="btn-delete" onclick="borrarContactoEmergencia(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20" height="20" fill="#dc3545">
                                <path d="M135.2 17.7c5.9-10.6 17.1-17.7 29.4-17.7H283.4c12.3 0 23.5 6.6 29.4 17.7l11.9 21.3H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H123.3l11.9-21.3zM53.2 467C50.9 490.2 69.6 512 93 512H355c23.4 0 42.1-21.8 39.8-45L360.2 128H87.8L53.2 467z"/>
                            </svg>
                        </button>`;

                        // Insertar una nueva fila en la tabla
                        table_contactos_emergencia.row.add([
                            nombreFamiliar,
                            parentesco,
                            celular,
                            celular2,
                            telefonoFijo,
                            botones // Aquí se agregan ambos botones en una sola celda
                        ]).draw();

                        // Limpiar los campos después de agregar
                        document.querySelector('[name="nombre_contacto_emergencia"]').value = "";
                        document.querySelector('[name="parentesco_contacto_emergencia"]').value = "";
                        document.querySelector('[name="celular_contacto_emergencia"]').value = "";
                        document.querySelector('[name="celular2_contacto_emergencia"]').value = "";
                        document.querySelector('[name="telefono_fijo_contacto_emergencia"]').value = "";
                    }
                } else {
                    alert("Por favor, completa todos los campos obligatorios.");
                }
            });

            // Evento para agregar nuevo idioma
            document.getElementById("agregarIdioma").addEventListener("click", function() {
                const idioma = document.querySelector('[name="idioma"]').value;
                const lectura = document.querySelector('[name="lectura"]').value;
                const escritura = document.querySelector('[name="escritura"]').value;
                const conversacion = document.querySelector('[name="conversacion"]').value;

                if (idioma && lectura && escritura && conversacion) {
                    // Si estamos en modo "Actualizar", no agregamos una nueva fila, solo actualizamos la existente
                    if (this.dataset.editingRow) {
                        actualizarIdioma();
                    } else {
                        // Concatenar los botones dentro de una sola celda
                        const botones =
                            `<button class="btn-edit" onclick="editarIdioma(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" fill="#007bff">
                        <path d="M362.7 19.3L315.3 66.7 445.3 196.7l47.4-47.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zM289.4 92.7L39.2 342.9c-10.5 10.5-17.7 24-20.7 38.6L.2 494.2c-1.5 7.4 5.2 14.2 12.6 12.6l112.7-18.3c14.6-3 28.1-10.2 38.6-20.7L419.3 218.6 289.4 92.7z"/>
                    </svg>
                </button>
                <button class="btn-delete" onclick="borrarIdioma(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20" height="20" fill="#dc3545">
                        <path d="M135.2 17.7c5.9-10.6 17.1-17.7 29.4-17.7H283.4c12.3 0 23.5 6.6 29.4 17.7l11.9 21.3H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H123.3l11.9-21.3zM53.2 467C50.9 490.2 69.6 512 93 512H355c23.4 0 42.1-21.8 39.8-45L360.2 128H87.8L53.2 467z"/>
                    </svg>
                </button>`;

                        // Insertar una nueva fila en la tabla
                        idiomasTable.row.add([
                            idioma,
                            lectura,
                            escritura,
                            conversacion,
                            botones // Aquí se agregan ambos botones en una sola celda
                        ]).draw();

                        // Limpiar los campos después de agregar
                        document.querySelector('[name="idioma"]').value = "";
                        document.querySelector('[name="lectura"]').value = "";
                        document.querySelector('[name="escritura"]').value = "";
                        document.querySelector('[name="conversacion"]').value = "";
                    }
                } else {
                    alert("Por favor, completa todos los campos obligatorios.");
                }
            });

            // Cursos Complementarios
            document.getElementById("agregarCurso").addEventListener("click", function() {
                const curso = document.querySelector('[name="curso"]').value;
                const anio = document.querySelector('[name="anio"]').value;
                const certificado = document.querySelector('[name="certificado"]').value;

                if (curso && anio && certificado) {
                    // Si estamos en modo "Actualizar", no agregamos una nueva fila, solo actualizamos la existente
                    if (this.dataset.editingRow) {
                        actualizarCursoComplementario();
                    } else {
                        // Concatenar los botones dentro de una sola celda
                        const botones =
                            `<button class="btn-edit" onclick="editarCursoComplementario(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" fill="#007bff">
                                    <path d="M362.7 19.3L315.3 66.7 445.3 196.7l47.4-47.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zM289.4 92.7L39.2 342.9c-10.5 10.5-17.7 24-20.7 38.6L.2 494.2c-1.5 7.4 5.2 14.2 12.6 12.6l112.7-18.3c14.6-3 28.1-10.2 38.6-20.7L419.3 218.6 289.4 92.7z"/>
                                </svg>
                            </button>
                            <button class="btn-delete" onclick="borrarCursosComplementarios(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20" height="20" fill="#dc3545">
                                    <path d="M135.2 17.7c5.9-10.6 17.1-17.7 29.4-17.7H283.4c12.3 0 23.5 6.6 29.4 17.7l11.9 21.3H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H123.3l11.9-21.3zM53.2 467C50.9 490.2 69.6 512 93 512H355c23.4 0 42.1-21.8 39.8-45L360.2 128H87.8L53.2 467z"/>
                                </svg>
                            </button>`;

                        // Insertar una nueva fila en la tabla
                        cursosComplementariosTable.row.add([
                            curso,
                            anio,
                            certificado,
                            botones // Aquí se agregan ambos botones en una sola celda
                        ]).draw();
                        // Limpiar los campos después de agregar
                        document.querySelector('[name="curso"]').value = "";
                        document.querySelector('[name="anio"]').value = "";
                        document.querySelector('[name="certificado"]').value = "";
                    }
                } else {
                    alert("Por favor, completa todos los campos obligatorios.");
                }
            });

            // Experiencia Laboral
            document.getElementById("agregarExperiencia").addEventListener("click", function() {
                const empresa = document.querySelector('[name="empresa"]').value;
                const cargo = document.querySelector('[name="cargo"]').value;
                const fecha_inicio = document.querySelector('[name="fecha_inicio"]').value;
                const fecha_fin = document.querySelector('[name="fecha_fin"]').value;
                const motivo_salida = document.querySelector('[name="motivo_salida"]').value;
                const importe_remuneracion = document.querySelector('[name="importe_remuneracion"]').value;
                const nombre_referencia = document.querySelector('[name="nombre_referencia"]').value;
                const numero_contacto = document.querySelector('[name="numero_contacto"]').value;
                const certificado_exp = document.querySelector('[name="certificado_exp"]').value;

                if (empresa && cargo && fecha_inicio && fecha_fin && motivo_salida &&
                    importe_remuneracion && nombre_referencia && numero_contacto && certificado_exp) {
                    // Si estamos en modo "Actualizar", no agregamos una nueva fila, solo actualizamos la existente
                    if (this.dataset.editingRow) {
                        console.log("##11111")
                        actualizarExperiencia();
                        console.log("##222")

                    } else {
                        // Concatenar los botones dentro de una sola celda
                        const botones =
                            `<button class="btn-edit" onclick="editarExperiencia(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" fill="#007bff">
                                    <path d="M362.7 19.3L315.3 66.7 445.3 196.7l47.4-47.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zM289.4 92.7L39.2 342.9c-10.5 10.5-17.7 24-20.7 38.6L.2 494.2c-1.5 7.4 5.2 14.2 12.6 12.6l112.7-18.3c14.6-3 28.1-10.2 38.6-20.7L419.3 218.6 289.4 92.7z"/>
                                </svg>
                            </button>
                            <button class="btn-delete" onclick="borrarExperiencia(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20" height="20" fill="#dc3545">
                                    <path d="M135.2 17.7c5.9-10.6 17.1-17.7 29.4-17.7H283.4c12.3 0 23.5 6.6 29.4 17.7l11.9 21.3H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H123.3l11.9-21.3zM53.2 467C50.9 490.2 69.6 512 93 512H355c23.4 0 42.1-21.8 39.8-45L360.2 128H87.8L53.2 467z"/>
                                </svg>
                            </button>`;

                        // Insertar una nueva fila en la tabla
                        experienciaTable.row.add([
                            empresa,
                            cargo,
                            fecha_inicio,
                            fecha_fin,
                            motivo_salida,
                            importe_remuneracion,
                            nombre_referencia,
                            numero_contacto,
                            certificado_exp,
                            botones // Aquí se agregan ambos botones en una sola celda
                        ]).draw();
                        // Limpiar los campos después de agregar
                        document.querySelector('[name="empresa"]').value = "";
                        document.querySelector('[name="cargo"]').value = "";
                        document.querySelector('[name="fecha_inicio"]').value = "";
                        document.querySelector('[name="fecha_fin"]').value = "";
                        document.querySelector('[name="motivo_salida"]').value = "";
                        document.querySelector('[name="importe_remuneracion"]').value = "";
                        document.querySelector('[name="nombre_referencia"]').value = "";
                        document.querySelector('[name="numero_contacto"]').value = "";
                        document.querySelector('[name="certificado_exp"]').value = "";
                    }
                } else {
                    alert("Por favor, completa todos los campos obligatorios.");
                }
            });
        });





        document.getElementById('sistema_afp').addEventListener('change', function() {
            var selectedValue = this.value;
            var afpChooseContainer = document.getElementById('afp-choose-container');
            var afpSelect = document.getElementById('afp');

            if (selectedValue === 'AFP') {
                afpChooseContainer.style.display = 'block';
                afpSelect.disabled = false;
            } else {
                afpChooseContainer.style.display = 'none';
                afpSelect.disabled = true;
            }
        });







        // Cursos Complementarios
        function borrarCursosComplementarios(button) {
            const row = button.closest('tr');
            event.preventDefault();
            const table = document.getElementById("tablaCursos");
            table.deleteRow(row.rowIndex);
        }

        function editarCursoComplementario(button) {
            const row = button.closest('tr');
            event.preventDefault();

            // Obtener los valores de la fila
            const curso = row.cells[0].textContent;
            const anio = row.cells[1].textContent;
            const certificado = row.cells[2].textContent;

            // Rellenar los campos del formulario con los valores de la fila
            document.querySelector('[name="curso"]').value = curso;
            document.querySelector('[name="anio"]').value = anio;
            // document.querySelector('[name="certificado"]').value = certificado;


            const agregarBtn = document.getElementById("agregarCurso");

            // Guardar la fila en edición como atributo del botón
            agregarBtn.dataset.editingRow = row.rowIndex;

            // Cambiar el texto del botón
            agregarBtn.textContent = "Actualizar";

            // Cambiar el evento onclick del botón para actualizar en lugar de agregar
            agregarBtn.onclick = function(event) {
                event.preventDefault(); // Evita que el formulario se recargue
                actualizarCursoComplementario();
            };
        }

        function actualizarCursoComplementario() {
            const agregarBtn = document.getElementById("agregarCurso");
            // Obtener la fila en edición
            const rowIndex = agregarBtn.dataset.editingRow;
            if (!rowIndex) return; // Si no hay fila en edición, salir
            const table = document.getElementById("tablaCursos");
            const row = table.rows[rowIndex];

            // Actualizar los valores de la fila
            row.cells[0].textContent = document.querySelector('[name="curso"]').value;;
            row.cells[1].textContent = document.querySelector('[name="anio"]').value;
            row.cells[2].textContent = document.querySelector('[name="certificado"]').value;

            // Limpiar los campos después de actualizar
            document.querySelector('[name="curso"]').value = "";
            document.querySelector('[name="anio"]').value = "";
            document.querySelector('[name="certificado"]').value = "";

            // Restablecer el botón a "Agregar"
            agregarBtn.textContent = "Agregar";
            delete agregarBtn.dataset.editingRow; // Eliminar el estado de edición

            // Restaurar el evento original para agregar nuevas filas
            agregarBtn.onclick = function(event) {
                event.preventDefault();

            };
        }





        // Conocimientos de Idiomas
        function borrarIdioma(button) {
            const row = button.closest('tr');
            event.preventDefault();
            const table = document.getElementById("tablaIdiomas");
            table.deleteRow(row.rowIndex);
        }

        function editarIdioma(button) {
            const row = button.closest('tr');
            event.preventDefault();

            // Obtener los valores de la fila
            const idioma = row.cells[0].textContent;
            const lectura = row.cells[1].textContent;
            const escritura = row.cells[2].textContent;
            const conversacion = row.cells[3].textContent;

            // Rellenar los campos del formulario con los valores de la fila
            document.querySelector('[name="idioma"]').value = idioma;
            document.querySelector('[name="lectura"]').value = lectura;
            document.querySelector('[name="escritura"]').value = escritura;
            document.querySelector('[name="celular_ref"]').value = conversacion;


            const agregarBtn = document.getElementById("agregarIdioma");
            // Guardar la fila en edición como atributo del botón
            agregarBtn.dataset.editingRow = row.rowIndex;
            // Cambiar el texto del botón
            agregarBtn.textContent = "Actualizar";
            // Cambiar el evento onclick del botón para actualizar en lugar de agregar
            agregarBtn.onclick = function(event) {
                event.preventDefault(); // Evita que el formulario se recargue
                actualizarIdioma();
            };
        }

        function actualizarIdioma() {
            const agregarBtn = document.getElementById("agregarIdioma");
            // Obtener la fila en edición
            const rowIndex = agregarBtn.dataset.editingRow;
            if (!rowIndex) return; // Si no hay fila en edición, salir

            const table = document.getElementById("tablaIdiomas");
            const row = table.rows[rowIndex];

            // Actualizar los valores de la fila
            row.cells[0].textContent = document.querySelector('[name="idioma"]').value;;
            row.cells[1].textContent = document.querySelector('[name="lectura"]').value;
            row.cells[2].textContent = document.querySelector('[name="escritura"]').value;
            row.cells[3].textContent = document.querySelector('[name="conversacion"]').value;

            // Limpiar los campos después de actualizar
            document.querySelector('[name="idioma"]').value = "";
            document.querySelector('[name="lectura"]').value = "";
            document.querySelector('[name="escritura"]').value = "";
            document.querySelector('[name="conversacion"]').value = "";

            // Restablecer el botón a "Agregar"
            agregarBtn.textContent = "Agregar";
            delete agregarBtn.dataset.editingRow; // Eliminar el estado de edición

            // Restaurar el evento original para agregar nuevas filas
            agregarBtn.onclick = function(event) {
                event.preventDefault();

            };
        }




        // Referencias Familiares
        function borrarReferencia(button) {
            const row = button.closest('tr');
            event.preventDefault();
            const table = document.getElementById("tablaReferencias");
            table.deleteRow(row.rowIndex);
        }

        function editarReferencia(button) {
            const row = button.closest('tr');
            event.preventDefault();

            // Obtener los valores de la fila
            const nombreFamiliar = row.cells[0].textContent;
            const parentesco = row.cells[1].textContent;
            const fechaNacimiento = row.cells[2].textContent;
            const celular = row.cells[3].textContent;
            const celular2 = row.cells[4].textContent;
            const telefonoFijo = row.cells[5].textContent;

            // Rellenar los campos del formulario con los valores de la fila
            document.querySelector('[name="nombre_familiar"]').value = nombreFamiliar;
            document.querySelector('[name="parentesco"]').value = parentesco;
            document.querySelector('[name="fecha_nacimiento_ref"]').value = fechaNacimiento;
            document.querySelector('[name="celular_ref"]').value = celular;
            document.querySelector('[name="celular_ref2"]').value = celular2;
            document.querySelector('[name="telefono_fijo"]').value = telefonoFijo;

            const agregarBtn = document.getElementById("agregarReferencia");

            // Guardar la fila en edición como atributo del botón
            agregarBtn.dataset.editingRow = row.rowIndex;

            // Cambiar el texto del botón
            agregarBtn.textContent = "Actualizar";

            // Cambiar el evento onclick del botón para actualizar en lugar de agregar
            agregarBtn.onclick = function(event) {
                event.preventDefault(); // Evita que el formulario se recargue
                actualizarReferencia();
            };
        }

        function actualizarReferencia() {
            const agregarBtn = document.getElementById("agregarReferencia");

            // Obtener la fila en edición
            const rowIndex = agregarBtn.dataset.editingRow;
            if (!rowIndex) return; // Si no hay fila en edición, salir

            const table = document.getElementById("tablaReferencias");
            const row = table.rows[rowIndex];

            // Actualizar los valores de la fila
            row.cells[0].textContent = document.querySelector('[name="nombre_familiar"]').value;
            row.cells[1].textContent = document.querySelector('[name="parentesco"]').value;
            row.cells[2].textContent = document.querySelector('[name="fecha_nacimiento_ref"]').value;
            row.cells[3].textContent = document.querySelector('[name="celular_ref"]').value;
            row.cells[4].textContent = document.querySelector('[name="celular_ref2"]').value;
            row.cells[5].textContent = document.querySelector('[name="telefono_fijo"]').value;

            // Limpiar los campos después de actualizar
            document.querySelector('[name="nombre_familiar"]').value = "";
            document.querySelector('[name="parentesco"]').value = "";
            document.querySelector('[name="fecha_nacimiento_ref"]').value = "";
            document.querySelector('[name="celular_ref"]').value = "";
            document.querySelector('[name="celular_ref2"]').value = "";
            document.querySelector('[name="telefono_fijo"]').value = "";

            // Restablecer el botón a "Agregar"
            agregarBtn.textContent = "Agregar";
            delete agregarBtn.dataset.editingRow; // Eliminar el estado de edición

            // Restaurar el evento original para agregar nuevas filas
            agregarBtn.onclick = function(event) {
                event.preventDefault();

            };
        }


        // Contacto de Emergencia   
        function borrarContactoEmergencia(button) {
            const row = button.closest('tr');
            event.preventDefault();
            const table = document.getElementById("tablaReferencias");
            table.deleteRow(row.rowIndex);
        }

        function editarContactoEmergencia(button) {
            const row = button.closest('tr');
            event.preventDefault();

            // Obtener los valores de la fila
            const nombreContacto = row.cells[0].textContent;
            const parentesco = row.cells[1].textContent;
            const celular = row.cells[2].textContent;
            const celular2 = row.cells[3].textContent;
            const telefonoFijo = row.cells[4].textContent;

            // Rellenar los campos del formulario con los valores de la fila
            document.querySelector('[name="nombre_contacto_emergencia"]').value = nombreContacto;
            document.querySelector('[name="parentesco_contacto_emergencia"]').value = parentesco;
            document.querySelector('[name="celular_contacto_emergencia"]').value = celular;
            document.querySelector('[name="celular2_contacto_emergencia"]').value = celular2;
            document.querySelector('[name="telefono_fijo_contacto_emergencia"]').value = telefonoFijo;

            const agregarBtn = document.getElementById("agregarContactoEmergencia");

            // Guardar la fila en edición como atributo del botón
            agregarBtn.dataset.editingRow = row.rowIndex;

            // Cambiar el texto del botón
            agregarBtn.textContent = "Actualizar";

            // Cambiar el evento onclick del botón para actualizar en lugar de agregar
            agregarBtn.onclick = function(event) {
                event.preventDefault(); // Evita que el formulario se recargue
                actualizarContactoEmergencia();
            };
        }

        function actualizarContactoEmergencia() {
            const agregarBtn = document.getElementById("agregarContactoEmergencia");

            // Obtener la fila en edición
            const rowIndex = agregarBtn.dataset.editingRow;
            if (!rowIndex) return; // Si no hay fila en edición, salir

            const table = document.getElementById("tabla_contactos_emergencia");
            const row = table.rows[rowIndex];

            // Actualizar los valores de la fila
            row.cells[0].textContent = document.querySelector('[name="nombre_contacto_emergencia"]').value;
            row.cells[1].textContent = document.querySelector('[name="parentesco_contacto_emergencia"]').value;
            row.cells[2].textContent = document.querySelector('[name="celular_contacto_emergencia"]').value;
            row.cells[3].textContent = document.querySelector('[name="celular2_contacto_emergencia"]').value;
            row.cells[4].textContent = document.querySelector('[name="telefono_fijo_contacto_emergencia"]').value;

            // Limpiar los campos después de actualizar
            document.querySelector('[name="nombre_contacto_emergencia"]').value = "";
            document.querySelector('[name="parentesco_contacto_emergencia"]').value = "";
            document.querySelector('[name="celular_contacto_emergencia"]').value = "";
            document.querySelector('[name="celular2_contacto_emergencia"]').value = "";
            document.querySelector('[name="telefono_fijo_contacto_emergencia"]').value = "";

            // Restablecer el botón a "Agregar"
            agregarBtn.textContent = "Agregar";
            delete agregarBtn.dataset.editingRow; // Eliminar el estado de edición

            // Restaurar el evento original para agregar nuevas filas
            agregarBtn.onclick = function(event) {
                event.preventDefault();
                agregarContactoEmergencia();
            };
        }



        function toggleBankEntityInput() {
            var cuentaBancaria = document.getElementById('cuenta_bancaria').value;
            var entidadBancariaContainer = document.getElementById('entidad-bancaria-container');
            var entidadSelect = document.getElementById('entidad_bancaria');

            if (cuentaBancaria === 'si') {
                entidadBancariaContainer.style.display = 'block';
                entidadSelect.disabled = false;
            } else {
                entidadBancariaContainer.style.display = 'none';
                entidadSelect.disabled = true;
            }
        }


        function toggleSystemInput() {
            var sistemaPensionario = document.getElementById('sistema_pensionario').value;
            var sistemaSelectContainer = document.getElementById('sistema-select-container');
            var afpChooseContainer = document.getElementById('afp-choose-container');
            var sistemaAfpSelect = document.getElementById('sistema_afp');
            var afpSelect = document.getElementById('afp');

            if (sistemaPensionario === 'si') {
                sistemaSelectContainer.style.display = 'block';
                sistemaAfpSelect.disabled = false;
            } else {
                sistemaSelectContainer.style.display = 'none';
                afpChooseContainer.style.display = 'none';
                sistemaAfpSelect.disabled = true;
                afpSelect.disabled = true;
            }
        }




        function editarExperiencia(button) {
            const row = button.closest('tr');
            event.preventDefault();

            const empresa = row.cells[0].textContent;
            const cargo = row.cells[1].textContent;
            const fechaInicio = row.cells[2].textContent;
            const fechaFin = row.cells[3].textContent;
            const motivoSalida = row.cells[4].textContent;
            const importeRemuneracion = row.cells[5].textContent;
            const nombreReferencia = row.cells[6].textContent;
            const numeroContacto = row.cells[7].textContent;
            // const certificado = row.cells[8].textContent;

            // Rellenar los campos del formulario con los datos de la fila seleccionada
            document.querySelector('[name="empresa"]').value = empresa;
            document.querySelector('[name="cargo"]').value = cargo;
            document.querySelector('[name="fecha_inicio"]').value = fechaInicio;
            document.querySelector('[name="fecha_fin"]').value = fechaFin;
            document.querySelector('[name="motivo_salida"]').value = motivoSalida;
            document.querySelector('[name="importe_remuneracion"]').value = importeRemuneracion;
            document.querySelector('[name="nombre_referencia"]').value = nombreReferencia;
            document.querySelector('[name="numero_contacto"]').value = numeroContacto;

            const agregarBtn = document.getElementById("agregarExperiencia");
            // Guardar la fila en edición como atributo del botón
            agregarBtn.dataset.editingRow = row.rowIndex;
            // Cambiar el texto del botón
            agregarBtn.textContent = "Actualizar";
            // Cambiar el evento onclick del botón para actualizar en lugar de agregar
            agregarBtn.onclick = function(event) {
                event.preventDefault(); // Evita que el formulario se recargue
                actualizarExperiencia();
            };
        }

        function actualizarExperiencia() {
            const agregarBtn = document.getElementById("agregarExperiencia");
            // Obtener la fila en edición
            const rowIndex = agregarBtn.dataset.editingRow;
            if (!rowIndex) return; // Si no hay fila en edición, salir

            const table = document.getElementById("tablaExperiencia");
            const row = table.rows[rowIndex];

            // Actualizar los valores de la fila
            row.cells[0].textContent = document.querySelector('[name="empresa"]').value;;
            row.cells[1].textContent = document.querySelector('[name="cargo"]').value;
            row.cells[2].textContent = document.querySelector('[name="fecha_inicio"]').value;
            row.cells[3].textContent = document.querySelector('[name="fecha_fin"]').value;
            row.cells[4].textContent = document.querySelector('[name="motivo_salida"]').value;
            row.cells[5].textContent = document.querySelector('[name="importe_remuneracion"]').value;
            row.cells[6].textContent = document.querySelector('[name="nombre_referencia"]').value;
            row.cells[7].textContent = document.querySelector('[name="numero_contacto"]').value;
            row.cells[8].textContent = document.querySelector('[name="certificado_exp"]').value;

            // Limpiar los campos después de actualizar
            document.querySelector('[name="empresa"]').value = "";
            document.querySelector('[name="cargo"]').value = "";
            document.querySelector('[name="fecha_inicio"]').value = "";
            document.querySelector('[name="fecha_fin"]').value = "";
            document.querySelector('[name="motivo_salida"]').value = "";
            document.querySelector('[name="importe_remuneracion"]').value = "";
            document.querySelector('[name="nombre_referencia"]').value = "";
            document.querySelector('[name="certificado_exp"]').value = "";

            // Restablecer el botón a "Agregar"
            agregarBtn.textContent = "Agregar";
            delete agregarBtn.dataset.editingRow; // Eliminar el estado de edición

            // Restaurar el evento original para agregar nuevas filas
            agregarBtn.onclick = function(event) {
                event.preventDefault();

            };
        }





        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: -12.0464,
                    lng: -77.0428
                },
                zoom: 12
            });
        }

        function previewImage(event) {
            var input = event.target;
            var file = input.files[0];

            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Asegúrate de que el contenedor tenga un tamaño
                    var container = document.getElementById('uploadContainer');
                    container.style.backgroundImage = "url('" + e.target.result + "')";
                };
                reader.readAsDataURL(file);
            }
        }

        // Función para previsualizar archivos
        function previsualizarArchivo(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            // Limpiar la vista previa
            preview.innerHTML = '';

            if (file) {
                const reader = new FileReader();

                // Previsualización para imagen
                if (file.type.startsWith('image/')) {
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px'; // Tamaño de la imagen
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
                // Previsualización para PDF
                else if (file.type === 'application/pdf') {
                    const object = document.createElement('object');
                    object.data = URL.createObjectURL(file);
                    object.type = 'application/pdf';
                    object.style.width = '100%';
                    object.style.height = '300px'; // Ajusta el tamaño del PDF
                    preview.appendChild(object);
                }
                // Para otros tipos de archivo
                else {
                    preview.innerHTML = '<p>Archivo no compatible para previsualización.</p>';
                }
            }
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap"></script>

@endsection
