document.addEventListener("DOMContentLoaded", function () {
    $('input[name="id_motivo"]').on('change', function () {
        var id_motivo = $('input[name="id_motivo"]:checked').val();
        if (id_motivo) {
            console.log('Radio seleccionado con valor:',
                id_motivo); // Verifica que el valor sea correcto
            Cambiar_Motivo(id_motivo);
        } else {
            console.log('No se ha seleccionado un radio');
        }
    });

    function Cambiar_Motivo(id_motivo) {
        const url = "/gestionpersonas/cambiar_motivo";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'id_motivo': id_motivo
            },
            success: function (data) {
                console.log('Respuesta AJAX:', data); // Verifica la respuesta
                $('#destino').html(data);
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });
    }


    $('#destino').on('change', function () {
        Traer_Tramite();
    });
    function Traer_Tramite() {
        var id_destino = $('#destino').val();
        const url = "/gestionpersonas/traer_tramite";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        console.log("###222")
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: { 'id_destino': id_destino },
            success: function (data) {
                $('#tramite').html(data);
            }
        });
    }

    document.querySelectorAll(".action-button").forEach(function (button) {
        button.addEventListener("click", function () {
            const modalId = this.getAttribute("data-modal-id");
            handlePapeletaInsertion(modalId);
        });
    });

    function showAlert(message, icon = 'warning') {
        Swal.fire({
            title: '¡Ups!',
            text: message,
            icon: icon,
            confirmButtonText: 'OK',
        });
    }
    
    function handlePapeletaInsertion(modalId) {
        const dataString = $("#formulario_papeletas_salida_registro").serialize();
        const url = "/gestionpersonas/store";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    
        const validations = [
            { condition: !$('[name=id_motivo]:checked').val(), message: 'Debe seleccionar motivo.' },
            { condition: $('[name=id_motivo]:checked').val() == 3 && $("#otros").val() === '', message: 'Debe especificar sus razones en otros' },
            { condition: $('#parametro').val() == 1 && ($('#colaborador_p').val() == '0' || $('#colaborador_p').val() == ''), message: 'Debe seleccionar al colaborador.' },
            { condition: !$('#sin_ingreso').is(":checked") && $('#hora_salida').val() === '', message: 'Debe ingresar hora de salida.' },
            { condition: !$('#sin_retorno').is(":checked") && $('#hora_retorno').val() === '', message: 'Debe ingresar hora de retorno.' },
            { condition: !$('#sin_ingreso').is(":checked") && !$('#sin_retorno').is(":checked") && $('#hora_retorno').val() <= $('#hora_salida').val(), message: 'Hora de retorno debe ser mayor a hora de salida' },
            { condition: $('#fecha_actual').val() === $('#fec_solicitud').val() && $('#sin_ingreso').is(":checked"), message: 'No puede seleccionar sin ingreso para el día de hoy' }
        ];
        // Validar todos los campos en un solo paso
        for (let validation of validations) {
            if (validation.condition) {
                showAlert(validation.message);
                return;
            }
        }
        // Realizar la inserción si todo es válido
        $.ajax({
            type: "POST",
            url: url,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: dataString,
            success: function (data) {
                if (data == "error") {
                    showAlert("¡Ya no puedes hacer más papeletas para ese trámite!", 'error');
                } else {
                    Swal.fire('Registro Exitoso!', 'Haga clic en el botón!', 'success').then(function () {
                        Busca_Registro_Papeleta();
                        closeModal(modalId);
                    });
                }
            },
            error: function (xhr) {
                const firstError = Object.values(xhr.responseJSON.errors)[0][0];
                showAlert(firstError);
            }
        });
    }
    

});
