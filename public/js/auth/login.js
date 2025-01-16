
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
    element = document.querySelector('[id^="modal-"]');
    closeModal(element.id);
    modalElementR = document.querySelector('[id^="modalr-"]')
    // Verifica si el modal existe
    if (modalElementR) {
        modalElementR.style.display = 'block';
        modalElementR.style.zIndex = '9999';
        modalElementR.classList.add('show');
        // Si quieres ocultar modal al hacer click fuera 
        window.onclick = function (event) {
            if (event.target === modalElementR) {
                modalElementR.style.display = 'none';  // Oculta el modal cuando se hace clic fuera de él
            }
        };
    }
});

// Abrir el modal de registro y cerrar el modal de login al hacer clic en "Registrarse"
document.getElementById('openLoginModal').addEventListener('click', function () {
    modalElementR = document.querySelector('[id^="modalr-"]');
    closeModal(modalElementR.id);
    element = document.querySelector('[id^="modal-"]')
    // Verifica si el modal existe
    if (element) {
        element.style.display = 'block';
        element.style.zIndex = '9999';
        element.classList.add('show');
        // Si quieres ocultar modal al hacer click fuera 
        window.onclick = function (event) {
            if (event.target === element) {
                element.style.display = 'none';  // Oculta el modal cuando se hace clic fuera de él
            }
        };
    }
});
