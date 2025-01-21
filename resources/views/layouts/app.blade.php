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
    // Lazy loading para el footer
    const mainContent = document.getElementById('main-content');


    document.querySelectorAll('a[data-route]').forEach(anchor => {
        anchor.addEventListener('click', function(event) {
            event.preventDefault();
            const url = this.getAttribute('data-route');
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const content = doc.querySelector('#main-content').innerHTML;
                    mainContent.innerHTML = content;
                    // Obtener y actualizar el título de la página
                    const newTitle = doc.querySelector('title').innerText;
                    document.title = newTitle;
                    history.pushState(null, '', url);
                })
                .catch(error => console.error('Error loading content:', error));
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</html>