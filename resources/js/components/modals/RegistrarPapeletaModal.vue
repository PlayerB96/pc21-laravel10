<template>
    <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content wide-modal">
            <h2>Registrar Papeleta</h2>

            <div class="wide-content">
                <form id="formulario_papeletas_salida_registro" method="POST"
                    action="{{ url('Papeletas/Insert_or_Update_Papeletas_Salida') }}">
                    <div class="papeletas_salida_card">
                        <div class="form-container">
                            <div class="form-group">
                                <label class="control-label">Motivo de Salida:</label>
                                <div style="display: flex;">
                                    <label class="radio-label">
                                        <input type="radio" v-model="formulario.id_motivo" value="1">
                                        Laboral
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" v-model="formulario.id_motivo" value="2">
                                        Personal
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Fecha de Solicitud:</label>
                                <input type="date" class="form-control" v-model="formulario.fec_solicitud">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Destino:</label>
                                <select class="form-control" v-model="formulario.destino">
                                    <option value="0">Seleccione</option>
                                    <option value="1">Destino 1</option>
                                    <option value="2">Destino 2</option>
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
                                    <option value="1">Trámite 1</option>
                                    <option value="2">Trámite 2</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Especifique:</label>
                                <input type="text" class="form-control" v-model="formulario.especificacion_tramite"
                                    placeholder="Especifique trámite">
                            </div>

                            <div class="form-group">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                    <input type="checkbox" v-model="formulario.sin_retorno" class="new-control-input">
                                    <span class="new-control-indicator"></span>&nbsp;&nbsp;Sin retorno
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                    <input type="checkbox" v-model="formulario.sin_ingreso" class="new-control-input">
                                    <span class="new-control-indicator"></span>&nbsp;&nbsp;Sin ingreso
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Hora Salida:</label>
                                <input type="time" class="form-control" v-model="formulario.hora_salida">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Hora Retorno:</label>
                                <input type="time" class="form-control" v-model="formulario.hora_retorno">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-primary" @click="guardarPapeleta">Guardar</button>
                <button type="button" class="btn-secondary" @click="closeModal">Cancelar</button>
            </div>
        </div>
    </div>
</template>

<script>
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
            }
        };
    },
    methods: {
        closeModal() {
            this.$emit('update:isVisible', false);
        },
        async guardarPapeleta() {
            console.log("Guardando papeleta:", this.formulario);

            // Simulación de envío al backend
            setTimeout(() => {
                alert("Papeleta guardada correctamente.");
                this.closeModal(); // Cerrar el modal después de guardar
            }, 1000);
        }
    }
};
</script>

<style scoped>
/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    width: 500px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Formulario */
.form-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 15px;
}

.control-label {
    font-weight: bold;
}

.input-field {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Botones */
.form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.btn-primary {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
</style>
