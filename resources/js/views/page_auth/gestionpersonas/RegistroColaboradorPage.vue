<template>
    <div class="layout-container-section-content">
        <h2>Datos de Colaborador</h2>
        <div class="widget-container-section-content">


            <form @submit.prevent="submitForm">
                <div class="form-container-postulante">
                    <FormSection v-for="(section, index) in sections" :key="index" :section="section"
                        :model="form[section.model]" @agregar-referencia="agregarReferencia"
                        @agregar-contacto-emergencia="agregarContactoEmergencia" @agregar-hijo="agregarHijos"
                        @agregar-idioma="agregarIdioma" @agregar-curso="agregarCurso"
                        @agregar-experiencia="agregarExperiencia" @agregar-enfermedad="agregarEnfermedad"
                        @agregar-alergia="agregarAlergia" @file-upload="handleFileUploadDni"
                        @file-selected="updateFile">
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
                                        <tr v-for="(referencia, index) in referenciasConTexto" :key="index">
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
                                        <tr v-for="(contacto, index) in contactosEmergenciaConTexto" :key="index">
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
                        <template v-if="section.model === 'nuevoHijo'" #default>
                            <div v-if="form.hijos.length > 0" class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Respuesta</th>
                                            <th>Nombre Hijo</th>
                                            <th>Genero</th>
                                            <th>Fecha Nacimiento</th>
                                            <th>DNI</th>
                                            <th>Biologico</th>
                                            <th>DNI(PDF)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(hijo, index) in hijosConTexto" :key="index">
                                            <td>{{ hijo.respuesta }}</td>
                                            <td>{{ hijo.nombre_hijo }}</td>
                                            <td>{{ hijo.genero_hijo }}</td>
                                            <td>{{ hijo.fecha_nacimiento_hijo }}</td>
                                            <td>{{ hijo.dni_hijo }}</td>
                                            <td>{{ hijo.biologico }}</td>
                                            <td>
                                                <input type="file" accept="application/pdf"
                                                    @change="handleFileUploadDni($event, index)">
                                                <span v-if="hijo.dni_file">{{ hijo.dni_file.name }}</span>
                                            </td>
                                            <td>
                                                <button @click="eliminarHijos(index, $event)">Eliminar</button>
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
                                        <tr v-for="(idioma, index) in idiomasConTexto" :key="index">
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
                                            <td>
                                                <input type="file" accept="application/pdf"
                                                    @change="handleFileUploadCurso($event, index)">
                                                <span v-if="curso.certificado">{{ curso.certificado.name }}</span>
                                            </td>

                                            <td>
                                                <button @click="eliminarCurso(index, $event)">Eliminar</button>
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
                                            <td>{{ experiencia.motivo_salida }}</td>
                                            <td>{{ experiencia.importe_remuneracion }}</td>
                                            <td>{{ experiencia.nombre_referencia }}</td>
                                            <td>{{ experiencia.numero_contacto_referencia }}
                                            </td>
                                            <td>
                                                <input type="file" accept="application/pdf"
                                                    @change="handleFileUploadConstancia($event, index)">
                                                <span v-if="experiencia.constancia">{{ experiencia.constancia.name
                                                    }}</span>
                                            </td>
                                            <td>
                                                <button @click="eliminarExperiencia(index, $event)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                        <template v-if="section.model === 'nuevaEnfermedad'" #default>
                            <div v-if="form.enfermedades.length > 0" class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Enfermedad</th>
                                            <th>Fecha de Diagnóstico</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(enfermedad, index) in form.enfermedades" :key="index">
                                            <td>{{ enfermedad.enfermedad }}</td>
                                            <td>{{ enfermedad.fecha_diagnostico }}</td>
                                            <td>
                                                <button @click="eliminarEnfermedad(index, $event)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                        <template v-if="section.model === 'nuevaAlergia'" #default>
                            <div v-if="form.alergias.length > 0" class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Alergia a Medicamento</th>
                                            <th>Medicamento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(alergia, index) in form.alergias" :key="index">
                                            <td>{{ alergia.respuesta_alergico }}</td>
                                            <td>{{ alergia.alergia }}</td>
                                            <td>
                                                <button @click="eliminarAlergia(index, $event)">Eliminar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </template>
                    </FormSection>
                </div>


                <!-- <button type="submit" class="btn-primary-postulante">Registrar Datos</button>-->
                <button type="submit" class="btn-primary-postulante" :disabled="isSubmitting">
                    <span v-if="isSubmitting" class="spinner-border spinner-border-sm" role="status"
                        aria-hidden="true"></span>
                    {{ isSubmitting ? 'Registrando...' : 'Registrar Datos' }}
                </button>

            </form>
            <div>
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#terminosModal">
                    Ver Términos y Condiciones
                </button>

                <!-- Modal de Bootstrap -->
                <div class="modal fade" id="terminosModal" tabindex="-1" aria-labelledby="terminosModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="terminosModalLabel"><b>Por Política de Privacidad</b></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <p>La número 1 estamos comprometidos con mantener la privacidad y protección de
                                    información de
                                    nuestros colaboradores...</p>
                                <p>La protección de datos es una cuestión de confianza y privacidad...</p>
                                <p>Nosotros recogeremos, almacenaremos y procesaremos los datos para fines de recursos
                                    humanos...
                                </p>
                                <p>Cada colaborador se compromete y garantiza que los Datos Personales que suministre
                                    son veraces y
                                    actuales...</p>
                                <p>Los colaboradores tendrán total libertad para ejercitar los derechos establecidos en
                                    la Ley No.
                                    29733...</p>
                                <p>Para más información, puedes enviar una comunicación al correo electrónico:
                                    <a href="mailto:sistemas@lanumero1.com.pe">sistemas@lanumero1.com.pe</a>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormSection from '../../../components/formularios/FormSection.vue';
