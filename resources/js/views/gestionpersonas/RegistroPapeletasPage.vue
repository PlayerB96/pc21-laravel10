<template>
    <div>
        <!-- Filtro de Estado de Solicitud -->
        <div class="toolbar-col mb-4">
            <label class="control-label text-bold">Estado Solicitud:</label>
            <select v-model="estadoSeleccionado" @change="buscarRegistroPapeleta" class="form-control">
                <option value="0">Todos</option>
                <option value="1">En Proceso de aprobación</option>
                <option value="2">Aprobados</option>
                <option value="3">Denegados</option>
            </select>
        </div>

        <div>
            <button class="btn-primary" @click="handleLoginClick">Registrar Papeleta</button>
        </div>
        <!-- Modal -->
        <registrar-papeleta-modal :isVisible="showModal" @update:isVisible="showModal = $event" />

        <!-- 📌 Usamos el componente SkeletonLoader -->
        <SkeletonLoaderTable v-if="cargando" :rows="10" />

        <!-- 📌 Tabla de Papeletas -->
        <div v-else>
            <table id="tablaPapeletas" class="display">
                <thead>
                    <tr>
                        <th>Motivo</th>
                        <th>Nombre</th>
                        <th>Área</th>
                        <th>Destino</th>
                        <th>Trámite</th>
                        <th>Fecha Solicitud</th>
                        <th>Hora Salida</th>
                        <th>Hora Retorno</th>
                        <th>Estado Solicitud</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(papeleta, index) in papeletas" :key="index">
                        <td>{{ getMotivo(papeleta.id_motivo, papeleta.motivo) }}</td>
                        <td>{{ papeleta.usuario_nombres }} {{ papeleta.usuario_apater }} {{ papeleta.usuario_amater }}
                        </td>
                        <td>{{ papeleta.nom_area }}</td>
                        <td>{{ papeleta.destino ? papeleta.destino.nom_destino : 'Sin destino' }}</td>
                        <td>{{ papeleta.tramite ? papeleta.tramite.nom_tramite : 'Sin tramite' }}</td>
                        <td>{{ papeleta.fec_solicitud }}</td>
                        <td align="center">{{ getHoraSalida(papeleta.sin_ingreso, papeleta.hora_salida) }}</td>
                        <td align="center">{{ getHoraRetorno(papeleta.sin_retorno, papeleta.hora_retorno) }}</td>
                        <td v-html="getEstadoSolicitud(papeleta.estado_solicitud)"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import RegistrarPapeletaModal from '../../components/modals/RegistrarPapeletaModal.vue';
import SkeletonLoaderTable from '../../components/skeleton/SkeletonLoaderTable.vue'; // 📌 Importamos el nuevo componente

