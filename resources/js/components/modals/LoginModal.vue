<template>
    <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content-login">
            <div class="logo-container">
                <img src="/assets/imgs/Grupo.LN1NegroFTransp.png" alt="Grupo LN1 Logo" class="logo" />
            </div>
            <h2>Iniciar sesión</h2>
            <form @submit.prevent="handleLogin" class="login-form">
                <input type="text" v-model="dni" placeholder="Ingrese su DNI" required class="input-field"
                    @input="validateDNI" autocomplete="off" />
                <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="Contraseña" required
                    class="input-field password-input" autocomplete="off" />
                <!-- <button type="button" class="toggle-password" @click="togglePassword">
                    {{ showPassword ? '👁' : '🙈' }}
                </button> -->

                <button type="submit" class="submit-button" :disabled="loading">
                    <!-- Mostrar spinner cuando loading es true -->
                    <span v-if="loading" class="spinner"></span>
                    <span v-else>Iniciar sesión</span>
                </button>
            </form>

            <p id="mensajeError" class="error-message"></p> <!-- Mensaje de error -->

            <button @click="closeModal" class="close-button">Cerrar</button>
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
            dni: '',
            password: '',
            showPassword: false,
            loading: false // Estado para el spinner
        };
    },
    methods: {
        closeModal() {
            this.$emit('update:isVisible', false);
        },
        validateDNI() {
            this.dni = this.dni.replace(/\D/g, ''); // Solo números
        },
        togglePassword() {
            this.showPassword = !this.showPassword; // 🔹 Alternar visibilidad de la contraseña
        },
        async handleLogin() {
            if (this.dni.length < 8 || isNaN(this.dni)) {
                alert('Por favor, ingrese un DNI válido (8 dígitos).');
                return;
            }

            const csrfMetaTag = document.querySelector('meta[name="csrf-token"]');
            if (!csrfMetaTag) {
                alert('No se encontró el token CSRF en el documento.');
                return;
            }
            const csrfToken = csrfMetaTag.getAttribute('content');
            this.loading = true; // Activar el spinner
            try {
                const response = await axios.post('auth/validate_user', {
                    username: this.dni,
                    password: this.password
                }, {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                // Éxito en la autenticación
                Swal.fire({
                    icon: 'success',
                    title: `¡Bienvenido, ${response.data.sessionData.nombre_completo}!`,
                    text: response.data.message,
                    imageUrl: response.data.sessionData.foto,
                    imageWidth: 100,
                    imageHeight: 100,
                    imageAlt: 'Foto de perfil',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Almacenar toda la sesión en localStorage
                    localStorage.setItem('userSession', JSON.stringify(response.data.sessionData));
                    localStorage.setItem('authToken', response.data.token);
                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
                    window.location.reload();
                });

                this.closeModal(); // Cerrar el modal

            } catch (error) {
                let errorMessage = 'Ocurrió un error desconocido.';
                if (error.response && error.response.data) {
                    errorMessage = error.response.data.error || errorMessage;
                } else if (error.request) {
                    errorMessage = 'Error de conexión al servidor. Verifique su conexión a Internet.';
                } else {
                    errorMessage = `Error inesperado: ${error.message}`;
                }

                document.getElementById('mensajeError').innerText = errorMessage;
            } finally {
                this.loading = false; // Desactivar el spinner
            }
        }

    }
};
</script>



<style scoped>
.modal-content-login {
    background: #fff;
    padding: 30px 20px;
    border-radius: 10px;
    width: 350px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.modal-content-login .p {
    color: #0056b3;
}

.logo-container {
    margin-bottom: 20px;
}

.logo {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    font-weight: bold;
    color: #333;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.input-field {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
    width: 100%;
    margin-bottom: 10px;
    transition: border 0.3s;
}

.input-field:focus {
    border-color: #007bff;
    outline: none;
}

.submit-button {
    padding: 12px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.submit-button:hover {
    background-color: #0056b3;
}

.close-button {
    padding: 10px 15px;
    background-color: #ccc;
    color: #333;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 15px;
    width: 100%;
    transition: background-color 0.3s;
}

.close-button:hover {
    background-color: #bbb;
}

.spinner {
    border: 4px solid #f3f3f3;
    /* Gris claro */
    border-top: 4px solid #3498db;
    /* Azul */
    border-radius: 50%;
    width: 24px;
    height: 24px;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-right: 8px;
}

/* Animación de rotación */
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

/* El botón estará deshabilitado mientras se carga */
.submit-button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

#mensajeError {
    color: black;
}
</style>
