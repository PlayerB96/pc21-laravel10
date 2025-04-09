<template>
  <div class="container">
    <div class="content-section">
      <h3>Evaluación de Inducción</h3>

      <!-- Mensaje de carga -->
      <p v-if="loading" class="loading-text">Cargando preguntas...</p>

      <!-- Mensaje de error -->
      <p v-if="error" class="error-text">{{ error }}</p>

      <!-- Formulario -->
      <form v-if="!loading && preguntas.length" @submit.prevent="submitSurvey">
        <div v-for="(pregunta, index) in preguntas" :key="pregunta.id_pregunta" class="form-group">
          <label class="pregunta-label">Pregunta {{ index + 1 }}: {{ pregunta.pregunta }}</label>

          <div v-for="respuesta in pregunta.respuestas" :key="respuesta.id_respuesta" class="form-responses">
            <input type="checkbox" :value="respuesta.id_respuesta"
              v-model="respuestasSeleccionadas[pregunta.id_pregunta]" class="respuesta-checkbox"
              @change="validarSeleccion(pregunta.id_pregunta)" />
            <label class="respuesta-label">{{ respuesta.desc_respuesta }}</label>
          </div>
        </div>
        <button type="submit" class="btn-submit">Enviar Respuestas</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const preguntas = ref([]);
    const respuestasSeleccionadas = reactive({});
    const loading = ref(true);
    const error = ref(null);
    const router = useRouter();

    const obtenerPreguntas = async () => {
      try {
        const response = await axios.get('/induccion/preguntas_induccion');
        preguntas.value = response.data.preguntas;
        preguntas.value.forEach(pregunta => {
          respuestasSeleccionadas[pregunta.id_pregunta] = [];
        });
        loading.value = false;
      } catch (err) {
        error.value = 'Error al cargar las preguntas. Inténtalo nuevamente.';
        loading.value = false;
      }
    };
    // localStorage.setItem('userSession', JSON.stringify(response.data.sessionData));

    const validarSeleccion = (id_pregunta) => {
      if (!Array.isArray(respuestasSeleccionadas[id_pregunta])) {
        respuestasSeleccionadas[id_pregunta] = [];
      }

      if (respuestasSeleccionadas[id_pregunta].length > 3) {
        respuestasSeleccionadas[id_pregunta].pop();
        Swal.fire({
          icon: 'warning',
          title: 'Límite alcanzado',
          text: 'Solo puedes seleccionar un máximo de 3 respuestas por pregunta.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Entendido',
        });
      }
    };

    const submitSurvey = async () => {
      for (const id_pregunta in respuestasSeleccionadas) {
        if (respuestasSeleccionadas[id_pregunta].length === 0) {
          Swal.fire({
            icon: 'error',
            title: 'Faltan respuestas',
            text: 'Debes seleccionar al menos 1 respuesta en cada pregunta.',
          });
          return;
        }
      }
      try {
        let userSession = JSON.parse(localStorage.getItem('userSession'));
        const response = await axios.post('/induccion/submit_survey', {
          respuestas: respuestasSeleccionadas,
          id_usuario: userSession.id_usuario,
        });
        if (response.data.porcentaje > 90) {
          if (userSession) {
            // 🔹 Modificar inducción a 1
            userSession.induccion = 1;
            localStorage.setItem('userSession', JSON.stringify(userSession));
            // 🔹 Emitir evento para notificar el cambio
            window.dispatchEvent(new Event("storage"));
          }
          // 🔹 Mostrar alerta con temporizador y redirigir automáticamente
          Swal.fire({
            icon: 'success',
            title: '¡Felicidades!',
            text: `Has aprobado con un ${response.data.porcentaje}% de aciertos.`,
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
            willClose: () => {
              router.push('/gestionpersonas/registro_colaboradores');
            }
          });
        } else {
          Swal.fire({
            icon: 'warning',
            title: 'Inténtalo de nuevo',
            text: `Tu puntaje es del ${response.data.porcentaje}%.`,
          });
        }
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo enviar la evaluación. Inténtalo nuevamente.',
        });
      }
    };

    onMounted(obtenerPreguntas);

    return {
      preguntas,
      respuestasSeleccionadas,
      loading,
      error,
      obtenerPreguntas,
      validarSeleccion,
      submitSurvey,
    };
  },
};
</script>

<style scoped>
/* 🎨 Estilos Generales */
.container {
  width: 100%;
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
}

/* 📝 Encabezado */
h3 {
  font-size: 1.8rem;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
}

/* 🔄 Mensajes de carga y error */
.loading-text {
  font-size: 1.2rem;
  color: #888;
}

.error-text {
  font-size: 1.2rem;
  color: #d9534f;
  font-weight: bold;
}

/* 📌 Preguntas */
.form-group {
  text-align: left;
  margin-bottom: 20px;
}

.pregunta-label {
  font-size: 1.2rem;
  font-weight: bold;
  color: #444;
  display: block;
  margin-bottom: 10px;
}

/* ✅ Respuestas */
.form-responses {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

.respuesta-checkbox {
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.respuesta-label {
  font-size: 1rem;
  color: #555;
}

/* 🎯 Botón de enviar */
.btn-submit {
  background: #007bff;
  color: white;
  font-size: 1rem;
  font-weight: bold;
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.3s;
}

.btn-submit:hover {
  background: #0056b3;
}

/* 📱 Diseño Responsivo */
@media (max-width: 768px) {
  .container {
    width: 90%;
    padding: 15px;
  }

  h3 {
    font-size: 1.5rem;
  }

  .pregunta-label {
    font-size: 1.1rem;
  }

  .respuesta-label {
    font-size: 0.95rem;
  }

  .btn-submit {
    width: 100%;
  }
}
</style>
