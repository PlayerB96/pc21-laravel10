<template>
    <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
            <h1>Registrar Papeleta</h1>
            <div class="wide-content">
                <form @submit.prevent="enviarFormulario" class="login-form">
                    <div class="form-container">
                        <div class="form-group">
                            <label class="control-label">Motivo de Salida:</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" v-model="formulario.id_motivo" value="1"
                                        @change="fetchDestinos(1)">
                                    Laboral
                                </label>
                                <label class="radio-label">
                                    <input type="radio" v-model="formulario.id_motivo" value="2"
                                        @change="fetchDestinos(2)">
                                    Personal
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Fecha de Solicitud:</label>
                            <input type="date" class="form-control" v-model="formulario.fec_solicitud" :min="minDate">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Destino:</label>
                            <select class="form-control" v-model="formulario.destino" @change="fetchTramites">
                                <option value="0">Seleccione</option>
                                <option v-for="destino in destinos" :key="destino.id" :value="destino.id">{{
                                    destino.nombre }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Especifique:</label>
                            <input type="text" class="form-control" v-model="formulario.especificacion_destino"
                                placeholder="Especifique destino">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Trámite:</label>
                            <select class="form-control" v-model="formulario.tramite">
                                <option value="0">Seleccione</option>
                                <option v-for="tramite in tramites" :key="tramite.id" :value="tramite.id">{{
                                    tramite.nombre }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Especifique:</label>
                            <input type="text" class="form-control" v-model="formulario.especificacion_tramite"
                                placeholder="Especifique trámite">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                <input type="checkbox" v-model="formulario.sin_ingreso">
                                Sin ingreso
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="control-label">
                                <input type="checkbox" v-model="formulario.sin_retorno">
                                Sin retorno
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Hora Salida:</label>
                            <input type="time" class="form-control" v-model="formulario.hora_salida"
                                :disabled="formulario.sin_ingreso">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Hora Retorno:</label>
                            <input type="time" class="form-control" v-model="formulario.hora_retorno"
                                :disabled="formulario.sin_retorno">
                        </div>
                       

                       
                    </div>
                </form>
            </div>
            <div class="footer-content">
                <p>{{ errorMessage }}</p>
                <div class="form-actions">
                    <button type="button" class="btn-primary" @click="enviarFormulario">Guardar</button>
                    <button type="button" class="btn-secondary" @click="closeModal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    props: {
        isVisible: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            formulario: {
                id_motivo: '',
                fec_solicitud: '',
                destino: '',
                especificacion_destino: '',
                tramite: '',
                especificacion_tramite: '',
                sin_retorno: false,
                sin_ingreso: false,
                hora_salida: '',
                hora_retorno: ''
            },
            destinos: [],
            tramites: [],
            errorMessage: '',
            minDate: new Date().toISOString().split('T')[0], // Fecha mínima para el input de fecha
        };
    },
    watch: {
        'formulario.sin_retorno'(newVal) {
            if (newVal) {
                this.formulario.hora_salida = '';
            }
        },
        'formulario.sin_ingreso'(newVal) {
            if (newVal) {
                this.formulario.hora_retorno = '';
            }
        }
    },
    methods: {
        closeModal() {
            this.$emit('update:isVisible', false);
        },
        async guardarPapeleta() {
            // Simulación de envío al backend
            setTimeout(() => {

                alert("Papeleta guardada correctamente.");
                this.closeModal(); // Cerrar el modal después de guardar
            }, 1000);
        },
        async fetchDestinos(motivo) {
            try {
                const response = await axios.get(`/gestionpersonas/cambiar_motivo?motivo=${motivo}`);
                this.destinos = response.data;
            } catch (error) {
                console.error("Error fetching destinos:", error);
            }
        },
        async fetchTramites() {
            try {
                const response = await axios.get(`/gestionpersonas/traer_tramite?id_destino=${this.formulario.destino}`);
                this.tramites = response.data;
            } catch (error) {
                console.error("Error fetching tramites:", error);
            }
        },
        async enviarFormulario() {
            const userSession = JSON.parse(localStorage.getItem('userSession'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            try {
                const response = await axios.post('/gestionpersonas/store', {
                    formulario: this.formulario,
                    id_usuario: userSession.id_usuario,
                    id_gerencia: userSession.id_gerencia,
                    cod_ubi: userSession.cod_ubi,
                }, {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Papeleta guardada correctamente.',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.closeModal();
            } catch (error) {
                this.handleError(error, "Error al guardar la papeleta.");
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar la papeleta.',
                });
            }
        },
        handleError(error, message) {
            // Mostrar un mensaje de error al usuario
            this.errorMessage = message;
            // Registrar el error (puedes usar una herramienta como Sentry aquí)
            console.error(message, error);
        }
    }
};
</script>

<style scoped>
.control-label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.radio-group {
    display: flex;
    gap: 10px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style>