<template>
    <div class="section-container">
        <div v-if="section.title === 'Referencias Familiares'">
            <button type="button" @click="validarYAgregarReferencia" class="btn-add">Agregar Referencia</button>
        </div>
        <div v-if="section.title === 'Contacto de Emergencia'">
            <button type="button" @click="validarYAgregarContactoEmergencia" class="btn-add">Agregar Contacto de
                Emergencia</button>
        </div>
        <div v-if="section.title === 'Conocimientos de Idiomas'">
            <button type="button" @click="validarYAgregarIdioma" class="btn-add">Agregar Idioma</button>
        </div>
        <div v-if="section.title === 'Cursos Complementarios'">
            <button type="button" @click="validarYAgregarCurso" class="btn-add">Agregar Curso</button>
        </div>
        <div v-if="section.title === 'Experiencia Laboral'">
            <button type="button" @click="validarYAgregarExperiencia" class="btn-add">Agregar Experiencia</button>
        </div>
        <div v-if="section.title === 'Enfermedades'">
            <button type="button" @click="validarYAgregarEnfermedad" class="btn-add">Agregar Enfermedad</button>
        </div>
        <div v-if="section.title === 'Alergias'">
            <button type="button" @click="validarYAgregarAlergia" class="btn-add">Agregar Alergia</button>
        </div>
        <div class="section-title">{{ section.title }}</div>
        <div class="form-container">
            <div v-for="(field, index) in section.fields" :key="index" class="form-group form-group-3col">
                <label>{{ field.label }}</label>
                <input v-if="field.type === 'text'" type="text" v-model="model[field.name]" :required="field.required">
                <input v-if="field.type === 'number'" type="number" v-model="model[field.name]"
                    :required="field.required">
                <input v-if="field.type === 'date'" type="date" v-model="model[field.name]" :required="field.required">
                <input v-if="field.type === 'file'" type="file" @change="handleFileUpload($event, field.name)"
                    :required="field.required">
                <select v-if="field.type === 'select'" v-model="model[field.name]" :required="field.required">
                    <option v-for="option in field.options" :key="option" :value="option">{{ option }}</option>
                </select>
            </div>
        </div>
        <slot></slot>
    </div>
</template>

<script>
import Swal from 'sweetalert2';

export default {
    props: {
        section: {
            type: Object,
            required: true
        },
        model: {
            type: [Object, Array],
            required: true
        }
    },
    methods: {
        validarYAgregarReferencia() {
            const camposValidos = this.section.fields.every(field => {
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== 'Seleccione';
                }
                return true;
            });

            if (camposValidos) {
                this.$emit('agregar-referencia');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
            }
        },
        validarYAgregarContactoEmergencia() {
            const camposValidos = this.section.fields.every(field => {
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== 'Seleccione';
                }
                return true;
            });

            if (camposValidos) {
                this.$emit('agregar-contacto-emergencia');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
            }
        },
        validarYAgregarIdioma() {
            const camposValidos = this.section.fields.every(field => {
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== 'Seleccione';
                }
                return true;
            });

            if (camposValidos) {
                this.$emit('agregar-idioma');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
            }
        },
        validarYAgregarCurso() {
            const camposValidos = this.section.fields.every(field => {
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== 'Seleccione';
                }
                return true;
            });

            if (camposValidos) {
                this.$emit('agregar-curso');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
            }
        },
        validarYAgregarExperiencia() {
            const camposValidos = this.section.fields.every(field => {
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== 'Seleccione';
                }
                return true;
            });

            if (camposValidos) {
                this.$emit('agregar-experiencia');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
            }
        },
        validarYAgregarEnfermedad() {
            console.log('Validar y agregar enfermedad');
            const camposValidos = this.section.fields.every(field => {
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== 'Seleccione';
                }
                return true;
            });

            if (camposValidos) {
                this.$emit('agregar-enfermedad');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
            }
        },
        validarYAgregarAlergia() {
            console.log('Validar y agregar enfermedad');
            const camposValidos = this.section.fields.every(field => {
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== 'Seleccione';
                }
                return true;
            });

            if (camposValidos) {
                this.$emit('agregar-alergia');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor, complete todos los campos requeridos.',
                });
            }
        },
        handleFileUpload(event, fieldName) {
            const file = event.target.files[0];
            if (file) {
                // 🔹 Guarda el nombre del archivo en el modelo directamente
                this.model[fieldName] = file.name;
                // 🔹 Opcionalmente, emite el evento para notificar al componente padre
                this.$emit('file-upload', { file, fieldName });
            }
        }
    }
};
</script>

<style scoped>
.section-container {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    width: 100%;
    /* Extiende completamente el ancho */
    box-sizing: border-box;
    /* Incluye el padding y el borde en el ancho total */
}

.section-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}

.form-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.form-group {
    flex: 1 1 100%;
    min-width: 200px;
    display: flex;
    flex-direction: column;
}

.form-group-3col {
    flex: 1 1 calc(33.333% - 20px);
}

.form-group label {
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.btn-add {
    margin-top: 10px;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    align-self: center;
}

.btn-add:hover {
    background-color: #218838;
}
</style>