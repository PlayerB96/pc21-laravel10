<template>
    <div class="layout-container-section-content">
        <h2>Registro de POSTULANTES</h2>
        <div class="widget-container-section-content">

            <div class="upload-container" id="uploadContainer">
                <input type="file" id="foto" name="foto" accept="image/*" @change="previewImage">
                <p>Actualizar imagen</p>
            </div>

            <form @submit.prevent="submitForm">
                <div class="form-container-postulante">
                    <FormSection v-for="(section, index) in sections" :key="index" :section="section"
                        :model="form[section.model]" @agregar-referencia="agregarReferencia"
                        @agregar-contacto-emergencia="agregarContactoEmergencia" @agregar-idioma="agregarIdioma"
                        @agregar-curso="agregarCurso" @agregar-experiencia="agregarExperiencia">
                        <template v-if="section.model === 'nuevaReferencia'" #default>
                            <div v-if="form.referenciasFamiliares.length > 0" class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nombre de Familiar</th>
                                            <th>Parentesco</th>
                                            <th>Fecha de Nacimiento</th>
                                            <th>Celular</th>
                                            <th>Celular 2</th>
                                            <th>Teléfono Fijo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(referencia, index) in form.referenciasFamiliares" :key="index">
                                            <td>{{ referencia.nombre_familiar }}</td>
                                            <td>{{ referencia.parentesco }}</td>
                                            <td>{{ referencia.fecha_nacimiento_ref }}</td>
                                            <td>{{ referencia.celular_ref }}</td>
                                            <td>{{ referencia.celular_ref2 }}</td>
                                            <td>{{ referencia.telefono_fijo }}</td>
                                            <td>
                                                <button @click="eliminarReferencia(index, $event)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                        <template v-if="section.model === 'nuevoContactoEmergencia'" #default>
                            <div v-if="form.contactosEmergencia.length > 0" class="table-responsive">
                                <table class="table">
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
                                        <tr v-for="(contacto, index) in form.contactosEmergencia" :key="index">
                                            <td>{{ contacto.nombre_contacto_emergencia }}</td>
                                            <td>{{ contacto.parentesco_contacto_emergencia }}</td>
                                            <td>{{ contacto.celular_contacto_emergencia }}</td>
                                            <td>{{ contacto.celular2_contacto_emergencia }}</td>
                                            <td>{{ contacto.telefono_fijo_contacto_emergencia }}</td>
                                            <td>
                                                <button
                                                    @click="eliminarContactoEmergencia(index, $event)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                        <template v-if="section.model === 'nuevoIdioma'" #default>
                            <div v-if="form.idiomas.length > 0" class="table-responsive">
                                <table class="table">
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
                                        <tr v-for="(idioma, index) in form.idiomas" :key="index">
                                            <td>{{ idioma.idioma }}</td>
                                            <td>{{ idioma.lectura }}</td>
                                            <td>{{ idioma.escritura }}</td>
                                            <td>{{ idioma.conversacion }}</td>
                                            <td>
                                                <button @click="eliminarIdioma(index, $event)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                        <template v-if="section.model === 'nuevoCurso'" #default>
                            <div v-if="form.cursos.length > 0" class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Curso</th>
                                            <th>Año</th>
                                            <th>Certificado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(curso, index) in form.cursos" :key="index">
                                            <td>{{ curso.curso }}</td>
                                            <td>{{ curso.anio }}</td>
                                            <td>{{ curso.certificado }}</td>
                                            <td>
                                                <button @click="eliminarIdioma(index, $event)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                        <template v-if="section.model === 'nuevaExperienciaLaboral'" #default>
                            <div v-if="form.experienciasLaborales.length > 0" class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Cargo</th>
                                            <th>Fecha de Inicio</th>
                                            <th>Fecha de Fin</th>
                                            <th>Descripción</th>
                                            <th>Motivo de Salida</th>
                                            <th>Importe de Remuneración</th>
                                            <th>Nombre Referencia</th>
                                            <th>Número Contacto Referencia</th>
                                            <th>Constancia</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(experiencia, index) in form.experienciasLaborales" :key="index">
                                            <td>{{ experiencia.empresa }}</td>
                                            <td>{{ experiencia.cargo }}</td>
                                            <td>{{ experiencia.fecha_inicio }}</td>
                                            <td>{{ experiencia.fecha_fin }}</td>
                                            <td>{{ experiencia.descripcion }}</td>
                                            <td>{{ experiencia.motivo_salida }}</td>
                                            <td>{{ experiencia.importe_remuneracion }}</td>
                                            <td>{{ experiencia.nombre_referencia }}</td>
                                            <td>{{ experiencia.numero_contacto_referencia }}
                                            </td>
                                            <td>{{ experiencia.constancia }}</td>
                                            <td>
                                                <button @click="eliminarExperiencia(index, $event)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                    </FormSection>
                </div>
                <button type="submit" class="btn-primary-postulante">Registrar Postulante</button>
            </form>
        </div>
    </div>
