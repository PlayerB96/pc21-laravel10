<div id="{{ $id }}" class="modal-overlay" style="display: none;">
    <div class="modal-content {{ $extraClass }}">
        <div class="modal-header">
            <h2>{{ $title }}</h2>
            <button class="close-button" onclick="closeModal('{{ $id }}')">&times;</button>
        </div>
        <div class="modal-body">
            {{ $slot }}
        </div>
        <div class="modal-footer">
            @if ($actionButton)
                <button class="action-button" data-modal-id="{{ $id }}">{{ $actionButton }}</button>
            @endif
            @if ($secondButton)
                <button class="second-button" data-modal-id="{{ $id }}">{{ $secondButton }}</button>
            @endif
        </div>
    </div>
</div>


<style>
    .modal-body {
        background-color: white;
        max-height: 80vh;
        /* Ajusta este valor para limitar la altura */
        overflow-y: auto;
        /* Habilita el desplazamiento vertical */
        border: 2px solid #e1e1e1;
        border-radius: 12px;
        padding-bottom: 50px;
        /* Añadir un poco de espacio en la parte inferior */
    }

    .modal-footer {
        background-color: white;
        /* Estilo para el pie de página */
        padding: 10px;
        text-align: right;
        /* Cambié text-align de center a right */
        border-top: 1px solid #e1e1e1;
        position: absolute;
        /* Fija el pie de página al fondo */
        bottom: 0;
        width: 100%;
        /* Asegura que el pie de página ocupe todo el ancho */
        box-sizing: border-box;
        /* Asegura que el borde y el padding no afecten el ancho */
        display: flex;
        justify-content: flex-end;
        /* Alinea los botones a la derecha */
        gap: 10px;
        /* Espaciado entre los botones */
    }


    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 3;
        overflow: auto;
    }

    .modal-content {
        padding: 0;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        box-sizing: border-box;
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        overflow: hidden;
        /* Evita desbordamientos */
    }


    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0rem !important;
    }

    .modal-header h2 {
        color: white;
    }

    .close-button {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: white;
    }

    .action-button {
        background-color: #007bff;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
    }

    .second-button {
        background-color: #ccc;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
    }

    .wide-modal {
        max-width: 800px;
    }

    .full-modal {
        max-width: 100%;
    }
</style>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'block';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
</script>
