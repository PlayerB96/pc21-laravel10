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

                // Ejecutar todos los scripts dentro del contenido cargado
                executeScripts(doc);
            })
            .catch(error => console.error('Error loading content:', error)); // Manejar errores
    }

    // Función para ejecutar todos los scripts encontrados en el contenido cargado
    function executeScripts(doc) {
        const scripts = doc.querySelectorAll('script'); // Obtener todos los scripts en el contenido cargado
        scripts.forEach(script => {
            const newScript = document.createElement('script');
            newScript.textContent = script.textContent; // Copiar el contenido del script
            document.body.appendChild(newScript); // Insertar el script en el body para ejecutarlo
        });
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>