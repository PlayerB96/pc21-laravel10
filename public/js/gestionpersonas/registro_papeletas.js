
$(document).ready(function () {

    // Inicia el DataTable
    var table = $(".data-table").DataTable({
        dom: "Bfrtip",
        buttons: ["copy", "csv", "excel", "pdf", "print"],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json",
        },
        order: [
            [3, "desc"]
        ],
    });

    // Evento para cambiar el estado de la solicitud
    $('#estado_solicitud').on('change', function () {
        Busca_Registro_Papeleta(table);
    });

    const registerButton = document.getElementById("idRegister");

    if (registerButton) {
        registerButton.addEventListener("click", function () {
            const modalElement = document.getElementById("modalInsertPS");

            // Verifica si el modal existe
            if (modalElement) {
                console.log("Modal encontrado:", modalElement);
                openModal(modalElement.id);
            } else {
                alert("El modal no se encontró");
            }
        });
    }
});

function Busca_Registro_Papeleta(table) {
    var estado_solicitud = $('#estado_solicitud').val();
    const url = "/gestionpersonas/buscar_papeletas";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            'estado_solicitud': estado_solicitud
        },
        success: function (data) {
            // Vaciar la tabla existente
            var tableBody = $('#lista_colaborador tbody');
            tableBody.empty();

            // Crear nuevas filas y agregarlas a la tabla
            data.list_papeletas_salida.forEach(function (list) {
                var row = generateTableRow(list);
                tableBody.append(row);
            });

            // Vuelve a cargar el DataTable para actualizarlo con los nuevos datos
            table.clear();
            table.rows.add($(tableBody).find('tr')); // Agrega las nuevas filas
            table.draw(); // Redibuja el DataTable
        }
    });
}

function generateTableRow(list) {
    const motivo = list.id_motivo === 1 ? 'Laboral' : (list.id_motivo === 2 ? 'Personal' : list.motivo);
    const estadoSolicitud = {
        1: '<span class="badge badge-warning">En proceso</span>',
        2: '<span class="badge badge-primary">Aprobado</span>',
        3: '<span class="badge badge-danger">Denegado</span>',
        4: '<span class="badge badge-warning">En proceso - Aprobación Gerencia</span>',
        5: '<span class="badge badge-warning">En proceso - Aprobación RRHH</span>',
    }[list.estado_solicitud] || '<span class="badge badge-primary">Error</span>';

    const horaSalida = list.sin_ingreso === 1 ? 'Sin Ingreso' : list.hora_salida;
    const horaRetorno = list.sin_retorno === 1 ? 'Sin Retorno' : list.hora_retorno;

    const deleteButton = list.estado_solicitud === 1 ? `
<td class="text-center">
    <a href="#" class="btn-action" title="Eliminar" onclick="Delete_Papeletas_Salida('${list.id_solicitudes_user}')">
        <!-- SVG Icon -->
    </a>
</td>` : '';

    return `
<tr>
    <td>${motivo}</td>
    <td>${list.destino.nom_destino}</td> <!-- Nombre del destino -->
    <td>${list.tramite.nom_tramite}</td> <!-- Nombre del trámite -->
    <td align="center">${new Date(list.fec_solicitud).toLocaleDateString()}</td>
    <td align="center">${horaSalida}</td>
    <td align="center">${horaRetorno}</td>
    <td align="center">${estadoSolicitud}</td>
    ${deleteButton}
</tr>`;
}


