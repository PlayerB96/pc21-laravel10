<style>
    /* Estilos predeterminados para los botones */
    .btn {
        padding: 0.8rem 1.6rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        display: inline-flex;
        /* Alinea el contenido en fila */
        align-items: center;
        /* Centra verticalmente el texto e icono */
    }

    /* Estilo cuando el botón tiene el enfoque */
    .btn:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        /* Focus azul */
    }

    /* Estilo cuando el botón está en hover */
    .btn:hover {
        background-color: var(--light-accent);
        /* Azul más oscuro para el hover */
    }

    .btn-icon {
        margin-right: 0.5rem;
        display: inline-block;
        width: 24px;
        height: 24px;
    }


    .btn-text {
        display: inline-block;
    }
</style>

<button
    id="{{ $id }}"
    class="btn {{ $class ?? '' }}"
    style="{{ $style }}"
    data-action="{{ $action }}"
    data-route="{{ $route }}"
    onclick="handleButtonClick(this)">
    @if (isset($icon))
    <!-- Se puede obtener los svg desde : https://heroicons.com/ -->
    <span class="btn-icon" style="width: 24px; height: 24px; display: inline-block;">{!! $icon !!}</span>
    @endif
    {{ $text }}
</button>

<script>
    // Esta función se ejecutará para todos los botones
    function handleButtonClick(button) {
        // Obtener el nombre de la función desde el atributo data-action
        const action = button.getAttribute('data-action');
        // Ejecutar la función asociada al botón (si existe)
        if (action && typeof window[action] === 'function') {
            window[action](); // Ejecuta la función asociada
        }
        // Redirigir a la ruta especificada 
        if (button.dataset.route) {
            window.location.href = button.dataset.route; // Redirigir al link configurado
        }
    }
</script>