document.addEventListener('DOMContentLoaded', function () {
    // Selecciona todos los grupos de preguntas
    const preguntaGrupos = document.querySelectorAll('.form-group-encuesta');
    preguntaGrupos.forEach((grupo) => {
        // Obtiene todos los checkboxes dentro del grupo
        const checkboxes = grupo.querySelectorAll('.respuesta-checkbox');
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function () {
                // Filtra los checkboxes seleccionados en el grupo actual
                let seleccionados = grupo.querySelectorAll('.respuesta-checkbox:checked').length;
                // Si se seleccionan más de 3, mostrar alerta con SweetAlert2
                if (seleccionados > 3) {
                    this.checked = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Límite alcanzado',
                        text: 'Solo puedes seleccionar un máximo de 3 respuestas por pregunta.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Entendido'
                    });
                }
            });
        });
    });

});
