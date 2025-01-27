$(document).ready(function () {
    $(".data-table").DataTable({
        dom: "Bfrtip", // Agrega botones de exportación
        buttons: [
            "copy",
            "csv",
            "excel",
            "pdf",
            "print", // Botones disponibles
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json", // Idioma en español
        },
        order: [[3, "desc"]], // Ordenar por la columna de fecha (columna 4) de forma descendente
        columnDefs: [
            {
                targets: [0, 1, 2],
                orderable: true,
            }, // Permitir ordenar en estas columnas
            {
                targets: [3, 4, 5, 6],
                orderable: true,
            }, // Permitir ordenar en estas columnas
        ],
    });
});
