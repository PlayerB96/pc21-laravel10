document.addEventListener('DOMContentLoaded', function () {
    const chatButton = document.getElementById('chat-button');
    const chatWindow = document.getElementById('chat-window');
    const closeChatButton = document.getElementById('close-chat');
    const sendMessageButton = document.getElementById('send-message');
    const chatInput = document.getElementById('chat-input');
    const chatBody = document.querySelector('.chat-body');

    // Asegurarse de que chatBody existe antes de utilizarlo
    if (!chatBody) {
        console.error("Elemento .chat-body no encontrado en el DOM.");
        return;
    }

    chatButton.addEventListener('click', () => {
        chatWindow.style.display = 'block';
    });

    closeChatButton.addEventListener('click', () => {
        chatWindow.style.display = 'none';
    });

    sendMessageButton.addEventListener('click', sendMessage);

    function sendMessage() {
        console.log("##---")
        const message = chatInput.value.trim();
        if (message === '') return;
        chatBody.innerHTML += `<div class="user-message"><strong>Tú:</strong> ${message}</div>`;
        chatInput.value = ''; // Limpiar campo de texto
        console.log("##---22")

        const url = '/chatbot/messages';
        const csrfMetaTag = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log("##---33")
        if (!csrfMetaTag) {
            console.error("Token CSRF no encontrado en el documento.");
        } else {
            $.ajax({
                type: 'POST',
                url: url,
                data: { 'message': message },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (resp) {
                    console.log("Respuesta recibida.");
                    if (resp === "error") {
                        $('#resultado').html("Verifique datos de usuario y/o contraseña");
                        document.getElementById("resultado").style.display = 'block';
                    } else {
                        chatBody.innerHTML += `<div class="bot-message"><strong>Chatbot:</strong> ${resp.response}</div>`;
                        chatBody.scrollTop = chatBody.scrollHeight; // Hacer scroll hacia abajo

                        window.location.href = redirectUrl;
                    }
                },
                error: function () {
                    console.error('Error en la petición AJAX');
                    chatBody.innerHTML += `<div class="bot-message error">Error al obtener respuesta.</div>`;
                }
            });
        }

    }
});
