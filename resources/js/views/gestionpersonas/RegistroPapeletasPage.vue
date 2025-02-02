<template>
    <div>
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
            papeletas: [], // Aquí almacenaremos los datos de la tabla
        };
    },
    mounted() {
        this.fetchPapeletas(); // Llamamos a la función para obtener los datos
    },
    methods: {
        fetchPapeletas() {
            axios.get('http://localhost:8000/api/papeletas')
                .then(response => {
                    console.log("###11")
                    console.log(response.data)
                    this.papeletas = response.data; // Guardamos los datos en papeletas
                    this.$nextTick(() => {
                        // Inicializamos DataTable después de que los datos estén listos
                        $('#tablaPapeletas').DataTable();
                    });
                })
                .catch(error => {
                    console.error('Hubo un error al obtener los datos:', error);
                });
        }
    }
}
</script>

<style scoped>
/* Agrega tus estilos personalizados si es necesario */
</style>
