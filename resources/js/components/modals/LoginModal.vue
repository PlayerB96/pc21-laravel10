<template>
    <div v-if="isVisible" class="modal-overlay" @click.self="closeModal">
        <div class="modal-content">
            <div class="logo-container">
                <img src="/assets/imgs/Grupo.LN1NegroFTransp.png" alt="Grupo LN1 Logo" class="logo" />
            </div>
            <h2>Iniciar sesión</h2>
            <form @submit.prevent="handleLogin" class="login-form">
                <input type="email" v-model="email" placeholder="Correo electrónico" required class="input-field" />
                <input type="password" v-model="password" placeholder="Contraseña" required class="input-field" />
                <button type="submit" class="submit-button">Iniciar sesión</button>
            </form>
            <button @click="closeModal" class="close-button">Cerrar</button>
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
            email: '',
            password: ''
        };
    },
    methods: {
        closeModal() {
            this.$emit('update:isVisible', false); // Emitir evento para cerrar el modal
        },
        handleLogin() {
            // Aquí iría la lógica de autenticación
            console.log('Iniciar sesión con', this.email, this.password);
            this.closeModal();
        }
    }
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-content {
    background: #fff;
    padding: 30px 20px;
    border-radius: 10px;
    width: 350px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
</style>
