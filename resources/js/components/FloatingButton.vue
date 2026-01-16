<template>
    <div>
        <button class="floating-button animated-button" @click="toggleChat">
            <i class="bi" :class="chatOpen ? 'bi-x' : 'bi-chat-dots'"></i>
        </button>

        <div v-if="chatOpen" class="chat-container" :style="chatStyle">
            <div class="chat-header">
                <span>Chatbot</span>
                <div>
                    <button class="mx-3" @click="toggleExpand">{{ expanded ? '➖' : '⛶' }}</button>
                    <button @click="toggleChat">&times;</button>
                </div>

            </div>

            <div ref="chatMessages" class="chat-messages">
                <div v-for="(msg, index) in messages" :key="index"
                    :class="{ 'user-message': msg.user, 'bot-message': !msg.user }">
                    <template v-if="msg.type === 'pdf'">
                        <p>{{ msg.text }}</p>
                        <iframe :src="msg.content" width="100%" height="300px"></iframe>
                    </template>
                    <template v-else-if="msg.type === 'link'">
                        <a :href="msg.link" target="_blank" style="color: blue; text-decoration: underline;">{{ msg.text }}</a>
                    </template>
                    <template v-else>
                        {{ msg.text }}
                    </template>
                </div>
            </div>

            <div class="chat-input">
                <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Envia tu consulta...">
                <button @click="sendMessage">Enviar</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "FloatingButton",
    data() {
        return {
            chatOpen: false,
            newMessage: "",
            messages: [{
                text: "¡Hola! 👋 Bienvenido a nuestro servicio de atención al cliente. Por favor, envía tu solicitud o consulta y te ayudaremos pronto.",
                user: false,
                type: "text"
            }],
            loading: false,
            expanded: false,
        };
    },
    computed: {
        chatStyle() {
            return {
                width: this.expanded ? '600px' : '350px',
                height: this.expanded ? '500px' : '300px',
            };
        }
    },
    methods: {
        toggleChat() {
            this.chatOpen = !this.chatOpen;
            // Resetear el estado cuando se cierra el chat
            if (!this.chatOpen) {
                this.resetChatState();
            }
        },
        resetChatState() {
            this.messages = [{
                text: "¡Hola! 👋 Bienvenido a nuestro servicio de atención al cliente. Por favor, envía tu solicitud o consulta y te ayudaremos pronto.",
                user: false,
                type: "text"
            }];
        },
        toggleExpand() {
            this.expanded = !this.expanded;
        },
        async sendMessage() {
            if (this.newMessage.trim() === "") return;

            const userMessage = { text: this.newMessage, user: true, type: "text" };
            this.messages.push(userMessage);
            this.$nextTick(() => this.scrollToBottom());
            const messageText = this.newMessage.trim();
            this.newMessage = "";
            this.loading = true;

            // Procesar solicitud directamente
            const loadingMessage = { text: "Procesando tu solicitud...", user: false, type: "text" };
            this.messages.push(loadingMessage);
            this.$nextTick(() => this.scrollToBottom());

            await this.enviarSolicitud(messageText);
        },
        
        async enviarSolicitud(solicitud) {

            try {
                // 👇 obtenemos el nombre del usuario desde localStorage
                let userSession = {};
                try {
                    const sessionData = localStorage.getItem("userSession");
                    if (sessionData) {
                        userSession = JSON.parse(sessionData) || {};
                    }
                } catch (e) {
                    console.warn('Error al parsear userSession:', e);
                    localStorage.removeItem('userSession');
                }
                const nombreCompleto = userSession.nombre_completo || "Usuario no Registrado";

                // Validar solo el teléfono
                const response = await axios.post('/chat_response', {
                    telefono: telefono,
                    nombre_completo: nombreCompleto,
                    step: 'validar_telefono'
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                this.messages.pop(); // Quitar mensaje de carga

                if (response.data.success) {
                    // Teléfono válido, guardarlo y pedir la solicitud
                    this.telefonoUsuario = telefono;
                    this.step = 'solicitud';
                    this.messages.push({ 
                        text: `¡Perfecto! ✅ Tu número ha sido validado correctamente. Ahora, ¿en qué puedo ayudarte? Por favor, describe tu solicitud o consulta.`, 
                        user: false, 
                        type: "text"
                    });
                } else {
                    this.messages.push({ 
                        text: response.data.message || 'Error al validar el número de teléfono.', 
                        user: false, 
                        type: "text"
                    });
                }

            } catch (error) {
                this.messages.pop(); // Quitar mensaje de carga

                // Mostrar detalle completo del error en consola
                console.error('Error en la solicitud:', error); 
                console.error('Error completo:', {
                    message: error.message,
                    response: error.response,
                    request: error.request,
                    config: error.config
                });

                // Si el error tiene respuesta, mostramos el mensaje del servidor
                if (error.response) {
                    // Verificar si la respuesta es JSON válido
                    if (error.response.data && typeof error.response.data === 'object') {
                        const errorMessage = error.response.data.message || error.response.data.error || "Error al validar el número de teléfono.";
                        this.messages.push({ text: errorMessage, user: false, type: "text" });
                        console.error('Detalles del error HTTP:', error.response.status, error.response.data);
                    } else {
                        // Si la respuesta no es JSON, mostrar mensaje genérico
                        console.error('La respuesta no es JSON válido:', error.response.data);
                        this.messages.push({ 
                            text: `Error del servidor (${error.response.status}). Por favor, intenta de nuevo.`, 
                            user: false, 
                            type: "text" 
                        });
                    }
                } else if (error.request) {
                    // Si no hay respuesta pero se hizo la solicitud
                    console.error('Solicitud realizada sin respuesta:', error.request);
                    this.messages.push({ text: "Error de conexión. Por favor, intenta de nuevo.", user: false, type: "text" });
                } else {
                    // Error al configurar la solicitud
                    console.error('Error general:', error.message);
                    if (error.message && error.message.includes('JSON')) {
                        this.messages.push({ text: "Error al procesar la respuesta del servidor. Por favor, intenta de nuevo.", user: false, type: "text" });
                    } else {
                        this.messages.push({ text: "Error al obtener respuesta del servidor.", user: false, type: "text" });
                    }
                }
            } finally {
                this.loading = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },
        
        async enviarSolicitud(solicitud) {
            try {
                // 👇 obtenemos el nombre del usuario desde localStorage
                let userSession = {};
                try {
                    const sessionData = localStorage.getItem("userSession");
                    if (sessionData) {
                        userSession = JSON.parse(sessionData) || {};
                    }
                } catch (e) {
                    console.warn('Error al parsear userSession:', e);
                    localStorage.removeItem('userSession');
                }
                const nombreCompleto = userSession.nombre_completo || "Usuario no Registrado";

                // Enviar solicitud directamente
                const response = await axios.post('/chat_response', {
                    solicitud: solicitud,
                    nombre_completo: nombreCompleto
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                this.messages.pop(); // Quitar mensaje de carga

                if (response.data.success) {
                    // Solicitud enviada exitosamente - abrir WhatsApp
                    this.messages.push({ 
                        text: response.data.message || '¡Tu solicitud ha sido recibida exitosamente! 🎉 Se abrirá WhatsApp para enviar los detalles.', 
                        user: false, 
                        type: "text"
                    });
                    
                    // Abrir WhatsApp con el mensaje preformateado
                    if (response.data.whatsapp_url) {
                        setTimeout(() => {
                            window.open(response.data.whatsapp_url, '_blank');
                        }, 1000);
                    }
                    
                    // Resetear para una nueva conversación después de un momento
                    setTimeout(() => {
                        this.resetChatState();
                    }, 4000);
                } else {
                    this.messages.push({ 
                        text: response.data.message || 'Error al enviar tu solicitud.', 
                        user: false, 
                        type: "text"
                    });
                }

            } catch (error) {
                this.messages.pop(); // Quitar mensaje de carga

                console.error('Error en la solicitud:', error); 
                console.error('Error completo:', {
                    message: error.message,
                    response: error.response,
                    request: error.request
                });

                if (error.response && error.response.data && typeof error.response.data === 'object') {
                    const errorMessage = error.response.data.message || error.response.data.error || "Error al enviar la solicitud.";
                    this.messages.push({ text: errorMessage, user: false, type: "text" });
                } else if (error.request) {
                    this.messages.push({ text: "Error de conexión. Por favor, intenta de nuevo.", user: false, type: "text" });
                } else {
                    this.messages.push({ text: "Error al enviar la solicitud.", user: false, type: "text" });
                }
            } finally {
                this.loading = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        scrollToBottom() {
            const chatMessages = this.$refs.chatMessages;
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }
    }
};
</script>

<style scoped>
.floating-button {
    z-index: 999999;
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background-color: var(--light-primary-bg);
    color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s;
}

.chat-header[data-v-4993be03] button {
    background-color: transparent !important;
}

.floating-button:hover {
    background-color: var(--light-primary-bg);
    transform: scale(1.1);
}

.animated-button {
    animation: floating 3s ease-in-out infinite, glow 1.5s infinite alternate;
}

@keyframes floating {
    0% {
        transform: translateY(0px);
    }

    50% {
        transform: translateY(-10px);
    }

    100% {
        transform: translateY(0px);
    }
}

@keyframes glow {
    0% {
        box-shadow: 0 0 5px var(--menu-active);
    }

    100% {
        box-shadow: 0 0 10px var(--menu-active), 0 0 10px var(--menu-active), 0 0 20px var(--menu-active);
    }
}

.chat-container {
    z-index: 99999;
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 350px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.chat-header {
    background: var(--light-primary-bg);
    color: white;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: end;
}

.chat-messages {
    height: 100%;
    overflow-y: auto;
    padding: 10px;
    display: flex;
    flex-direction: column;
}

.user-message {
    align-self: flex-end;
    background: var(--light-secondary-hover);
    color: white;
    padding: 8px;
    border-radius: 10px;
    margin: 5px 0;
}

.bot-message {
    align-self: flex-start;
    background: #f1f1f1;
    padding: 8px;
    border-radius: 10px;
    margin: 5px 0;
    color: black
}

.chat-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ddd;
}

.chat-input input {
    flex: 1;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: white;
    color: black;
}

.chat-input button {
    background: var(--light-secondary-hover);
    color: white;
    border: none;
    padding: 5px 10px;
    margin-left: 5px;
    cursor: pointer;
    border-radius: 5px;
}
</style>