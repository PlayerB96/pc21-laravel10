
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

