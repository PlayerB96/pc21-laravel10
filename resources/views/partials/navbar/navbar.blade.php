@include('partials.navbar.modal_login')

<?php
$navItems = [['label' => 'Inicio', 'route' => '/inicio', 'subitems' => []], ['label' => 'Inducción', 'route' => '/induccion', 'subitems' => []], ['label' => 'Ecommerce', 'route' => '/ecommerce', 'subitems' => []], ['label' => 'Gestión de Personas', 'route' => '/gestionpersonas', 'subitems' => [['label' => 'Papeletas', 'route' => '/gestionpersonas/registro_papeletas'], ['label' => 'Datos Colaboradores', 'route' => '/gestionpersonas/registro_colaboradores']]], ['label' => 'Producción', 'route' => '/produccion', 'subitems' => [['label' => 'Fichas Técnicas', 'route' => '/produccion/fichas_produccion']]], ['label' => 'Identidad Corporativa', 'route' => '/identidadcorporativa', 'subitems' => []], ['label' => 'Empresas', 'route' => '/empresas', 'subitems' => []], ['label' => 'Productos', 'route' => '/productos', 'subitems' => []], ['label' => 'Blog', 'route' => '/blog', 'subitems' => []]];

// VISTAS PARA CUANDO EXISTE UNA SESSION
if (!Session::has('usuario_codigo')) {
    // Remover items específicos solo cuando no haya sesión
    $navItems = array_filter($navItems, function ($item) {
        return !in_array($item['label'], ['Inducción', 'Gestión de Personas', 'Producción']);
    });
}
?>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<nav class="navbar primarybg">
    <!-- Imagen a la derecha -->
    <div class="navbar-logo">
        <img src="{{ asset('assets/imgs/Grupo-LN1.png') }}" alt="Grupo LN1 Logo">
    </div>
    <!-- Menú de navegación -->
    <ul class="navbar-menu">
        @foreach ($navItems as $item)
            <li class="navbar-item" onclick="toggleSubMenu({{ $loop->index }})">
                <a href="{{ $item['route'] }}" data-route="{{ $item['route'] }}" class="navbar-link"
                    onclick="setActiveLink(this)">
                    {{ $item['label'] }}
                </a>
                @if (count($item['subitems']) > 0)
                    <ul class="sub-menu primarybg" id="sub-menu-{{ $loop->index }}">
                        @foreach ($item['subitems'] as $subitem)
                            <li>
                                <a href="{{ $subitem['route'] }}" data-route="{{ $subitem['route'] }}"
                                    class="navbar-link" onclick="setActiveLink(this)">
                                    {{ $subitem['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
    <div class="navbar-right">
        @if (Session::has('usuario_codigo'))
            <!-- Si la sesión contiene el código del usuario, mostrar el perfil -->
            <div class="nav-item dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </a>
                <div class="dropdown-menu" aria-labelledby="userProfileDropdown">
                    <div class="user-profile-section">
                        <div class="media mx-auto">
                            <div class="media-body">
                                <h5>{{ Session::get('nombre_completo') }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-item">
                        <a href="#">
                            <img id="setting" src="{{ asset('assets/icons/setting.svg') }}" alt="Configuración" />
                            <span>Configuración</span>
                        </a>
                    </div>
                    <div class="dropdown-item" id="logoutBtn">
                        <a href="javascript:void(0);">
                            <img id="quit" src="{{ asset('assets/icons/quit.svg') }}" alt="Salir" />
                            <span>Salir</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Si no hay sesión, mostrar el botón de inicio de sesión -->
            <button id="login-btn-{{ uniqid() }}" class="btn-primary"
                style="padding: 0.8rem 1.6rem; font-size: 1rem; border-radius: 0.5rem; color:white;"
                onclick="handleLoginClick()">
                <span class="btn-icon" style="margin-right: 0.5rem; display: inline-block; width: 24px; height: 24px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </span>
                Iniciar sesión
            </button>
        @endif

        <!-- Icono para cambiar el modo -->
        <div class="theme-toggle">
            <button onclick="toggleDarkMode()" class="theme-toggle-button">
                <div class="theme-icons">
                    <!-- Icono de sol -->
                    <img id="sun-icon" src="{{ asset('assets/icons/sun-icon.svg') }}" alt="Sol Icono"
                        class="theme-icon" style="display:none;" />
                    <!-- Icono de luna -->
                    <img id="moon-icon" src="{{ asset('assets/icons/moon-icon.svg') }}" alt="Luna Icono"
                        class="theme-icon" />
                </div>
            </button>
        </div>
    </div>
</nav>

<script src="{{ asset('js/navbar/navbar.js') }}"></script>
<style>
    body.light .navbar {
        background: var(--light-primary-bg);
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        position: relative;
        /* Inicialmente no sticky */
        top: 0;
        z-index: 2;
        transition: top 0.3s;
        width: 100%;
    }

    body.dark .navbar {
        background: var(--dark-primary-bg);
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        position: relative;
        /* Inicialmente no sticky */
        top: 0;
        z-index: 2;
        transition: top 0.3s;
        width: 100%;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 20px;
        /* Ajusta el espacio entre los elementos */
    }

    .nav-item.dropdown {
        position: relative;
    }

    .dropdown-menu {

        display: none;
        position: absolute;
        top: 100%;
        left: -6rem;
        z-index: 2;
        min-width: 200px;
        border-radius: 4px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    body.dark .dropdown-menu {
        background-color: var(--dark-primary-bg) !important;

    }

    body.light .dropdown-menu {
        background-color: var(--light-primary-bg) !important;

    }

    /* Cuando el menú tiene la clase 'show', se hace visible */
    .show {
        display: block;
    }

    /* Estilos para los elementos dentro del dropdown */
    .dropdown-item a {
        padding: 10px 15px;
        /* Espaciado interno */
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .dropdown-item a span {
        color: white !important;
    }

    .dropdown-item img {
        display: block;
        width: 24px;
        height: 24px;
    }

    .dropdown-item span {
        display: block;
        white-space: nowrap;
    }



    /* Cambiar color al pasar el cursor por encima */
    body.light .dropdown-item:hover {
        background-color: var(--light-accent);
    }

    body.dark .dropdown-item:hover {
        background-color: var(--dark-secondary-bg);
    }

    /* Estilo para los iconos dentro de los elementos */
    .dropdown-item svg {
        margin-right: 10px;
    }

    /* Estilos para el icono de usuario y los detalles del perfil */
    .user-profile-section {
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
    }

    /* Media query para hacer que el menú sea más accesible en pantallas pequeñas */
    @media (max-width: 768px) {
        .dropdown-menu {
            left: 0;
            /* Elimina el desplazamiento hacia la izquierda */
            min-width: 150px;
            /* Ajusta el tamaño mínimo si es necesario */
        }
    }



    .navbar.sticky {
        position: fixed;
        /* Hace el navbar sticky */
        top: 0;
    }

    .navbar-logo img {
        height: 4rem;
    }

    .navbar ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    .navbar-link {
        color: white;
        text-decoration: none;
    }

    .navbar-link.active {
        color: var(--light-secondary-bg);

    }



    .media-body h5 {
        color: white !important;
    }

    /* Estilo del submenú */
    .sub-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: var(--dark-primary-bg);
        padding: 20px;
        opacity: 0;
        min-width: 140px;
        transition: opacity 0.3s ease-in-out;

    }

    .sub-menu li {
        display: block;
        margin-bottom: 5px;
        margin: 5px 15px;
    }

    .sub-menu {
        width: auto;
    }

    .navbar-item:hover>.sub-menu {
        visibility: visible;
        opacity: 1;
        display: block;

    }




    .parent:hover .sub-menu {
        background-color: red !important;
    }

    .navbar-item {
        position: relative;
        padding: 5px 15px;
    }



    /* Estilos del botón de cambio de tema */
    .theme-toggle button {
        background-color: var(--dark-primary-bg);
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .theme-icons img {
        width: 30px;
        height: 30px;
    }

    body.dark .navbar-link.active {
        color: #FFD700;
    }

    body.light .navbar-link:hover,
    .navbar-link.active {
        color: var();
    }

    body.light .bg {
        background-color: var(--light-primary-bg);
    }

    body.dark .bg {
        background-color: var(--dark-primary-bg);
    }


    /* Responsividad: menú desplegable */
    @media (max-width: 768px) {
        .navbar {
            background-color: var(--dark-primary-bg);
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: relative;
            /* Inicialmente no sticky */
            top: 0;
            z-index: 2;
            transition: top 0.3s;
            width: 100%;
            /* Suaviza la transición al aparecer/desaparecer */
        }

        .navbar.sticky {
            position: fixed;
            /* Hace el navbar sticky */
            top: 0;
        }

        .navbar-menu {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        .navbar-item {
            text-align: left;
            width: 100%;
            /* Asegura que cada ítem ocupe el 100% de ancho en pantallas pequeñas */
            display: block;
            /* Se asegura de que el item sea un bloque */
            padding: 10px 15px;
            /* Ajuste de padding para mejor apariencia */
        }

        .navbar-item .sub-menu {
            position: static;
            display: none;
            /* Aseguramos que el submenú esté oculto por defecto */
            width: 100%;
            padding: 0;

        }

        .sub-menu {
            position: static;
            display: none;
            width: 100%;
            /* Asegura que el submenú también ocupe todo el ancho */
            padding: 0;
            /* Elimina padding extra en submenú */
        }

        .navbar-item:hover>.sub-menu {
            display: block;
        }

        .navbar-item.active>.sub-menu {
            display: block;
        }

        .sub-menu li {
            padding: 10px 15px;
        }

        /* Asegurando que la imagen y el botón se ubiquen correctamente */
        .navbar-logo {
            order: -1;
            margin-bottom: 10px;
        }

        .theme-toggle {
            margin-top: 10px;
            order: 1;
            width: 100%;
            display: flex;
            justify-content: flex-start;
        }

        .theme-icons img {
            width: 2rem;
            height: 2rem;
        }
    }
</style>
