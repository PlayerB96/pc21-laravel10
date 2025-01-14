<!-- resources/views/layouts/app.blade.php -->
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
    @include('partials.navbar')

    <!-- Main Content: Aquí se cargará el contenido dinámico -->
    <main id="main-content">
        @yield('content') <!-- Aquí se inyectará el contenido de cada página -->
    </main>
    <!-- Incluir el footer -->
    @include('partials.footer')


    <script>
        // Función para cargar contenido sin recargar la página
        document.querySelectorAll('a[data-route]').forEach(anchor => {
            anchor.addEventListener('click', function(event) {
                event.preventDefault(); // Evitar el comportamiento por defecto del enlace
                const url = this.getAttribute('data-route');
                // Cargar el contenido dinámicamente usando fetch
                fetch(url)
                    .then(response => response.text())
                    .then(data => {
                        // Aquí usamos un contenedor temporal para extraer solo el contenido del main
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data, 'text/html');
                        const content = doc.querySelector('#main-content').innerHTML;
                        // Reemplazar solo el contenido del main (sin navbar ni footer)
                        document.getElementById('main-content').innerHTML = content;
                        // Actualizar la barra de direcciones sin recargar la página
                        history.pushState(null, '', url);
                    })
                    .catch(error => console.error('Error loading content:', error));
            });
        });
    </script>

</body>

</html>