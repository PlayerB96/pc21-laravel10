
document.querySelector('[id^="modal-"]').addEventListener('submit', function (event) {
    element = document.querySelector('[id^="modal-"]');
    event.preventDefault(); // Evita el envío del formulario
    // Obtén los valores de los inputs
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    localStorage.setItem('user', username);
    location.reload();
    closeModal(element.id);
});

// Abrir el modal de registro y cerrar el modal de login al hacer clic en "Registrarse"
document.getElementById('openRegisterModal').addEventListener('click', function () {
    // Número de WhatsApp al que quieres redirigir (incluye el código de país sin el signo "+")
    const phoneNumber = '+51926151507';  // Reemplaza con tu número de WhatsApp
    const message = 'Hola, quiero más información.'; // Mensaje opcional
    // Codificar el mensaje para la URL de WhatsApp
    const encodedMessage = encodeURIComponent(message);
    // URL de WhatsApp
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    // Redirigir a WhatsApp
    window.open(whatsappUrl, '_blank');


});

