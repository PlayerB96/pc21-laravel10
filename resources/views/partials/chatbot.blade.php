<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<!-- Botón flotante para abrir el chat -->
<button id="chat-button" class="chat-button">
    <img style="width:2rem" src="{{ asset('assets/imgs/chatbot.png') }}" alt="Chatbot" />
</button>
<!-- Ventana del chat -->
<div id="chat-window" class="chat-window" style="display:none;">
    <div class="chat-header">
        <span>Chat</span>
        <button id="close-chat" class="close-chat">X</button>
    </div>
    <div class="chat-body">
        <p>¡Hola! ¿En qué puedo ayudarte?</p>
    </div>
    <div class="chat-footer">
        <input type="text" id="chat-input" placeholder="Escribe un mensaje..." />

        <button id="send-message">Enviar</button>
    </div>
</div>
<script src="{{ asset('js/chatbot/chatbot.js') }}"></script>
<style>
    /* Estilos para el botón flotante */
.chat-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 15px;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    z-index: 1000;
}

/* Estilos para la ventana de chat */
.chat-window {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 300px;
    height: 400px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 999;
    display: none;
}

/* Encabezado del chat */
.chat-header {
    background-color: #007bff;
    color: white;
    padding: 10px;
    text-align: center;
    font-weight: bold;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

/* Botón para cerrar el chat */
.close-chat {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    position: absolute;
    top: 5px;
    right: 10px;
}

/* Cuerpo del chat */
.chat-body {
    padding: 15px;
    overflow-y: auto;
    height: 250px;
    font-size: 14px;
    color: #333;
}

/* Pie de la ventana de chat */
.chat-footer {
    padding: 10px;
    display: flex;
    justify-content: space-between;
    color: white;

}

/* Estilo para el campo de texto y botón de enviar */
.chat-footer input {
    width: 70%;
    padding: 5px;
    font-size: 14px;
    color: black;
    border: 1px solid red;
}

.chat-footer button {
    width: 25%;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px;
    cursor: pointer;
}

/* Estilos básicos para el botón flotante */
#chat-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: transparent;
    border: 2px solid #4CAF50;
    cursor: pointer;
    box-shadow: 2px 2px 6px rgba(233, 72, 66, 0.753);
    border-radius: 50%;
    padding: 10px;
    animation: floatAnimation 5s ease-in-out infinite, bubbleAnimation 3s ease-in-out infinite;
}

/* Efecto de sombra y resplandor cuando se pasa el ratón sobre el botón */
#chat-button:hover {
    box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2);
    animation: bubbleAnimation 1s ease-in-out infinite;
    /* Efecto de burbujas al pasar el ratón */
}


/* Animación de flotación suave */
@keyframes floatAnimation {
    0% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-10px);
        /* Subir */
    }

    100% {
        transform: translateY(0);
    }
}

/* Animación de burbujas (efecto de movimiento y escala) */
@keyframes bubbleAnimation {
    0% {
        transform: scale(1);
    }

    25% {
        transform: scale(1.1);
        /* Aumentar tamaño */
    }

    50% {
        transform: scale(1);
        /* Tamaño normal */
    }

    75% {
        transform: scale(1.1);
        /* Aumentar tamaño */
    }

    100% {
        transform: scale(1);
        /* Tamaño normal */
    }
}
</style>