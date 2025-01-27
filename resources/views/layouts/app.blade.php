<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Extranet La Número Uno')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Incluir DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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
<script src="{{ asset('js/main-content.js') }}"></script>

<!-- Script global para inicializar DataTables -->
<script src="{{ asset('js/datatable-init.js') }}"></script>
<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

</html>
