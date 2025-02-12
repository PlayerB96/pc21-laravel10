<template>
    <div>
        <h2>Fichas Técnicas</h2>
        <SkeletonLoaderTable v-if="cargando" :rows="10" :columns="4" />

        <div v-if="!cargando && fichasTecnicas.length">
            <table id="tablaFichasTecnicas" class="display">
                <thead>
                    <tr>
                        <th>Fecha Registro</th>
                        <th>Creado Por</th>
                        <th>Modelo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ficha, index) in fichasTecnicas" :key="index">
                        <td>{{ ficha.fec_reg }}</td>
                        <td>{{ ficha.user.nombre_completo }}</td>
                        <td>{{ ficha.modelo }}</td>
                        <td>
                            <button @click="verImagen(ficha.img_ft_produccion)" class="btn btn-link">
                                <i class="fas fa-file-pdf"></i> Ver PDF
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h1 v-else-if="!cargando">{{ messageError }}</h1>
    </div>
</template>

<script>
import axios from 'axios';
import SkeletonLoaderTable from '../../components/skeleton/SkeletonLoaderTable.vue';

export default {
    components: { SkeletonLoaderTable },
    name: 'RegistroFichasTecnicasPage',
    data() {
        return {
            fichasTecnicas: [],
            estadoSeleccionado: '1',
            showModal: false,
            cargando: true,
            messageError: 'No hay registros disponibles.' 

        };
    },
    mounted() {
        this.buscarFichasTecnicas();
    },
    methods: {
        async buscarFichasTecnicas() {
            this.cargando = true;
            try {
                const { data } = await axios.post('/produccion/buscar_fichas_tecnicas', {
                    estado: this.estadoSeleccionado,
                });
                this.fichasTecnicas = data.list_ficha_tecnica || [];
                this.$nextTick(this.initDataTable);
            } catch (error) {
                console.error('Error al buscar fichas técnicas:', error);
                this.messageError = error.response.data.message;

            } finally {
                this.cargando = false;
            }
        },
        initDataTable() {
            if (!this.fichasTecnicas.length) return;
            this.$nextTick(() => {
                if ($.fn.DataTable.isDataTable("#tablaFichasTecnicas")) {
                    $('#tablaFichasTecnicas').DataTable().destroy();
                }
                $('#tablaFichasTecnicas').DataTable({
                    responsive: true,
                    autoWidth: false,
                    scrollX: true,
                    pageLength: 10,
                    order: [], 
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
        verImagen(imgPath) {
            const url = `${imgPath}`;
            window.open(encodeURI(url), '_blank');
        }
    }
}
</script>

<style scoped>
/* Agrega tus estilos aquí */
</style>