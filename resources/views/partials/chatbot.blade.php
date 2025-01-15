<head>
    <link rel="stylesheet" href="{{ asset('css/chatbot/chatbot.css') }}">
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
        <input type="text" placeholder="Escribe un mensaje..." />
        <button>Enviar</button>
    </div>
</div>
<script src="{{ asset('js/chatbot/chatbot.js') }}"></script>