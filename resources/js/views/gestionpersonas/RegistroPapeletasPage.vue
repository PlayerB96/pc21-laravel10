<template>
    <div>
        <div class="mb-4 toolbar-row">
            <div class="toolbar-item">
                <label class="control-label text-bold">Estado Solicitud:</label>
                <select v-model="estadoSeleccionado" @change="buscar_papeletas" class="form-control">
                    <option value="0">Todos</option>
                    <option value="1">En Proceso de aprobación</option>
                    <option value="2">Aprobados</option>
                    <option value="3">Denegados</option>
                </select>
            </div>
            <div class="toolbar-item">
                <label class="control-label text-bold">Fecha Inicio:</label>
                <input type="date" v-model="fechaInicio" class="form-control" @change="buscar_papeletas" />
            </div>

            <div class="toolbar-item">
                <label class="control-label text-bold">Fecha Fin:</label>
                <input type="date" v-model="fechaFin" class="form-control" @change="buscar_papeletas" />
            </div>

        </div>

        <div>
            <button class="btn-primary" @click="showModal = true">Registrar Papeleta</button>
        </div>

        <registrar-papeleta-modal :isVisible="showModal" @update:isVisible="showModal = $event"
            @papeletaGuardada="buscar_papeletas" />
        <SkeletonLoaderTable v-if="busquedaManual" :rows="10" :columns="10" />

        <div v-if="!busquedaManual && papeletas.length">
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
                        <th>Acciones</th>
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
                        <td v-html="papeleta.estado_solicitud.html"></td>
                        <td>
                            <button
                                v-if="canApprove || (papeleta.estado_solicitud.value === 1 || papeleta.estado_solicitud.value === 4 || papeleta.estado_solicitud.value === 5)"
                                class="action-button" @click="confirmarAccionPapeleta(papeleta.id_solicitudes_user)">
                                <img :src="assetsUrl + 'icons/saved.svg'" alt="Aprobar" title="Aprobar"
                                    class="theme-icon" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h1 v-else-if="!busquedaManual">{{ messageError }}</h1>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import RegistrarPapeletaModal from '../../components/modals/RegistrarPapeletaModal.vue';
import SkeletonLoaderTable from '../../components/skeleton/SkeletonLoaderTable.vue'; // 📌 Importamos el nuevo componente

export default {
    components: { RegistrarPapeletaModal, SkeletonLoaderTable },
    name: 'RegistroPapeletasPage',
    data() {
        const today = new Date();
        const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

        return {
            papeletas: [],
            estadoSeleccionado: '1',
            showModal: false,
            busquedaManual: false, // 🔹 Nuevo estado para diferenciar búsqueda manual vs automática
            messageError: 'No hay registros disponibles.',
            assetsUrl: '/assets/',
            intervalId: null,
            canApprove: false,
            fechaInicio: firstDayOfMonth.toISOString().split('T')[0],
            fechaFin: today.toISOString().split('T')[0],
        };
    },

    async mounted() {
        const userSession = JSON.parse(localStorage.getItem('userSession'));
        if (!userSession) {
            this.$router.push('/inicio');
        } else {
            await this.buscar_papeletas(true); // 🔹 Primera búsqueda manual con skeleton
            await this.permissions(userSession); // 🔹 Validar Permisos para Aprobar
            this.intervalId = setInterval(async() => {
                // itera solamenta si se está activo en la página
                if (!document.hidden) {
                    await  this.buscar_papeletas(false); // 🔹 Llamada automática sin skeleton
                }
            }, 50000);
        }
    },

    methods: {
        async permissions(userSession) {
            try {
                const data = await axios.post('/verificar-permisos',
                    {
                        permiso: 'Aprobar_Papeletas',
                        id_puesto: userSession.id_puesto,
                        id_nivel: userSession.id_nivel,
                        id_area: -1,
                        id_sub_gerencia: -1
                    });
                this.canApprove = data.acceso;
            } catch (error) {
                console.error('No tiene permiso:', error);
            }
        },
        async buscar_papeletas(manual = false) {
            if (manual) {
                this.busquedaManual = true; // 🔹 Activa el skeleton solo para búsqueda manual
            }
            try {
                const userSession = JSON.parse(localStorage.getItem('userSession'));
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                const { data } = await axios.post('gestionpersonas/buscar_papeletas', {
                    estado_solicitud: this.estadoSeleccionado,
                    id_usuario: userSession.id_usuario,
                    id_puesto: userSession.id_puesto,
                    id_nivel: userSession.id_nivel,
                    cod_ubi: userSession.cod_ubi,
                    fecha_inicio: this.fechaInicio,
                    fecha_fin: this.fechaFin,
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
                this.messageError = error.response.data?.message || "Error al obtener datos.";
            } finally {
                this.busquedaManual = false; // 🔹 Desactiva el skeleton después de la búsqueda manual
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
        confirmarAccionPapeleta(id_solicitudes_user) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, aprobar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.aprobado_papeletas_salida(id_solicitudes_user);
                }
            });
        },
        async aprobado_papeletas_salida(id_solicitudes_user) {
            try {
                const userSession = JSON.parse(localStorage.getItem('userSession'));
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                const response = await axios.post('/gestionpersonas/aprobado_papeletas_salida',
                    {
                        id_solicitudes_user: id_solicitudes_user,
                        id_usuario: userSession.id_usuario
                    },
                    {
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    });

                if (response.status === 200) {
                    console.log('Acción realizada:', response.data);
                    Swal.fire({
                        title: 'Aprobado',
                        text: 'La papeleta ha sido aprobada correctamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        this.buscar_papeletas(false); // 🔹 Llamamos a la función para actualizar la tabla
                    });
                } else {
                    throw new Error(response.data.message || 'Error desconocido');
                }
            } catch (error) {
                console.error('Error al realizar la acción:', error);
                Swal.fire({
                    title: 'Error',
                    text: error.response?.data?.error || 'Hubo un problema al aprobar la papeleta.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        handleLoginClick() {
            this.showModal = true;
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
                    return { value: 1, html: "<span style='background-color: #ffc107; color: #fff; padding: 5px 10px; border-radius: 5px;'>En proceso</span>" };
                case 2:
                    return { value: 2, html: "<span style='background-color: #007bff; color: #fff; padding: 5px 10px; border-radius: 5px;'>Aprobado</span>" };
                case 3:
                    return { value: 3, html: "<span style='background-color: #dc3545; color: #fff; padding: 5px 10px; border-radius: 5px;'>Denegado</span>" };
                case 4:
                    return { value: 4, html: "<span style='background-color: #ffc107; color: #fff; padding: 5px 10px; border-radius: 5px;'>En proceso - Aprobación Gerencia</span>" };
                case 5:
                    return { value: 5, html: "<span style='background-color: #ffc107; color: #fff; padding: 5px 10px; border-radius: 5px;'>En proceso - Aprobación RRHH</span>" };
                default:
                    return { value: 'error', html: "<span class='shadow-none badge badge-primary'>Error</span>" };
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
.toolbar-row {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-direction: row;
}

.toolbar-item {
    display: flex;
    flex-direction: column;
}

@media (max-width: 768px) {
    .toolbar-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .toolbar-item {
        margin-bottom: 10px;
        width: 100%;
    }
}

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

/* Estilos para el botón de acción */
.action-button {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
}

.action-button:hover .theme-icon {
    transform: scale(1.1);
    transition: transform 0.2s;
}

.action-button:active .theme-icon {
    transform: scale(0.9);
    transition: transform 0.2s;
}
</style>