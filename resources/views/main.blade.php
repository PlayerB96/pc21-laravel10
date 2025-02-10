<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel with Vue</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">
</head>

<body>
    <div id="app">
        <!-- Aquí Vue montará los componentes -->
    </div>

    <!-- Cargar jQuery primero -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Cargar DataTables JS después de jQuery -->
    <script type="text/javascript" src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>

    <!-- 🔥 Mover Vue al final del body para evitar problemas -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>


<style>
    /* Elimina el margen y padding por defecto del body */
    body {
        margin: 0;
        padding: 0;
        /* O cualquier color que desees */
        font-family: Arial, sans-serif;
        /* Establece una fuente base */
        height: 100vh;
        /* Asegura que el body ocupe toda la altura de la ventana */
    }

    html {
        height: 100%;
    }

    /* Opcionalmente puedes agregar un estilo base para el contenedor de la app */
    #app {
        height: 100%;
        /* Asegura que el contenedor ocupe toda la altura de la ventana */
        display: flex;
        flex-direction: column;
        /* Puedes usar Flexbox para tu layout */
    }

    .input-field {
        color: red
    }
</style>

</html>