</template>

<script>
import FormSection from '../../components/formularios/FormSection.vue';

export default {
    components: {
        FormSection
    },
    data() {
        return {
            form: {
                personalInfo: {
                    apellido_paterno: '',
                    apellido_materno: '',
                    nombres: '',
                    nacionalidad: 'Peruano',
                    estado_civil: 'Soltero',
                    fecha_nacimiento: '',
                    edad: '',
                    genero: 'Mujer',
                    tipo_documento: 'DNI',
                    numero_documento: '',
                    correo: '',
                    celular: '',
                    telefono: ''
                },
                domicilio: {
                    tipo_via: '',
                    nombre_via: '',
                    numero_via: '',
                    km: '',
                    mz: '',
                    interior: '',
                    numero_departamento: '',
                    lote: '',
                    piso: '',
                    tipo_zona: '',
                    nombre_zona: '',
                    tipo_vivienda: '',
                    referencia_domicilio: '',
                    direccion_completa: ''
                },
                gustosPreferencias: {
                    plato_postre_favorito: '',
                    galletas_golosinas_favoritas: '',
                    actividades_ocio: '',
                    artistas_banda_favorita: '',
                    genero_musical_favorito: '',
                    pelicula_serie_favorita: '',
                    colores_favoritos: '',
                    redes_sociales_favoritas: '',
                    deporte_favorito: '',
                    tiene_mascota: '',
                    tipo_mascota: ''
                },
                referenciasFamiliares: [],
                nuevaReferencia: {
                    nombre_familiar: '',
                    parentesco: '',
                    fecha_nacimiento_ref: '',
                    celular_ref: '',
                    celular_ref2: '',
                    telefono_fijo: ''
                },
                contactosEmergencia: [],
                nuevoContactoEmergencia: {
                    nombre_contacto_emergencia: '',
                    parentesco_contacto_emergencia: '',
                    celular_contacto_emergencia: '',
                    celular2_contacto_emergencia: '',
                    telefono_fijo_contacto_emergencia: ''
                },
                hijos: [],
                nuevoHijo: {
                    respuesta: '',
                    nombre_hijo: '',
                    genero_hijo: '',
                    fecha_nacimiento_hijo: '',
                    dni_hijo: '',
                    biologico: '',
                    dni_file: ''
                },
                conocimientoOffice: {
                    nivel_excel: '',
                    nivel_word: '',
                    nivel_powerpoint: '',
                },
                idiomas: [],
                nuevoIdioma: {
                    idioma: '',
                    lectura: '',
                    escritura: '',
                    conversacion: '',

                },
                cursos: [],
                nuevoCurso: {
                    curso: '',
                    anio: '',
                    certificado: '',
                },
                experienciasLaborales: [],
                nuevaExperienciaLaboral: {
                    empresa: '',
                    cargo: '',
                    fecha_inicio: '',
                    fecha_fin: '',
                    descripcion: '',
                    motivo_salida: '',
                    importe_remuneracion: '',
                    nombre_referencia: '',
                    numero_contacto_referencia: '',
                    constancia: ''
                }
            },
            sections: [
                {
                    title: 'Información Personal',
                    model: 'personalInfo',
                    fields: [
                        { label: 'Apellido Paterno', name: 'apellido_paterno', type: 'text', required: true },
                        { label: 'Apellido Materno', name: 'apellido_materno', type: 'text', required: true },
                        { label: 'Nombres', name: 'nombres', type: 'text', required: true },
                        { label: 'Nacionalidad', name: 'nacionalidad', type: 'select', options: ['Peruano', 'Colombiano', 'Venezolano'], required: true },
                        { label: 'Estado Civil', name: 'estado_civil', type: 'select', options: ['Soltero', 'Casado', 'Divorciado', 'Viudo'], required: true },
                        { label: 'Fecha de Nacimiento', name: 'fecha_nacimiento', type: 'date', required: true },
                        { label: 'Edad', name: 'edad', type: 'number', required: true },
                        { label: 'Género', name: 'genero', type: 'select', options: ['Mujer', 'Hombre'], required: true },
                        { label: 'Tipo de Documento', name: 'tipo_documento', type: 'select', options: ['DNI', 'Pasaporte'], required: true },
                        { label: 'Número de Documento', name: 'numero_documento', type: 'number', required: true },
                        { label: 'Correo Electrónico', name: 'correo', type: 'email', required: true },
                        { label: 'Número Celular', name: 'celular', type: 'number', required: true },
                        { label: 'Teléfono Fijo', name: 'telefono', type: 'number', required: true }
                    ]
                },
                {
                    title: 'Domicilio',
                    model: 'domicilio',
                    fields: [
                        { label: 'Tipo de vía', name: 'tipo_via', type: 'text', required: true },
                        { label: 'Nombre de vía', name: 'nombre_via', type: 'text', required: true },
                        { label: 'Número de vía', name: 'numero_via', type: 'text', required: true },
                        { label: 'KM', name: 'km', type: 'text', required: true },
                        { label: 'MZ', name: 'mz', type: 'text', required: true },
                        { label: 'Interior', name: 'interior', type: 'text', required: true },
                        { label: 'N° Departamento', name: 'numero_departamento', type: 'text', required: true },
                        { label: 'Lote', name: 'lote', type: 'text', required: true },
                        { label: 'Piso', name: 'piso', type: 'text', required: true },
                        { label: 'Tipo de Zona', name: 'tipo_zona', type: 'text', required: true },
                        { label: 'Nombre Zona', name: 'nombre_zona', type: 'text', required: true },
                        { label: 'Tipo de vivienda', name: 'tipo_vivienda', type: 'text', required: true },
                        { label: 'Referencia Domicilio', name: 'referencia_domicilio', type: 'text', required: true },
                        { label: 'Dirección Completa', name: 'direccion_completa', type: 'text', required: true }
                    ]
                },
                {
                    title: 'Gustos y Preferencias',
                    model: 'gustosPreferencias',
                    fields: [
                        { label: 'Plato y postre favorito', name: 'plato_postre_favorito', type: 'text', required: true },
                        { label: 'Galletas y golosinas favoritas', name: 'galletas_golosinas_favoritas', type: 'text', required: true },
                        { label: 'Actividades de ocio o pasatiempos', name: 'actividades_ocio', type: 'text', required: true },
                        { label: 'Artistas o banda favorita', name: 'artistas_banda_favorita', type: 'text', required: true },
                        { label: 'Género musical favorito', name: 'genero_musical_favorito', type: 'text', required: true },
                        { label: 'Película o serie favorita', name: 'pelicula_serie_favorita', type: 'text', required: true },
                        { label: 'Colores favoritos', name: 'colores_favoritos', type: 'text', required: true },
                        { label: 'Redes sociales favoritas', name: 'redes_sociales_favoritas', type: 'text', required: true },
                        { label: 'Deporte favorito', name: 'deporte_favorito', type: 'text', required: true },
                        { label: '¿Tiene mascota?', name: 'tiene_mascota', type: 'select', options: ['Seleccione', 'Sí', 'No'], required: true },
                        { label: 'Qué mascota tienes?', name: 'tipo_mascota', type: 'text', required: true }
                    ]
                },
                {
                    title: 'Referencias Familiares',
                    model: 'nuevaReferencia',
                    fields: [
                        { label: 'Nombre de Familiar', name: 'nombre_familiar', type: 'text', required: true },
                        { label: 'Parentesco', name: 'parentesco', type: 'select', options: ['Seleccione', 'Madre', 'Padre', 'Hermano', 'Hermana', 'Otro'], required: true },
                        { label: 'Fecha de Nacimiento', name: 'fecha_nacimiento_ref', type: 'date', required: true },
                        { label: 'Celular', name: 'celular_ref', type: 'number', required: true },
                        { label: 'Celular 2', name: 'celular_ref2', type: 'number' },
                        { label: 'Teléfono Fijo', name: 'telefono_fijo', type: 'number' },
                    ]
                },
                {
                    title: 'Datos de Hijos/as',
                    model: 'nuevoHijo',
                    fields: [
                        { label: '¿Respuesta?', name: 'respuesta', type: 'select', options: ['Sí', 'No'], required: true },
                        { label: 'Nombre de Hijo/a', name: 'nombre_hijo', type: 'text', required: true },
                        { label: 'Género', name: 'genero_hijo', type: 'select', options: ['Masculino', 'Femenino', 'Otro'], required: true },
                        { label: 'Fecha de Nacimiento', name: 'fecha_nacimiento_hijo', type: 'date', required: true },
                        { label: 'DNI', name: 'dni_hijo', type: 'text', required: true },
                        { label: 'Biológico/No Biológico', name: 'biologico', type: 'select', options: ['Sí', 'No'], required: true },
                        { label: 'Adjuntar DNI', name: 'dni_file', type: 'file', required: true }
                    ]
                },
                {
                    title: 'Contacto de Emergencia',
                    model: 'nuevoContactoEmergencia',
                    fields: [
                        { label: 'Nombre de Contacto', name: 'nombre_contacto_emergencia', type: 'text', required: true },
                        { label: 'Parentesco', name: 'parentesco_contacto_emergencia', type: 'select', options: ['Padre', 'Madre', 'Hermano/a', 'Amigo/a', 'Otro'], required: true },
                        { label: 'Celular', name: 'celular_contacto_emergencia', type: 'number', required: true },
                        { label: 'Celular 2', name: 'celular2_contacto_emergencia', type: 'number' },
                        { label: 'Teléfono Fijo', name: 'telefono_fijo_contacto_emergencia', type: 'number' }
                    ]
                },
                {
                    title: 'Conocimientos de Office',
                    model: 'conocimientoOffice',
                    fields: [
                        { label: '¿Nivel de Excel?', name: 'nivel_excel', type: 'select', options: ['Básico', 'Intermedio', 'Avanzado'], required: true },
                        { label: '¿Nivel de Word?', name: 'nivel_word', type: 'select', options: ['Básico', 'Intermedio', 'Avanzado'], required: true },
                        { label: '¿Nivel de PowerPoint?', name: 'nivel_powerpoint', type: 'select', options: ['Básico', 'Intermedio', 'Avanzado'], required: true },
                    ]
                },
                {
                    title: 'Conocimientos de Idiomas',
                    model: 'nuevoIdioma',
                    fields: [
                        { label: 'Idioma', name: 'idioma', type: 'select', options: ['Inglés', 'Francés', 'Alemán', 'Italiano', 'Portugués', 'Otro'], required: true },
                        { label: 'Lectura', name: 'lectura', type: 'select', options: ['Básico', 'Intermedio', 'Avanzado'], required: true },
                        { label: 'Escritura', name: 'escritura', type: 'select', options: ['Básico', 'Intermedio', 'Avanzado'], required: true },
                        { label: 'Conversación', name: 'conversacion', type: 'select', options: ['Básico', 'Intermedio', 'Avanzado'], required: true },

                    ]
                },
                {
                    title: 'Cursos Complementarios',
                    model: 'nuevoCurso',
                    fields: [
                        { label: 'Curso', name: 'curso', type: 'text', required: true },
                        { label: 'Año', name: 'anio', type: 'select', options: ['2020', '2021', '2022', '2023', '2024', '2025'], required: true },
                        { label: 'Adjuntar Certificado', name: 'certificado', type: 'file', onchange: 'handleFileUpload' }

                    ]
                },
                {
                    title: 'Experiencia Laboral',
                    model: 'nuevaExperienciaLaboral',
                    fields: [
                        { label: 'Empresa', name: 'empresa', type: 'text', required: true },
                        { label: 'Cargo', name: 'cargo', type: 'text', required: true },
                        { label: 'Fecha de Inicio', name: 'fecha_inicio', type: 'date', required: true },
                        { label: 'Fecha de Fin', name: 'fecha_fin', type: 'date', required: true },
                        { label: 'Descripción', name: 'descripcion', type: 'text', required: true },
                        { label: 'Motivo de Salida', name: 'motivo_salida', type: 'text', required: true },
                        { label: 'Importe de Remuneración', name: 'importe_remuneracion', type: 'number', required: true },
                        { label: 'Nombre Referencia', name: 'nombre_referencia', type: 'text', required: true },
                        { label: 'Número Contacto Referencia', name: 'numero_contacto_referencia', type: 'number', required: true },
                        { label: 'Adjuntar Constancia', name: 'constancia', type: 'file', required: true }
                    ]

                },
                // {
                //     title: 'Enfermedades',
                //     model: 'enfermedades',
                //     fields: [
                //         { label: 'Indique si padece alguna enfermedad', name: 'padece_enfermedad', type: 'select', options: ['Sí', 'No'], required: true },
                //         { label: 'Especifique', name: 'motivo_salida', type: 'text', required: true },
                //     ]
                // },
            ]
        };
    },
    mounted() {
        const userSession = localStorage.getItem('userSession');
        if (!userSession) {
            this.$router.push('/inicio'); // Redirigir a la vista de inicio si no hay sesión
        }
    },
    methods: {
        previewImage(event) {
            const input = event.target;
            this.$nextTick(() => {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        document.getElementById('uploadContainer').appendChild(imgElement);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
        },
        submitForm() {
            // Handle form submission
            console.log(this.form);
        },
        agregarReferencia() {
            this.form.referenciasFamiliares.push({ ...this.form.nuevaReferencia });
            this.form.nuevaReferencia = {
                nombre_familiar: '',
                parentesco: '',
                fecha_nacimiento_ref: '',
                celular_ref: '',
                celular_ref2: '',
                telefono_fijo: ''
            };
        },
        eliminarReferencia(index, event) {
            event.preventDefault();
            this.form.referenciasFamiliares.splice(index, 1);
        },
        agregarContactoEmergencia() {
            this.form.contactosEmergencia.push({ ...this.form.nuevoContactoEmergencia });
            this.form.nuevoContactoEmergencia = {
                nombre_contacto_emergencia: '',
                parentesco_contacto_emergencia: '',
                celular_contacto_emergencia: '',
                celular2_contacto_emergencia: '',
                telefono_fijo_contacto_emergencia: ''
            };
        },
        eliminarContactoEmergencia(index, event) {
            event.preventDefault();
            this.form.contactosEmergencia.splice(index, 1);
        },
        agregarIdioma() {
            this.form.idiomas.push({ ...this.form.nuevoIdioma });
            this.form.nuevoIdioma = {
                idioma: '',
                lectura: '',
                escritura: '',
                conversacion: ''
            };
        },
        eliminarIdioma(index, event) {
            event.preventDefault();
            this.form.idiomas.splice(index, 1);
        },
        handleFileUpload(event) {
            console.log("###111")
            const file = event.target.files[0];
            if (file) {
                this.form.nuevoCurso.certificado = file.name; // Guarda solo el nombre del archivo
            }
        },
        agregarCurso() {
            this.form.cursos.push({ ...this.form.nuevoCurso });
            this.form.nuevoCurso = {
                curso: '',
                anio: '',
                certificado: '',
            };
        },
        eliminarCurso(index, event) {
            event.preventDefault();
            this.form.cursos.splice(index, 1);
        },
        agregarExperiencia() {
            this.form.experienciasLaborales.push({ ...this.form.nuevaExperienciaLaboral });
            this.form.nuevaExperienciaLaboral = {
                empresa: '',
                cargo: '',
                fecha_inicio: '',
                fecha_fin: '',
                descripcion: '',
                motivo_salida: '',
                importe_remuneracion: '',
                nombre_referencia: '',
                numero_contacto_referencia: '',
                constancia: ''
            };
        },
        eliminarExperiencia(index, event) {
            event.preventDefault();
            this.form.experienciasLaborales.splice(index, 1);
        }
    }
};
</script>

<style scoped>
.upload-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}

.upload-container input[type="file"] {
    display: none;
}

.upload-container p {
    margin: 0;
    cursor: pointer;
    color: #007bff;
}

.form-container-postulante {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.btn-primary-postulante {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
}

.btn-primary-postulante:hover {
    background-color: #0056b3;
}

.table-responsive {
    margin-top: 20px;
    overflow-x: auto;

}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 8px;
}

.table th {
    background-color: #f2f2f2;
    text-align: left;
}
</style>
