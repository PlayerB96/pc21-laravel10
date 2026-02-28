<template>
    <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content-login">
            <div class="logo-container">
                <img src="/assets/imgs/pc21v1.png" alt="Grupo LN1 Logo" class="logo" />
            </div>
            <h2>{{ isRegister ? 'Registrar Usuario' : 'Iniciar sesión' }}</h2>
            <form @submit.prevent="handleSubmit" class="login-form">
                <input type="text" v-model="username" placeholder="Ingrese su usuario" required class="input-field"
                    autocomplete="off" />

                <input type="number" v-if="isRegister" v-model="telefono" placeholder="Numero de Telefono" required
                    class="input-field" autocomplete="off" />

                <input type="email" v-if="isRegister" v-model="email" placeholder="Ingrese su Email" required
                    class="input-field" autocomplete="off" />


                <input type="text" v-if="isRegister" v-model="nombreCompleto" placeholder="Nombre Completo" required
                    class="input-field" autocomplete="off" />

                <input :type="showPassword ? 'text' : 'password'" v-model="password" placeholder="Contraseña" required
                    class="input-field password-input" autocomplete="off" />

                <button type="submit" class="submit-button" :disabled="loading">
                    <span v-if="loading" class="spinner"></span>
                    <span v-else>{{ isRegister ? 'Registrar' : 'Iniciar sesión' }}</span>
                </button>

            </form>

            <p id="mensajeError" class="error-message"></p>

            <p class="toggle-mode text-black" @click="toggleMode">
                {{ isRegister ? '¿Ya tienes cuenta? Inicia sesión' : '¿No tienes cuenta? Regístrate' }}
            </p>

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
            username: '',
            email: '',
            password: '',
            nombreCompleto: '',
            telefono: '',
            isRegister: false,
            showPassword: false,
            loading: false
        };
    },
    methods: {
        closeModal() {
            this.$emit('update:isVisible', false);
        },
        toggleMode() {
            this.isRegister = !this.isRegister;
            this.clearFields();
        },
        clearFields() {
            this.username = '';
            this.email = '';
            this.password = '';
            this.nombreCompleto = '';
            this.telefono = '';

        },
        async handleSubmit() {
            if (!this.username || !String(this.username).trim()) {
                alert('Por favor, ingrese un usuario válido.');
                return;
            }
            this.loading = true;
            try {
                let response;
                if (this.isRegister) {
                    response = await axios.post('/auth/register', {
                        username: this.username,
                        email: this.email,
                        telefono: this.telefono,
                        password: this.password,
                        nombre_completo: this.nombreCompleto
                    });

                    // 🔥 Enviar mensaje por WhatsApp después del registro
                    await this.enviarMensajeWhatsApp();
                } else {
                    response = await axios.post('/auth/validate_user', {
                        username: this.username,
                        password: this.password
                    });
                }

                Swal.fire({
                    icon: 'success',
                    title: this.isRegister ? 'Registro exitoso' : `¡Bienvenido, ${response.data.sessionData?.nombre_completo || 'Usuario'}!`,
                    text: response.data.message,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    if (!this.isRegister) {
                        localStorage.setItem('userSession', JSON.stringify(response.data.sessionData));
                        localStorage.setItem('authToken', response.data.token);
                        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
                        this.$router.push('/inicio');
                        window.dispatchEvent(new Event("storage"));
                    }
                });

                this.closeModal();
            } catch (error) {
                let errorMessage = 'Ocurrió un error desconocido.';
                console.log(error.response?.data?.error);
                console.log(error.response?.data?.message);

                errorMessage = error.response?.data?.message || error.response?.data?.error || errorMessage;

                document.getElementById('mensajeError').innerText = errorMessage;
            } finally {
                this.loading = false;
            }
        },

        // ✅ Función para enviar mensaje de WhatsApp al endpoint
        async enviarMensajeWhatsApp() {
            try {
                // Obtener la geolocalización del usuario
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(async (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        console.log(this.telefono)
                        console.log("####1")

                        // Generar enlace de Google Maps con la ubicación
                        const mapsLink = `https://www.google.com/maps?q=${latitude},${longitude}`;

                        // Definir los números de teléfono
                        const numeroFijo = `+51986514012`; // Número fijo
                        const numeroCliente = `+51${this.telefono}`; // Número del cliente con código de país

                        // Mensajes a enviar
                        const mensajeUbicacion = `📍 Aquí está mi ubicación: ${mapsLink}`;
                        const mensajeTicket = `✅ Su ticket está en proceso. Nos pondremos en contacto pronto.`;

                        // Enviar mensaje con la ubicación al número fijo
                        await axios.post('http://localhost:3001/lead', {
                            phone: numeroFijo,
                            message: mensajeUbicacion
                        });
                        console.log("📩 Ubicación enviada correctamente a:", numeroFijo);

                        // Enviar mensaje de ticket en proceso al cliente
                        await axios.post('http://localhost:3001/lead', {
                            phone: numeroCliente,
                            message: mensajeTicket
                        });
                        console.log("📩 Mensaje de ticket enviado correctamente a:", numeroCliente);

                    }, (error) => {
                        console.error("❌ Error obteniendo la ubicación:", error.message);
                    });
                } else {
                    console.error("❌ Geolocalización no soportada en este navegador.");
                }
            } catch (error) {
                console.error("❌ Error enviando los mensajes:", error.response?.data || error.message);
            }
        }


    }
};
</script>



<style scoped>
.toggle-mode {
    cursor: pointer;
    color: #0056b3;
}

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
    display: flex;
    justify-content: center;
    /* Centra horizontalmente */
    align-items: center;

}

.logo {
    width: 160px;
    /* Ajusta el tamaño según necesidad */
    height: auto;
    /* Mantiene la proporción */
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
