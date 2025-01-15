<style>
    .modal {
        position: fixed;
        top: 110;
        left: 0;
        width: 60%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Fondo oscuro */
        display: none;
        justify-content: center;
        align-items: center;
    }

    .modal-dialog {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
    }
</style>
<!-- resources/views/components/modal.blade.php -->
<div id="{{ $id }}" class="modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">{{ $actionButton }}</button>
            </div>
        </div>
    </div>
</div>