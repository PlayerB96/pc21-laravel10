
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
    openModal(modalElementR.id)

});

// Abrir el modal de registro y cerrar el modal de login al hacer clic en "Registrarse"
document.getElementById('openLoginModal').addEventListener('click', function () {
    modalElementR = document.querySelector('[id^="modalr-"]');
    closeModal(modalElementR.id);
    element = document.querySelector('[id^="modal-"]')
    openModal(element.id)

});
