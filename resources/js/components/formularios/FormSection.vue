<template>
    <div class="section-container">
        <div v-if="section.title === 'Referencias Familiares'">
            <button type="button" @click="validarYAgregarReferencia" class="btn-primary">Agregar Referencia</button>
        </div>
        <div v-if="section.title === 'Contacto de Emergencia'">
            <button type="button" @click="validarYAgregarContactoEmergencia" class="btn-primary">Agregar Contacto de
                Emergencia</button>
        </div>
        <div v-if="section.title === 'Conocimientos de Idiomas'">
            <button type="button" @click="validarYAgregarIdioma" class="btn-primary">Agregar Idioma</button>
        </div>
        <div v-if="['Cursos Complementarios', 'Experiencia Laboral', 'Enfermedades', 'Alergias', 'Datos de Hijos/as'].includes(section.title)"
            class="switch-container">
            <label class="switch">
                <input type="checkbox" v-model="cursoEditable">
                <span class="slider round"></span>
            </label>
            <span class="switch-label">No Aplica</span>
        </div>
        <!-- Botón de agregar curso solo aparece si la edición está deshabilitada -->
        <div v-if="section.title === 'Cursos Complementarios' && !cursoEditable">
            <button type="button" @click="validarYAgregarCurso" class="btn-primary">
                Agregar Curso
            </button>
        </div>
       
        <div v-if="section.title === 'Experiencia Laboral' && !cursoEditable">
            <button type="button" @click="validarYAgregarExperiencia" class="btn-primary">Agregar Experiencia</button>
        </div>
        <div v-if="section.title === 'Enfermedades' && !cursoEditable">
            <button type="button" @click="validarYAgregarEnfermedad" class="btn-primary">Agregar Enfermedad</button>
        </div>
        <div v-if="section.title === 'Alergias' && !cursoEditable">
            <button type="button" @click="validarYAgregarAlergia" class="btn-primary">Agregar Alergia</button>
        </div>
        <div v-if="section.title === 'Datos de Hijos/as' && !cursoEditable">
            <button type="button" @click="validarYAgregarHijo" class="btn-primary">Agregar Hijos</button>
        </div>

        <div class="section-title">{{ section.title }}</div>
        <div class="form-container">
            <div v-for="(field, index) in section.fields" :key="index" class="form-group form-group-3col">
                <label>{{ field.label }}</label>
                <input v-if="field.type === 'text'" type="text" v-model="model[field.name]" :required="field.required"
                    :disabled="isFieldDisabled()">
                <input v-if="field.type === 'number'" type="number" v-model="model[field.name]"
                    :required="field.required" :disabled="isFieldDisabled()">
                <input v-if="field.type === 'email'" type="email" v-model="model[field.name]" :required="field.required"
                    :disabled="isFieldDisabled()">
                <input v-if="field.type === 'date'" type="date" v-model="model[field.name]" :required="field.required"
                    :disabled="isFieldDisabled()">
                <input v-if="field.type === 'file'" type="file" @change="handleFileUpload($event, field.name)"
                    :required="field.required" :disabled="isFieldDisabled()">

                <select v-if="field.type === 'select'" v-model="model[field.name]" :required="field.required"
                    @change="onSelectChange(field.name, model[field.name])" :disabled="isFieldDisabled()">
                    <option v-for="option in field.options" :key="option.id" :value="option.id">
                        {{ option.text }}
                    </option>
                </select>
            </div>
        </div>
        <slot></slot>
    </div>
</template>


<script>
import Swal from 'sweetalert2';
import axios from 'axios';

export default {
    data() {
        return {
            formData: {
                id_departamento: '',
                id_provincia: '',
                id_distrito: ''
            },
            cursoEditable: false
        };
    },

    props: {
        section: {
            type: Object,
            required: true,
            requiredT: true

        },
        model: {
            type: [Object, Array],
            required: true,
            requiredT: true

        }
    },
    methods: {
        isFieldDisabled() {
            return [
                'Cursos Complementarios',
                'Experiencia Laboral',
                'Enfermedades',
                'Alergias',
                'Datos de Hijos/as'
            ].includes(this.section.title) && this.cursoEditable;
        },
        onSelectChange(fieldName, value) {
            if (!this.formData) {
                console.error("formData no está definido.");
                return;
            }

            if (fieldName === 'id_departamento') {
                console.log('Departamento seleccionado:', value);
                this.formData.id_departamento = value;
                this.loadProvincias();
            } else if (fieldName === 'id_provincia') {
                console.log('Provincia seleccionada:', value);
                this.formData.id_provincia = value;
                this.loadDistritos();
            }
        },
        // Obtener provincias basadas en el departamento seleccionado
        loadProvincias() {
            if (!this.formData.id_departamento) {
                console.warn("No hay un departamento seleccionado.");
                return;
            }

            axios.get('/provincias', { params: { id_departamento: this.formData.id_departamento } })
                .then(response => {
                    console.log("Provincias recibidas:", response.data);

                    this.provincias = response.data.map(item => ({
                        id: item.id_provincia,
                        text: item.nombre_provincia
                    }));

                    // 🔹 CORRECCIÓN: Usar `this.section.fields` en lugar de `this.formData.fields`
                    const provinciaField = this.section.fields.find(field => field.name === 'id_provincia');
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
            if (!this.formData.id_provincia) {
                console.warn("No hay una provincia seleccionada.");
                return;
            }

            axios.get('/distritos', { params: { id_provincia: this.formData.id_provincia } })
                .then(response => {
                    console.log("Distritos recibidos:", response.data);

                    this.distritos = response.data.map(item => ({
                        id: item.id_distrito, // Asegúrate de que este campo existe en la respuesta
                        text: item.nombre_distrito // Asegúrate de que este campo también existe en la respuesta
                    }));

                    // 🔹 CORRECCIÓN: Usar `this.section.fields` en lugar de `this.sections[1].fields`
                    const distritoField = this.section.fields.find(field => field.name === 'id_distrito');
                    if (distritoField) {
                        distritoField.options = [...this.distritos]; // Asegurar reactividad
                    }

                    this.formData.id_distrito = ''; // Limpiar selección de distrito
                })
                .catch(error => {
                    // console.error('Error al obtener distritos:", error);
                });
        },


        validarYAgregarReferencia() {
            console.log("Modelo actual:", this.model); // Verifica los datos antes de validar
            console.log("#############11111");

            const camposValidos = this.section.fields.every(field => {
                console.log("Campo validado:", field.name, "Valor:", this.model[field.name]);
                console.log(field.required)
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== '';
                }
                return true;
            });

            console.log("¿Campos válidos?:", camposValidos);

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
        validarYAgregarHijo() {
            const camposValidos = this.section.fields.every(field => {
                if (field.required) {
                    return this.model[field.name] && this.model[field.name] !== 'Seleccione';
                }
                return true;
            });

            if (camposValidos) {
                this.$emit('agregar-hijo');
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
                this.$emit('file-selected', { fieldName, file }); // Emitir evento para actualizar en RegistroColaboradorPage
                this.model[fieldName] = file;
                console.log(`Archivo seleccionado para ${fieldName}:`, file);
            }
        }

    }
};
</script>

<style scoped>
.switch-container {
    margin: 1rem;
    display: flex;
    align-items: center;
}

.switch {
    position: relative;
    display: inline-block;
    width: 34px;
    height: 20px;
    margin-right: 10px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 20px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:checked+.slider:before {
    transform: translateX(14px);
}

.switch-label {
    font-size: 16px;
    color: #333;
    background-color: #f8d7da;
    color: #721c24;
    padding: 5px 10px;
    border-radius: 5px;
}

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
</style>