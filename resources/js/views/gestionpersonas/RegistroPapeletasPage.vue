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
        <!-- Tabla de Papeletas -->
        <table id="tablaPapeletas" class="display">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Centro de Labores</th>
                    <th>Área</th>
                    <th>Destino</th>
                    <th>Trámite</th>
                    <th>Fecha Registro</th>
                    <th>Estado Solicitud</th>
                </tr>
            </thead>
            <tbody>
                <!-- Renderizamos los datos dinámicamente aquí -->
                <tr v-for="(papeleta, index) in papeletas" :key="index">
                    <td>{{ papeleta.usuario_nombres }} {{ papeleta.usuario_apater }} {{ papeleta.usuario_amater }}</td>
                    <td>{{ papeleta.centro_labores }}</td>
                    <td>{{ papeleta.nom_area }}</td>
                    <td>{{ papeleta.destino }}</td>
                    <td>{{ papeleta.tramite }}</td>
                    <td>{{ papeleta.fec_reg }}</td>
                    <td>{{ papeleta.estado_solicitud }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'RegistroPapeletasPage',
    data() {
        return {
            papeletas: [],
            estadoSeleccionado: '1', // Por defecto "En Proceso de aprobación"
        };
    },
    mounted() {
        this.buscarRegistroPapeleta(); // Cargar datos iniciales
    },
    methods: {
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

        async buscarRegistroPapeleta() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            await axios.post('http://localhost:8000/api/gestionpersonas/buscar_papeletas', {
                estado_solicitud: this.estadoSeleccionado
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
                .then(response => {
                    console.log(response);
                    console.log("####111")
                    this.papeletas = response.data.list_papeletas_salida;
                    this.$nextTick(() => {

                        // Destruir y volver a inicializar DataTable para actualizar datos
                        const table = $('#tablaPapeletas').DataTable();
                        table.clear();
                        table.rows.add($('#tablaPapeletas tbody tr')).draw();
                    });
                })
                .catch(error => {
                    console.error('Error al buscar papeletas:', error);
                });
        }
    }
}
</script>

<style scoped>
/* Agrega tus estilos personalizados si es necesario */
</style>
