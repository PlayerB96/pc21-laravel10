<style>
    /* Estilos predeterminados para los botones */
    .btn {
        padding: 0.8rem 1.6rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        display: inline-flex;
        justify-content: center;
        /* Centrar contenido horizontalmente */
        align-items: center !important;
        /* Centrar contenido verticalmente */
        text-align: center;
        /* Asegurar que el texto esté centrado */
        width: 100%;
        /* Opcional, si deseas que el botón ocupe todo el ancho disponible */
    }

    .btn-text {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        /* Asegurar que el texto se ajuste correctamente */
        text-align: center;
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
        opacity: 80%;
        transform: translateY(-2px);
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