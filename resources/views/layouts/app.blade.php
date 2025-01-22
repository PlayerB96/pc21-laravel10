<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Extranet La Número Uno')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

    <!-- Navbar (siempre visible) -->
    @include('partials.navbar.navbar')

    <!-- Main Content: Aquí se cargará el contenido dinámico -->
    <main id="main-content" style="min-height: 500px;">
        @yield('content')
    </main>
    <!-- Contenedor del footer -->
    @include('partials.footer')
    @include('partials.chatbot')

</body>

<script>
    const mainContent = document.getElementById('main-content');
    // Manejar clics en enlaces
    document.querySelectorAll('a[data-route]').forEach(anchor => {
        anchor.addEventListener('click', function(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del enlace
            const url = this.getAttribute('data-route'); // Obtener la URL del atributo data-route
            loadContent(url);
        });
    });
    // Manejar clics en botones
    document.querySelectorAll('button[data-route]').forEach(button => {
        button.addEventListener('click', function(event) {
            const url = this.getAttribute('data-route'); // Obtener la URL del atributo data-route
            loadContent(url);
        });
    });

    // Función para cargar contenido
    function loadContent(url) {
        fetch(url) // Realizar una solicitud fetch para obtener el contenido
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                const content = doc.querySelector('#main-content').innerHTML; // Extraer el contenido
                mainContent.innerHTML = content; // Reemplazar el contenido del contenedor
                const newTitle = doc.querySelector('title').innerText;
                document.title = newTitle; // Cambiar el título de la página
                history.pushState(null, '', url); // Actualizar la URL en el historial
                // Llamar a la función para inicializar JavaScript específico del contenido cargado
                initSurveyJS();
            })
            .catch(error => console.error('Error loading content:', error)); // Manejar errores
    }

    // Función para inicializar JavaScript de la encuesta
    function initSurveyJS() {
        const preguntaGrupos = document.querySelectorAll('.form-group-encuesta');
        preguntaGrupos.forEach((grupo) => {
            const checkboxes = grupo.querySelectorAll('.respuesta-checkbox');
            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', function() {
                    let seleccionados = grupo.querySelectorAll('.respuesta-checkbox:checked').length;
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
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>