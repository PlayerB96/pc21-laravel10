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
                    <template v-else>
                        {{ msg.text }}
                    </template>
                </div>
            </div>

            <div class="chat-input">
                <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Escribe un mensaje...">
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
            messages: [],
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
        },
        toggleExpand() {
            this.expanded = !this.expanded;
        },
        async sendMessage() {
            if (this.newMessage.trim() === "") return;

            const userMessage = { text: this.newMessage, user: true, type: "text" };
            this.messages.push(userMessage);
            this.$nextTick(() => this.scrollToBottom());
            const messageToSend = this.newMessage;
            this.newMessage = "";
            this.loading = true;

            const loadingMessage = { text: "......", user: false, type: "text" };
            this.messages.push(loadingMessage);
            this.$nextTick(() => this.scrollToBottom());

            try {
                const response = await axios.post('/chat_response', { message: messageToSend });
                console.log(response.data);

                this.messages.pop(); // Quitar mensaje de carga

                if (response.data.content) {
                    // 📌 Si hay PDF, mostrarlo
                    this.messages.push({ text: response.data.message, content: response.data.content, user: false, type: "pdf" });
                } else {
                    // 📌 Si es solo texto, mostrar mensaje normal
                    this.messages.push({ text: response.data.message, user: false, type: "text" });
                }

            } catch (error) {
                this.messages.pop();
                this.messages.push({ text: "Error al obtener respuesta del servidor.", user: false, type: "text" });
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