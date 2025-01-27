document.addEventListener("DOMContentLoaded", function () {
    const modalForm = document.querySelector('[id^="modal-"]');

    if (modalForm) {
        modalForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Evita el envío del formulario
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            // Obtener el token CSRF desde el meta tag
            var csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            $.ajax({
                type: "POST",
                url: "auth/validate_user",
                data: {
                    username: username,
                    password: password,
                },
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    closeModal(modalForm.id);
                    Swal.fire({
                        icon: "success",
                        title: `¡Bienvenido, ${response.nombre_completo}!`,
                        text: response.message,
                        imageUrl: response.foto, // URL de la imagen del usuario
                        imageWidth: 100, // Ancho de la imagen
                        imageHeight: 100, // Alto de la imagen
                        imageAlt: "Foto de perfil",
                        confirmButtonText: "Aceptar",
                    }).then(() => {
                        // Recarga la página después de que se cierre el modal
                        window.location.reload();
                    });
                },

                error: function (xhr, status, error) {
                    console.log("Respuesta completa:", xhr.responseText);
                    document.getElementById("mensajeError").innerText =
                        xhr.responseJSON
                            ? xhr.responseJSON.error
                            : "Ocurrió un error desconocido.";
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    document.getElementById("mensajeError").innerText =
                        firstError;
                },
            });
        });
    }
});

// Abrir el modal de registro y cerrar el modal de login al hacer clic en "Registrarse"
document
    .getElementById("redirectWhasstp")
    .addEventListener("click", function () {
        const phoneNumber = "+51967778561";
        const message = "Hola, quiero más información.";
        // Codificar el mensaje para la URL de WhatsApp
        const encodedMessage = encodeURIComponent(message);
        // URL de WhatsApp
        const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
        // Redirigir a WhatsApp
        window.open(whatsappUrl, "_blank");
    });
