<template>
    <div>
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
            <button class="btn-primary" @click="showModal = true">Registrar Papeleta</button>
        </div>

        <registrar-papeleta-modal :isVisible="showModal" @update:isVisible="showModal = $event" />
        <SkeletonLoaderTable v-if="cargando" :rows="10" />

        <div v-if="!cargando && papeletas.length">
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
                        <td>{{ papeleta.destino }}</td>
                        <td>{{ papeleta.tramite }}</td>
                        <td>{{ papeleta.fec_solicitud }}</td>
                        <td align="center">{{ papeleta.hora_salida }}</td>
                        <td align="center">{{ papeleta.hora_retorno }}</td>
                        <td v-html="papeleta.estado_solicitud"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h1 v-else-if="!cargando">No hay registros disponibles.</h1>
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
        const userSession = localStorage.getItem('userSession');
        if (!userSession) {
            this.$router.push('/inicio'); // Redirigir a la vista de inicio si no hay sesión
        } else {
            this.buscarRegistroPapeleta();
        }
    },
    methods: {
        async buscarRegistroPapeleta() {
            this.cargando = true;
            try {
                const userSession = JSON.parse(localStorage.getItem('userSession'));
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                const { data } = await axios.post('gestionpersonas/buscar_papeletas', {
                    estado_solicitud: this.estadoSeleccionado,
                    id_usuario: userSession.id_usuario,
                }, {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                this.papeletas = data.list_papeletas_salida?.map(papeleta => ({
                    ...papeleta,
                    destino: papeleta.destino?.nom_destino || "Sin destino",
                    tramite: papeleta.tramite?.nom_tramite || "Sin trámite",
                    hora_salida: this.getHoraSalida(papeleta.sin_ingreso, papeleta.hora_salida),
                    hora_retorno: this.getHoraRetorno(papeleta.sin_retorno, papeleta.hora_retorno),
                    estado_solicitud: this.getEstadoSolicitud(papeleta.estado_solicitud),
                })) || [];

                this.$nextTick(this.initDataTable);
            } catch (error) {
                console.error('Error al buscar papeletas:', error);
            } finally {
                this.cargando = false;
            }
        },
        initDataTable() {
            if (!this.papeletas.length) return;
            this.$nextTick(() => {
                if ($.fn.DataTable.isDataTable("#tablaPapeletas")) {
                    $('#tablaPapeletas').DataTable().destroy();
                }
                $('#tablaPapeletas').DataTable({
                    responsive: true,
                    autoWidth: false,
                    scrollX: true,
                    pageLength: 10,
                    language: {
                        lengthMenu: "Mostrar _MENU_ registros por página",
                        zeroRecords: "No hay datos disponibles",
                        info: "Mostrando página _PAGE_ de _PAGES_",
                        search: "Buscar:",
                        paginate: { next: "Siguiente", previous: "Anterior" }
                    }
                });
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

<style scoped>
/* Estilos para la etiqueta */
.control-label {
    font-size: 16px;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

/* Estilos para el select */
.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 2px solid #007bff;
    border-radius: 5px;
    background-color: #fff;
    color: #333;
    transition: all 0.3s ease;
    outline: none;
}

/* Cambia el borde y color al enfocar el select */
.form-control:focus {
    border-color: #0056b3;
    box-shadow: 0 0 5px rgba(0, 91, 187, 0.5);
}

/* Ajusta el tamaño del texto en las opciones */
.form-control option {
    font-size: 14px;
    padding: 10px;
}

/* Cambia el fondo cuando el usuario selecciona una opción */
.form-control:active {
    background-color: #f0f8ff;
}
</style>