import axios from 'axios';
import MapComponent from '../../../components/mapas/MapComponent.vue';

export default {
    components: {
        FormSection, MapComponent
    },
    computed: {

        idiomasConTexto() {
            const getText = (campo, id) => {
                return this.sections.find(s => s.model === 'nuevoIdioma')
                    ?.fields.find(f => f.name === campo)
                    ?.options.find(opt => opt.id === id)?.text || 'Desconocido';
            };

            return this.form.idiomas.map(idioma => ({
                idioma: getText('idioma', idioma.idioma),
                lectura: getText('lectura', idioma.lectura),
                escritura: getText('escritura', idioma.escritura),
                conversacion: getText('conversacion', idioma.conversacion)
            }));
        },
        referenciasConTexto() {
            const getText = (campo, id) => {
                return this.sections.find(s => s.model === 'nuevaReferencia')
                    ?.fields.find(f => f.name === campo)
                    ?.options.find(opt => opt.id === id)?.text || 'Desconocido';
            };

            return this.form.referenciasFamiliares.map(ref => ({
                nombre_familiar: ref.nombre_familiar,
                parentesco: getText('parentesco', ref.parentesco),
                fecha_nacimiento_ref: ref.fecha_nacimiento_ref,
                celular_ref: ref.celular_ref,
                celular_ref2: ref.celular_ref2,
                telefono_fijo: ref.telefono_fijo
            }));
        },
        hijosConTexto() {
            const getText = (campo, id) => {
                return this.sections.find(s => s.model === 'nuevoHijo')
                    ?.fields.find(f => f.name === campo)
                    ?.options.find(opt => opt.id === id)?.text || 'Desconocido';
            };

            return this.form.hijos.map(hijo => ({
                respuesta: getText('respuesta', hijo.respuesta),
                nombre_hijo: hijo.nombre_hijo,
                genero_hijo: getText('genero_hijo', hijo.genero_hijo),
                fecha_nacimiento_hijo: hijo.fecha_nacimiento_hijo,
                dni_hijo: hijo.dni_hijo,
                biologico: getText('biologico', hijo.biologico),
                dni_file: hijo.dni_file
            }));
        },
        contactosEmergenciaConTexto() {
            const getText = (campo, id) => {
                return this.sections.find(s => s.model === 'nuevoContactoEmergencia')
                    ?.fields.find(f => f.name === campo)
                    ?.options.find(opt => opt.id === id)?.text || 'Desconocido';
            };

            return this.form.contactosEmergencia.map(contacto => ({
                nombre_contacto_emergencia: contacto.nombre_contacto_emergencia,
                parentesco_contacto_emergencia: getText('parentesco_contacto_emergencia', contacto.parentesco_contacto_emergencia),
                celular_contacto_emergencia: contacto.celular_contacto_emergencia,
                celular2_contacto_emergencia: contacto.celular2_contacto_emergencia,
                telefono_fijo_contacto_emergencia: contacto.telefono_fijo_contacto_emergencia
            }));
        }
    },
    data() {
        return {
            isSubmitting: false,
            anios: [],
            departamentos: [],
            provincias: [],
            distritos: [],
            formData: new FormData(),
            mostrarPopup: false,
            form: {
                personalInfo: {
                    apellido_paterno: '',
                    apellido_materno: '',
                    nombres: '',
                    nacionalidad: '',
                    estado_civil: '',
                    fecha_nacimiento: '',
                    edad: '',
                    genero: '',
                    tipo_documento: '',
                    numero_documento: '',
                    correo: '',
                    celular: '',
                    telefono: ''
                },
                domicilio: {
                    id_departamento: '',
                    id_provincia: '',
                    id_distrito: '',
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
                },
                experienciasLaborales: [],
                nuevaExperienciaLaboral: {
                    empresa: '',
                    cargo: '',
                    fecha_inicio: '',
                    fecha_fin: '',
                    motivo_salida: '',
                    importe_remuneracion: '',
                    nombre_referencia: '',
                    numero_contacto_referencia: '',
                },
                enfermedades: [],
                nuevaEnfermedad: {
                    padece_enfermedad: '',
                    enfermedad: '',
                    fecha_diagnostico: ''
                },
                gestacion: {
                    respuesta_gestacion: '',
                    fecha_parto: '',

                },
                alergias: [],
                nuevaAlergia: {
                    respuesta_alergico: '',
                    alergia: '',
                },
                otros: {
                    tipo_sangre: '',
                },
                referenciaConvocatoria: {
                    puesto_referencia: '',
                    especifique_otros: '',
                },
                adjuntarDocumentacion: {
                    adjuntar_cv: '',
                    foto_dni: '',
                    copia_agua_luz: ''
                },
                uniforme: {
                    talla_polo: '',
                    talla_camisa: '',
                    talla_pantalon: '',
                    talla_zapato: ''
                },
                sistemapensionario: {
                    sistema_pensionario: '',
                    tipo_sistema: '',
                    afp: '',
                },
                cuentabancaria: {
                    cuenta_bancaria: '',
                    entidad_bancaria: '',
                    numero_cuenta: '',
                    codigo_interbancario: ''
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
                        {
                            label: 'Nacionalidad',
                            name: 'nacionalidad',
                            type: 'select',
                            options: [
                                { id: 1, text: 'PERUANO' },
                                { id: 2, text: 'VENEZOLANO' },
                                { id: 3, text: 'COLOMBIANO' }
                            ],
                            required: true
                        },
                        {
                            label: 'Estado Civil',
                            name: 'estado_civil',
                            type: 'select',
                            options: [
                                { id: 1, text: 'DIVORCIADO' },
                                { id: 2, text: 'SOLTERO' },
                                { id: 3, text: 'CASADO' },
                                { id: 4, text: 'CONVIVIENTE' },
                                { id: 5, text: 'SEPARADO' },
                                { id: 6, text: 'VIUDO' }
                            ],
                            required: true
                        },
                        { label: 'Fecha de Nacimiento', name: 'fecha_nacimiento', type: 'date', required: false },
                        { label: 'Edad', name: 'edad', type: 'number', required: false },
                        {
                            label: 'Género',
                            name: 'genero',
                            type: 'select',
                            options: [
                                { id: 1, text: 'MASCULINO' },
                                { id: 2, text: 'FEMENINO' }
                            ],
                            required: true
                        },
                        {
                            label: 'Tipo de Documento',
                            name: 'tipo_documento',
                            type: 'select',
                            options: [
                                { id: 1, text: 'CARNET DE REFUGIO' },
                                { id: 2, text: 'PASAPORTE' },
                                { id: 3, text: 'PERMISO TEMPORAL DE PERMANENCIA' },
                                { id: 4, text: 'DOCUMENTO NACIONAL DE IDENTIDAD' },
                                { id: 5, text: 'CARNET DE EXTRANJERÍA' },
                                { id: 6, text: 'REGISTRO ÚNICO DE CONTRIBUYENTES' }
                            ],
                            required: true
                        },
                        { label: 'Número de Documento', name: 'numero_documento', type: 'number', required: true },
                        { label: 'Correo Electrónico', name: 'correo', type: 'email', required: true },
                        { label: 'Número Celular', name: 'celular', type: 'number', required: true },
                        { label: 'Teléfono Fijo', name: 'telefono', type: 'number', required: false }
                    ]
                },
                {
                    title: 'Domicilio',
                    model: 'domicilio',
                    fields: [
                        // Agregar los selects de Departamento, Provincia y Distrito
                        {
                            label: 'Departamento',
                            name: 'id_departamento',
                            type: 'select',
                            required: true,
                            options: [] // Aquí llenas las opciones dinámicamente desde el backend
                        },
                        {
                            label: 'Provincia',
                            name: 'id_provincia',
                            type: 'select',
                            required: true,
                            options: [] // Aquí llenas las opciones dinámicamente después de seleccionar un departamento
                        },
                        {
                            label: 'Distrito',
                            name: 'id_distrito',
                            type: 'select',
                            required: true,
                            options: [] // Aquí llenas las opciones dinámicamente después de seleccionar una provincia
                        },
                        {
                            label: 'Tipo de vía', name: 'tipo_via', type: 'select', options: [
                                { id: 1, text: 'Avenida' },
                                { id: 2, text: 'Jirón' },
                                { id: 3, text: 'Calle' },
                                { id: 4, text: 'Pasaje' },
                                { id: 5, text: 'Alameda' },
                                { id: 6, text: 'Malecón' },
                                { id: 7, text: 'Óvalo' },
                                { id: 8, text: 'Parque' },
                                { id: 9, text: 'Plaza' },
                                { id: 10, text: 'Carretera' },
                                { id: 11, text: 'Trocha' },
                                { id: 12, text: 'Camino Rural' },
                                { id: 13, text: 'Bajada' },
                                { id: 14, text: 'Galería' },
                                { id: 15, text: 'Prolongación' },
                                { id: 16, text: 'Paseo' },
                                { id: 17, text: 'Plazuela' },
                                { id: 18, text: 'Portal' }
                            ], required: true
                        },

                        { label: 'Nombre de vía', name: 'nombre_via', type: 'text', required: false },
                        { label: 'Número de vía', name: 'numero_via', type: 'text', required: false },
                        { label: 'KM', name: 'km', type: 'text', required: false },
                        { label: 'MZ', name: 'mz', type: 'text', required: false },
                        { label: 'Interior', name: 'interior', type: 'text', required: false },
                        { label: 'N° Departamento', name: 'numero_departamento', type: 'text', required: false },
                        { label: 'Lote', name: 'lote', type: 'text', required: false },
                        { label: 'Piso', name: 'piso', type: 'number', required: false },
                        {
                            label: 'Tipo de Zona', name: 'tipo_zona', type: 'select', options: [
                                { id: 1, text: 'PUEBLO JOVEN' },
                                { id: 2, text: 'UNIDAD VECINAL' },
                                { id: 3, text: 'CONJUNTO HABITACIONAL' },
                                { id: 4, text: 'ASENTAMIENTO HUMANO' },
                                { id: 5, text: 'COOPERATIVA' },
                                { id: 6, text: 'RESIDENCIAL' },
                                { id: 7, text: 'ZONA INDUSTRIAL' },
                                { id: 8, text: 'GRUPO' },
                                { id: 9, text: 'CASERÍO' },
                                { id: 10, text: 'FUNDO' },
                                { id: 11, text: 'OTROS' },
                                { id: 12, text: 'URBANIZACIÓN' },
                            ], required: true
                        },
                        { label: 'Nombre Zona', name: 'nombre_zona', type: 'text', required: false },
                        {
                            label: 'Tipo de vivienda', name: 'tipo_vivienda', type: 'select', options: [
                                { id: 1, text: 'Alquilada' },
                                { id: 2, text: 'Propia' },
                                { id: 3, text: 'Propiedad de un familiar' },

                            ], required: true
                        },
                        { label: 'Referencia Domicilio', name: 'referencia_domicilio', type: 'text', required: true },
                    ]
                },

                {
                    title: 'Gustos y Preferencias',
                    model: 'gustosPreferencias',
                    fields: [
                        { label: 'Plato y postre favorito', name: 'plato_postre_favorito', type: 'text', required: false },
                        { label: 'Galletas y golosinas favoritas', name: 'galletas_golosinas_favoritas', type: 'text', required: false },
                        { label: 'Actividades de ocio o pasatiempos', name: 'actividades_ocio', type: 'text', required: false },
                        { label: 'Artistas o banda favorita', name: 'artistas_banda_favorita', type: 'text', required: false },
                        { label: 'Género musical favorito', name: 'genero_musical_favorito', type: 'text', required: false },
                        { label: 'Película o serie favorita', name: 'pelicula_serie_favorita', type: 'text', required: true },
                        { label: 'Colores favoritos', name: 'colores_favoritos', type: 'text', required: false },
                        { label: 'Redes sociales favoritas', name: 'redes_sociales_favoritas', type: 'text', required: false },
                        { label: 'Deporte favorito', name: 'deporte_favorito', type: 'text', required: true },
                        { label: '¿Tiene mascota?', name: 'tiene_mascota', type: 'select', options: [{ id: 1, text: 'Si' }, { id: 2, text: 'No' }], required: false },
                        { label: 'Qué mascota tienes?', name: 'tipo_mascota', type: 'text', required: false }
                    ]
                },
                {
                    title: 'Referencias Familiares',
                    model: 'nuevaReferencia',
                    fields: [
                        { label: 'Nombre de Familiar', name: 'nombre_familiar', type: 'text', required: true },
                        {
                            label: 'Parentesco', name: 'parentesco', type: 'select', options: [
                                { id: 1, text: 'PAPÁ' },
                                { id: 2, text: 'MAMÁ' },
                                { id: 3, text: 'TÍO/A' },
                                { id: 4, text: 'HERMANO/A' },
                                { id: 5, text: 'PRIMO/A' },
                                { id: 6, text: 'ESPOSO/A' },
                                { id: 7, text: 'PAREJA' },
                                { id: 8, text: 'SOBRINO/A' },
                                { id: 9, text: 'HIJO/A' },
                                { id: 10, text: 'ABUELO/A' }
                            ],
                            required: true
                        },
                        { label: 'Fecha de Nacimiento', name: 'fecha_nacimiento_ref', type: 'date', required: true },
                        { label: 'Celular', name: 'celular_ref', type: 'number', required: true },
                        { label: 'Celular 2', name: 'celular_ref2', type: 'number', required: false },
                        { label: 'Teléfono Fijo', name: 'telefono_fijo', type: 'number', required: false },
                    ]
                },
                {
                    title: 'Datos de Hijos/as',
                    model: 'nuevoHijo',
                    fields: [
                        { label: '¿Respuesta?', name: 'respuesta', type: 'select', options: [{ id: 1, text: 'Sí' }, { id: 2, text: 'No' }], required: false },
                        { label: 'Nombre de Hijo/a', name: 'nombre_hijo', type: 'text', required: false },
                        {
                            label: 'Género', name: 'genero_hijo', type: 'select',
                            options: [
                                { id: 1, text: 'MASCULINO' },
                                { id: 2, text: 'FEMENINO' }],
                            required: false
                        },
                        { label: 'Fecha de Nacimiento', name: 'fecha_nacimiento_hijo', type: 'date', required: false },
                        { label: 'DNI', name: 'dni_hijo', type: 'text', required: false },
                        { label: 'Biológico/No Biológico', name: 'biologico', type: 'select', options: [{ id: 1, text: 'Sí' }, { id: 2, text: 'No' }], required: false },
                    ]
                },
                {
                    title: 'Contacto de Emergencia',
                    model: 'nuevoContactoEmergencia',
                    fields: [
                        { label: 'Nombre de Contacto', name: 'nombre_contacto_emergencia', type: 'text', required: true },
                        {
                            label: 'Parentesco', name: 'parentesco_contacto_emergencia', type: 'select', options: [
                                { id: 1, text: 'PAPÁ' },
                                { id: 2, text: 'MAMÁ' },
                                { id: 3, text: 'TÍO/A' },
                                { id: 4, text: 'HERMANO/A' },
                                { id: 5, text: 'PRIMO/A' },
                                { id: 6, text: 'ESPOSO/A' },
                                { id: 7, text: 'PAREJA' },
                                { id: 8, text: 'SOBRINO/A' },
                                { id: 9, text: 'HIJO/A' },
                                { id: 10, text: 'ABUELO/A' }
                            ], required: true
                        },
                        { label: 'Celular', name: 'celular_contacto_emergencia', type: 'number', required: true },
                        { label: 'Celular 2', name: 'celular2_contacto_emergencia', type: 'number', required: false },
                        { label: 'Teléfono Fijo', name: 'telefono_fijo_contacto_emergencia', type: 'number', required: false }
                    ]
                },
                {
                    title: 'Conocimientos de Office',
                    model: 'conocimientoOffice',
                    fields: [
                        {
                            label: '¿Nivel de Excel?', name: 'nivel_excel', type: 'select',
                            options: [
                                { id: 1, text: 'Básico' },
                                { id: 2, text: 'Intermedio' },
                                { id: 3, text: 'Avanzado' },
                                { id: 4, text: 'No Aplica' },
                            ],
                            required: true
                        },
                        {
                            label: '¿Nivel de Word?', name: 'nivel_word', type: 'select',
                            options: [
                                { id: 1, text: 'Básico' },
                                { id: 2, text: 'Intermedio' },
                                { id: 3, text: 'Avanzado' },
                                { id: 4, text: 'No Aplica' },
                            ],
                            required: true
                        },
                        {
                            label: '¿Nivel de PowerPoint?', name: 'nivel_powerpoint', type: 'select',
                            options: [
                                { id: 1, text: 'Básico' },
                                { id: 2, text: 'Intermedio' },
                                { id: 3, text: 'Avanzado' },
                                { id: 4, text: 'No Aplica' },
                            ],
                            required: true
                        },
                    ]
                },
                {
                    title: 'Conocimientos de Idiomas',
                    model: 'nuevoIdioma',
                    fields: [
                        {
                            label: 'Idioma', name: 'idioma', type: 'select',
                            options: [
                                { id: 1, text: 'Inglés' },
                                { id: 2, text: 'Quechua' },
                                { id: 3, text: 'Francés' },
                                { id: 4, text: 'Portugués' },
                                { id: 5, text: 'No Aplica' },
                            ],
                            required: true
                        },
                        {
                            label: 'Lectura', name: 'lectura', type: 'select', options:
                                [
                                    { id: 1, text: 'Básico' },
                                    { id: 2, text: 'Intermedio' },
                                    { id: 3, text: 'Avanzado' },
                                    { id: 4, text: 'No Aplica' },
                                ],
                            required: true
                        },
                        {
                            label: 'Escritura', name: 'escritura', type: 'select', options:
                                [
                                    { id: 1, text: 'Básico' },
                                    { id: 2, text: 'Intermedio' },
                                    { id: 3, text: 'Avanzado' },
                                    { id: 4, text: 'No Aplica' },
                                ],
                            required: true
                        },
                        {
                            label: 'Conversación', name: 'conversacion', type: 'select', options:
                                [
                                    { id: 1, text: 'Básico' },
                                    { id: 2, text: 'Intermedio' },
                                    { id: 3, text: 'Avanzado' },
                                    { id: 4, text: 'No Aplica' },
                                ],
                            required: true
                        },

                    ]
                },
                {
                    title: 'Cursos Complementarios',
                    model: 'nuevoCurso',
                    fields: [
                        { label: 'Curso', name: 'curso', type: 'text', required: false },
                        {
                            label: 'Año', name: 'anio', type: 'select',
                            required: false,
                            options: [],
                        },

                    ]
                },
                {
                    title: 'Experiencia Laboral',
                    model: 'nuevaExperienciaLaboral',
                    fields: [
                        { label: 'Empresa', name: 'empresa', type: 'text', required: false },
                        { label: 'Cargo', name: 'cargo', type: 'text', required: false },
                        { label: 'Fecha de Inicio', name: 'fecha_inicio', type: 'date', required: false },
                        { label: 'Fecha de Fin', name: 'fecha_fin', type: 'date', required: false },
                        { label: 'Motivo de Salida', name: 'motivo_salida', type: 'text', required: false },
                        { label: 'Importe de Remuneración', name: 'importe_remuneracion', type: 'number', required: false },
                        { label: 'Nombre Referencia', name: 'nombre_referencia', type: 'text', required: false },
                        { label: 'Número Contacto Referencia', name: 'numero_contacto_referencia', type: 'number', required: false },
                    ]

                },
                {
                    title: 'Enfermedades',
                    model: 'nuevaEnfermedad',
                    fields: [
                        { label: 'Indique si padece alguna enfermedad', name: 'padece_enfermedad', type: 'select', options: [{ id: 1, text: 'Sí' }, { id: 2, text: 'No' }], required: false },
                        { label: 'Especifique la Enfermedad', name: 'enfermedad', type: 'text', required: false },
                        { label: 'Fecha de Diagnóstico', name: 'fecha_diagnostico', type: 'date', required: false },

                    ]
                },
                {
                    title: 'Gestación',
                    model: 'gestacion',
                    fields: [
                        { label: 'Indique si se encuentra en gestación', name: 'respuesta_gestacion', type: 'select', options: [{ id: 1, text: 'Sí' }, { id: 2, text: 'No' }], required: false },
                        { label: 'Fecha de inicio de gestación', name: 'fecha_parto', type: 'date', required: false }]
                },
                {
                    title: 'Alergias',
                    model: 'nuevaAlergia',
                    fields: [
                        { label: 'Es alérgico a algun medicamento', name: 'respuesta_alergico', type: 'select', options: [{ id: 1, text: 'Sí' }, { id: 2, text: 'No' }], required: false },
                        { label: 'Indique el nombre del medicamento', name: 'alergia', type: 'text', required: false }
                    ]
                },
                {
                    title: 'Otros',
                    model: 'otros',
                    fields: [
                        {
                            label: 'Tipo de sangre', name: 'tipo_sangre', type: 'select',
                            options: [
                                { id: 1, text: 'O-' },
                                { id: 2, text: 'O+' },
                                { id: 3, text: 'A-' },
                                { id: 4, text: 'A+' },
                                { id: 5, text: 'B-' },
                                { id: 6, text: 'B+' },
                                { id: 7, text: 'AB-' },
                                { id: 8, text: 'AB+' },
                                { id: 9, text: 'Desconoce' },
                            ],
                            required: true
                        },
                    ]
                },
                {
                    title: 'Referencia de Convocatoria',
                    model: 'referenciaConvocatoria',
                    fields: [
                        {
                            label: 'Indica ¿Cómo te enteraste del puesto?', name: 'puesto_referencia', type: 'select',
                            options:
                                [
                                    { id: 1, text: 'COMPUTRABAJO' },
                                    { id: 2, text: 'AFICHE EN FACHADA' },
                                    { id: 3, text: 'RECOMENDACIÓN' },
                                    { id: 4, text: 'REDES SOCIALES' },
                                    { id: 5, text: 'RADIO' },
                                    { id: 6, text: 'OTROS' },
                                ],
                            required: true
                        },
                        { label: 'Especifique Otros', name: 'especifique_otros', type: 'text', required: true },

                    ]
                },
                {
                    title: 'Adjuntar Documentacion',
                    model: 'adjuntarDocumentacion',
                    fields: [
                        { label: 'Adjuntar curriculum vitae', name: 'adjuntar_cv', type: 'file', required: true },
                        { label: 'Foto DNI (ambas caras)', name: 'foto_dni', type: 'file', required: true },
                        { label: 'Copia de recibo de agua y luz', name: 'copia_agua_luz', type: 'file', required: true },

                    ]
                },
                {
                    title: 'Uniforme',
                    model: 'uniforme',
                    fields: [
                        {
                            label: 'Polo',
                            name: 'talla_polo',
                            type: 'select',
                            options: [
                                { id: 2, text: 'XS' },
                                { id: 1, text: 'S' },
                                { id: 3, text: 'M' },
                                { id: 4, text: 'L' },
                                { id: 5, text: 'XL' },
                                { id: 6, text: 'XXL' },
                                { id: 7, text: 'XXXL' }
                            ],
                            required: true
                        },
                        {
                            label: 'Camisa',
                            name: 'talla_camisa',
                            type: 'select',
                            options: [
                                { id: 25, text: '13' },
                                { id: 31, text: '13.5' },
                                { id: 26, text: '14' },
                                { id: 32, text: '14.5' },
                                { id: 27, text: '15' },
                                { id: 33, text: '15.5' },
                                { id: 28, text: '16' },
                                { id: 34, text: '16.5' },
                                { id: 29, text: '17' },
                                { id: 35, text: '17.5' },
                                { id: 30, text: '18' },
                                { id: 36, text: '18.5' }
                            ],
                            required: true
                        },
                        {
                            label: 'Pantalón',
                            name: 'talla_pantalon',
                            type: 'select',
                            options: [
                                { id: 19, text: '26' },
                                { id: 20, text: '28' },
                                { id: 21, text: '30' },
                                { id: 22, text: '32' },
                                { id: 23, text: '34' },
                                { id: 24, text: '36' }
                            ],
                            required: true
                        },
                        {
                            label: 'Zapato',
                            name: 'talla_zapato',
                            type: 'select',
                            options: [
                                { id: 8, text: '34' },
                                { id: 9, text: '35' },
                                { id: 10, text: '36' },
                                { id: 11, text: '37' },
                                { id: 12, text: '38' },
                                { id: 13, text: '39' },
                                { id: 14, text: '40' },
                                { id: 15, text: '41' },
                                { id: 16, text: '42' },
                                { id: 17, text: '43' },
                                { id: 18, text: '44' },
                                { id: 37, text: '45' }
                            ],
                            required: true
                        }
                    ]

                },
                {
                    title: 'Sistema Pensionario',
                    model: 'sistemapensionario',
                    fields: [
                        { label: 'Pertenece a algún sistema pensionario', name: 'sistema_pensionario', type: 'select', options: [{ id: 1, text: 'Sí' }, { id: 2, text: 'No' }], required: true },
                        {
                            label: 'Indique el sistema pensionaro al que pertenece', name: 'tipo_sistema', type: 'select',
                            options: [
                                { id: 1, text: 'ONP' },
                                { id: 2, text: 'AFP' },],

                            required: false
                        },
                        {
                            label: 'Si indico AFP elija', name: 'afp', type: 'select', options: [
                                { id: 1, text: 'INTEGRA' },
                                { id: 2, text: 'PRIMA' },
                                { id: 3, text: 'PROFUTURO' },
                                { id: 4, text: 'HABITAT' },
                                { id: 5, text: 'HORIZONTE' },
                                { id: 6, text: 'ONP' }], required: false
                        },

                    ]
                },
                {
                    title: 'Número de Cuenta',
                    model: 'cuentabancaria',
                    fields: [
                        { label: '¿Cuéntas con cuenta bancaria?', name: 'cuenta_bancaria', type: 'select', options: [{ id: 1, text: 'Sí' }, { id: 2, text: 'No' }], required: true },
                        {
                            label: 'Indique la entidad bancaria', name: 'entidad_bancaria', type: 'select',
                            options:
                                [
                                    { id: 1, text: 'Banco de Crédito del Perú' },
                                    { id: 2, text: 'Interbank' },
                                    { id: 3, text: 'Scotiabank' },
                                    { id: 4, text: 'BBVA' },
                                    { id: 5, text: 'Banco De La Nacion' },
                                ]
                            , required: false
                        },
                        { label: 'Indique el número de cuenta', name: 'numero_cuenta', type: 'text', required: false },
                        { label: 'Indique el código interbancario', name: 'codigo_interbancario', type: 'text', required: false },

                    ]
                }
            ]
        };
    },
    mounted() {
        const userSession = localStorage.getItem('userSession');
        if (!userSession) {
            this.$router.push('/inicio'); // Redirigir a la vista de inicio si no hay sesión
        }
        this.getDepartamentos();
        this.getAnios();
    },
    methods: {
        // Obtener los años
        getAnios() {
            axios.get('/anios')
                .then(response => {
                    // Transformar la respuesta para tener id y text
                    this.anios = response.data.map(item => ({
                        id: item.cod_anio, // Asegúrate de que este campo existe en la respuesta
                        text: item.cod_anio // Asegúrate de que este campo también existe en la respuesta
                    }));
                    // Asignar las opciones de departamento al campo 'id_departamento'
                    this.sections[8].fields.find(field => field.name === 'anio').options = this.anios;

                })
                .catch(error => {
                    console.error('Error al obtener anio:', error);
                });
        },

        // Obtener los departamentos
        getDepartamentos() {
            axios.get('/departamentos')
                .then(response => {
                    // Transformar la respuesta para tener id y text
                    this.departamentos = response.data.map(item => ({
                        id: item.id_departamento, // Asegúrate de que este campo existe en la respuesta
                        text: item.nombre_departamento // Asegúrate de que este campo también existe en la respuesta
                    }));
                    // Asignar las opciones de departamento al campo 'id_departamento'
                    this.sections[1].fields.find(field => field.name === 'id_departamento').options = this.departamentos;

                })
                .catch(error => {
                    console.error('Error al obtener departamentos:', error);
                });
        },

        // Obtener provincias basadas en el departamento seleccionado
        loadProvincias() {
            if (!this.formData.id_departamento) {
                console.warn("No hay un departamento seleccionado.");
                return;
            }

            axios.get('/provincias', { params: { id_departamento: this.formData.id_departamento } })
                .then(response => {
                    this.provincias = response.data.map(item => ({
                        id: item.id_provincia,
                        text: item.nombre_provincia
                    }));

                    const provinciaField = this.sections[1].fields.find(field => field.name === 'id_provincia');
                    if (provinciaField) {
                        provinciaField.options = [...this.provincias]; // Asegurar reactividad
                    }

                    this.formData.id_provincia = ''; // Limpiar selección de provincia
                    this.formData.id_distrito = '';  // Limpiar selección de distrito
                })
                .catch(error => {
                    console.error('Error al obtener provincias:', error);
                });
        },

        // Obtener distritos basados en la provincia seleccionada
        loadDistritos() {
            axios.get('/distritos', { params: { id_provincia: this.formData.id_provincia } })
                .then(response => {
                    // Transformar la respuesta para tener id y text
                    this.distritos = response.data.map(item => ({
                        id: item.id, // Asegúrate de que este campo existe en la respuesta
                        text: item.nombre // Asegúrate de que este campo también existe en la respuesta
                    }));

                    // Asignar las opciones de distrito al campo 'id_distrito'
                    this.sections[1].fields.find(field => field.name === 'id_distrito').options = this.distritos;
                    this.formData.id_distrito = ''; // Limpiar distrito al cambiar provincia
                })
                .catch(error => {
                    console.error('Error al obtener distritos:', error);
                });
        },

        cerrarPopup(event) {
            event.preventDefault();
            this.mostrarPopup = false;
        },

        handleFileUploadDni(event, index) {
            const file = event.target.files[0];
            if (file) {
                // ✅ Guardar en el modelo `hijos` para que se refleje en el JSON
                this.form.hijos[index].dni_file = file;

                // ✅ Agregarlo a `FormData` para enviarlo correctamente al backend
                this.formData.append(`dni_file_${index}`, file.name);
            }
        },
        handleFileUploadCurso(event, index) {
            const file = event.target.files[0];
            if (file) {
                // ✅ Guardar en el modelo `cursos` para que se refleje en el JSON
                this.form.cursos[index].certificado = file;
                // ✅ Agregarlo a `FormData` para enviarlo correctamente al backend
                this.formData.append(`certificado_${index}`, file.name);
            }
        },
        handleFileUploadConstancia(event, index) {
            const file = event.target.files[0];
            if (file) {
                // ✅ Guardar en el modelo `experienciasLaborales` para que se refleje en el JSON
                this.form.experienciasLaborales[index].constancia = file.name;
                // ✅ Agregarlo a `FormData` para enviarlo correctamente al backend
                this.formData.append(`certificadolb_${index}`, file);
            }
        },

        updateFile({ fieldName, file }) {
            if (!this.form.adjuntarDocumentacion) {
                this.form.adjuntarDocumentacion = {};
            }
            this.form.adjuntarDocumentacion[fieldName] = file;
        },
        async submitForm() {
            try {
                this.isSubmitting = true; // 🔹 Deshabilita el botón
                const userSessionString = localStorage.getItem('userSession');
                const userSession = JSON.parse(userSessionString);

                // Inicializa correctamente FormData
                this.formData = new FormData();
                this.formData.append('id_usuario', userSession.id_usuario);
                this.formData.append('formulario', JSON.stringify(this.form));

                // 🔹 Adjuntar archivos si existen
                if (this.form.adjuntarDocumentacion.adjuntar_cv) {
                    this.formData.append('adjuntar_cv', this.form.adjuntarDocumentacion.adjuntar_cv);
                }
                if (this.form.adjuntarDocumentacion.foto_dni) {
                    this.formData.append('foto_dni', this.form.adjuntarDocumentacion.foto_dni);
                }
                if (this.form.adjuntarDocumentacion.copia_agua_luz) {
                    this.formData.append('copia_agua_luz', this.form.adjuntarDocumentacion.copia_agua_luz);
                }

                // 🔹 Enviar datos al servidor
                await axios.post('/gestionpersonas/store_colaborador', this.formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                if (userSession) {
                    // 🔹 Modificar inducción a 1
                    userSession.datos_completos = 1;
                    localStorage.setItem('userSession', JSON.stringify(userSession));
                    // 🔹 Emitir evento para notificar el cambio
                    window.dispatchEvent(new Event("storage"));
                }
                // 🔹 Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro exitoso!',
                    text: `${userSession.nombre_completo}ha sido registrado correctamente.`,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    willClose: () => {
                        router.push('/home');
                    }
                });

            } catch (error) {
                console.error("Error al enviar el formulario:", error);
                // 🔹 Mostrar error en Swal
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al registrar el postulante.',
                });

            } finally {
                this.isSubmitting = false; // 🔹 Habilita el botón nuevamente
            }
        },
        agregarReferencia() {
            this.form.referenciasFamiliares.push({ ...this.form.nuevaReferencia });
        },
        eliminarReferencia(index, event) {
            event.preventDefault();
            this.form.referenciasFamiliares.splice(index, 1);
        },
        agregarContactoEmergencia() {
            this.form.contactosEmergencia.push({ ...this.form.nuevoContactoEmergencia });
        },
        eliminarHijos(index, event) {
            event.preventDefault();
            this.form.hijos.splice(index, 1);
        },
        agregarHijos() {
            this.form.hijos.push({ ...this.form.nuevoHijo });
        },
        eliminarContactoEmergencia(index, event) {
            event.preventDefault();
            this.form.contactosEmergencia.splice(index, 1);
        },
        agregarIdioma() {
            this.form.idiomas.push({ ...this.form.nuevoIdioma });
        },
        eliminarIdioma(index, event) {
            event.preventDefault();
            this.form.idiomas.splice(index, 1);
        },
        agregarCurso() {
            this.form.cursos.push({ ...this.form.nuevoCurso });
        },
        eliminarCurso(index, event) {
            event.preventDefault();
            this.form.cursos.splice(index, 1);
        },
        agregarExperiencia() {
            this.form.experienciasLaborales.push({ ...this.form.nuevaExperienciaLaboral });
        },
        eliminarExperiencia(index, event) {
            event.preventDefault();
            this.form.experienciasLaborales.splice(index, 1);
        },
        agregarEnfermedad() {
            this.form.enfermedades.push({ ...this.form.nuevaEnfermedad });
        },
        eliminarEnfermedad(index, event) {
            event.preventDefault();
            this.form.enfermedades.splice(index, 1);
        },
        agregarAlergia() {
            this.form.alergias.push({ ...this.form.nuevaAlergia });
        },
        eliminarAlergia(index, event) {
            event.preventDefault();
            this.form.alergias.splice(index, 1);
        }
    },
    watch: {
        'formData.id_departamento': {
            handler(newDepto) {
                if (newDepto) {
                    this.loadProvincias();
                } else {
                    this.provincias = []; // Limpiar provincias si se resetea el departamento
                    this.distritos = [];  // Limpiar distritos también
                }
            },
            immediate: true // Ejecuta el watcher inmediatamente después de la carga del componente
        },
        'formData.id_provincia': {
            handler(newProvincia) {
                if (newProvincia) {
                    this.loadDistritos();
                } else {
                    this.distritos = []; // Limpiar distritos si se resetea la provincia
                }
            },
            immediate: true
        }
    }

};
</script>

<style scoped>
/* Estilo del fondo oscuro */


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