export default {
    components: { RegistrarPapeletaModal, SkeletonLoaderTable },
    name: 'RegistroPapeletasPage',
    data() {
        return {
            papeletas: [],
            estadoSeleccionado: '1',
            showModal: false,
            cargando: true,  // 🔥 Estado inicial para mostrar el skeleton
        };
    },
    mounted() {
        this.buscarRegistroPapeleta();
    },
    methods: {

        async buscarRegistroPapeleta() {
            this.cargando = true; // ✅ Activar Skeleton antes de hacer la petición
            try {
                const userSession = JSON.parse(localStorage.getItem('userSession'));
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                const response = await axios.post('http://localhost:8000/api/gestionpersonas/buscar_papeletas', {
                    estado_solicitud: this.estadoSeleccionado,
                    id_puesto: userSession.id_puesto,
                    id_nivel: userSession.id_nivel,
                    registro_masivo: userSession.registro_masivo,
                    id_usuario: userSession.id_usuario,
                    cod_ubi: userSession.cod_ubi,
                    id_gerencia: userSession.id_gerencia
                }, {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                console.log("Respuesta API:", response.data);

                if (!response.data.list_papeletas_salida || response.data.list_papeletas_salida.length === 0) {
                    console.warn("⚠ No se encontraron datos de papeletas");
                    this.cargando = false; // ✅ Ocultar Skeleton aunque no haya datos
                    return;
                }

                this.papeletas = response.data.list_papeletas_salida.map(papeleta => ({
                    id_motivo: papeleta.id_motivo || 0,
                    motivo: this.getMotivo(papeleta.id_motivo, papeleta.motivo),
                    usuario_nombres: papeleta.usuario_nombres || "Sin nombre",
                    usuario_apater: papeleta.usuario_apater || "",
                    usuario_amater: papeleta.usuario_amater || "",
                    nom_area: papeleta.nom_area || "Sin área",
                    destino: papeleta.destino ? papeleta.destino.nom_destino : "Sin destino",
                    tramite: papeleta.tramite ? papeleta.tramite.nom_tramite : "Sin trámite",
                    fec_solicitud: papeleta.fec_solicitud || "Sin fecha",
                    hora_salida: this.getHoraSalida(papeleta.sin_ingreso, papeleta.hora_salida),
                    hora_retorno: this.getHoraRetorno(papeleta.sin_retorno, papeleta.hora_retorno),
                    estado_solicitud: this.getEstadoSolicitud(papeleta.estado_solicitud),
                }));

                setTimeout(() => {
                    this.initDataTable();
                    this.cargando = false; // ✅ Ocultar Skeleton una vez que la tabla está lista
                }, 2000);

            } catch (error) {
                console.error('Error al buscar papeletas:', error);
                this.cargando = false; // ✅ Ocultar Skeleton si hay un error
            }
        },
        async initDataTable() {
            console.log("✅ initDataTable");

            this.$nextTick(() => {
                console.log("✅ nextTick");

                setTimeout(() => {
                    let tableElement = document.querySelector("#tablaPapeletas");
                    console.log("✅tableElement");
                    console.log(tableElement);

                    if (!tableElement || this.papeletas.length === 0) {
                        console.warn("⚠ La tabla aún no está lista, reintentando...");
                        return; // No ejecutamos DataTables si la tabla aún no existe
                    }

                    // 🔥 Destruir instancia previa para evitar duplicados
                    if ($.fn.DataTable.isDataTable("#tablaPapeletas")) {
                        $('#tablaPapeletas').DataTable().destroy();
                    }

                    $('#tablaPapeletas').DataTable({
                        data: this.papeletas,
                        columns: [
                            { data: "motivo" },
                            { data: "usuario_nombres" },
                            { data: "nom_area" },
                            { data: "destino" },
                            { data: "tramite" },
                            { data: "fec_solicitud" },
                            { data: "hora_salida" },
                            { data: "hora_retorno" },
                            { data: "estado_solicitud" }
                        ],
                        responsive: true,
                        autoWidth: false,
                        scrollX: true,
                        pageLength: 10,
                        language: {
                            lengthMenu: "Mostrar _MENU_ registros por página",
                            zeroRecords: "No se encontraron resultados",
                            info: "Mostrando página _PAGE_ de _PAGES_",
                            infoEmpty: "No hay registros disponibles",
                            infoFiltered: "(filtrado de _MAX_ registros totales)",
                            search: "Buscar:",
                            paginate: {
                                first: "Primero",
                                last: "Último",
                                next: "Siguiente",
                                previous: "Anterior"
                            }
                        }
                    });

                    console.log("✅ DataTable inicializado correctamente");

                }, 500); // ⏳ Esperar 500ms antes de inicializar DataTables
            });
        },
        handleLoginClick() {
            console.log("Botón Iniciar sesión presionado"); // Verificar si se ejecuta
            this.showModal = true;
            console.log(this.showModal); // Verifica si se actualiza el estado
        },
        getHoraSalida(sinIngreso, horaSalida) {
            if (sinIngreso == 1) {
                return "Sin Ingreso";
            }
            return horaSalida && horaSalida !== "null" ? horaSalida : "N/A";
        },
        getHoraRetorno(sinRetorno, horaRetorno) {
            if (sinRetorno == 1) {
                return "Sin Retorno";
            }
            return horaRetorno && horaRetorno !== "null" ? horaRetorno : "N/A";
        },
        getEstadoSolicitud(estado) {
            switch (estado) {
                case 1:
                    return "<span style='background-color: #ffc107; color: #fff;'>En proceso</span>";
                case 2:
                    return "<span style='background-color: #007bff; color: #fff;  padding: 5px 10px; border-radius: 5px;'>Aprobado</span>";
                case 3:
                    return "<span style='background-color: #dc3545; color: #fff;  padding: 5px 10px; border-radius: 5px;'>Denegado</span>";
                case 4:
                    return "<span style='background-color: #ffc107; color: #fff;  padding: 5px 10px; border-radius: 5px;'>En proceso - Aprobación Gerencia</span>";
                case 5:
                    return "<span style='background-color: #ffc107; color: #fff;  padding: 5px 10px; border-radius: 5px;'>En proceso - Aprobación RRHH</span>";
                default:
                    return "<span class='shadow-none badge badge-primary'>Error</span>";
            }
        },
        getMotivo(idMotivo, motivo) {
            if (idMotivo == 1) {
                return "Laboral";
            } else if (idMotivo == 2) {
                return "Personal";
            } else {
                return motivo;
            }
        },
        obtenerTextoEstado(estado) {
            switch (estado) {
                case 1:
                    return 'En Proceso de aprobación';
                case 2:
                    return 'Aprobados';
                case 3:
                    return 'Denegados';
                default:
                    return 'Desconocido';
            }
        },
    }
}
</script>

<style scoped></style>
