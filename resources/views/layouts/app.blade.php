<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Extranet La Número Uno')</title>

    <!-- CSS -->
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Agregar CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">
    <!-- Agregar CSS de DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">
</head>

<body>
    <header>
        @include('partials.navbar.navbar')
    </header>

    <!-- Main Content -->
    <main id="main-content" style="min-height: 500px;">
        @yield('content')
    </main>

    <footer>
        @include('partials.footer')
    </footer>

    @include('partials.chatbot')

    <!-- Cargar jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Cargar DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>

    <!-- Cargar archivos adicionales de DataTables (JSZip, pdfMake, etc.) -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>

    <!-- Scripts locales -->
    <script src="{{ asset('js/main-content.js') }}"></script>
    {{-- <script src="{{ asset('js/gestionpersonas/registro_papeletras.js') }}"></script> --}}

    <!-- Inicializar DataTable -->

    {{-- <script src="{{ asset('js/datatable-init.js') }}"></script> --}}

</body>

</html>
