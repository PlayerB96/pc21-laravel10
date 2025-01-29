$(document).ready(function () {
    function initializeDataTable() {
        // Verificar si DataTables está cargado correctamente
        if (!$.fn.DataTable) {
            console.error("Error: DataTables no está disponible. Revisa la carga de los scripts.");
            return;
        }

        // Verificar si la tabla ya está inicializada y destruirla antes de reinicializar
        if ($.fn.DataTable.isDataTable(".data-table")) {
            $(".data-table").DataTable().destroy();
        }

        // Inicializar DataTables
        $(".data-table").DataTable({
            dom: "Bfrtip",
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json",
            },
            order: [[3, "desc"]],
        });
    }

    // Esperar a que DataTables esté disponible antes de inicializar
    setTimeout(() => {
        initializeDataTable();
    }, 500);

    // Si la tabla se actualiza dinámicamente con AJAX
    $("#lista_colaborador").on("change", function () {
        initializeDataTable();
    });
});
