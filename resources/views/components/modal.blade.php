<div id="{{ $id }}" class="modal-overlay" style="display: none;">
    <div class="modal-content {{ $extraClass }}">
        <div class="modal-header">
            <h2>{{ $title }}</h2>
            <button class="close-button" onclick="closeModal('{{ $id }}')">&times;</button>
        </div>
        <div class="modal-body">
            {{ $slot }}
        </div>
    </div>
</div>

<style>
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
        z-index: 9999;
        overflow: auto;
    }

    .modal-content {
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        /* Valor predeterminado */
        box-sizing: border-box;
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* Centrado por flexbox */
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
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