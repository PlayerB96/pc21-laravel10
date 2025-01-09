<!-- resources/views/partials/navbar.blade.php -->

<?php
$navItems = [
    ['label' => 'Home', 'route' => '/home', 'subitems' => []],
    ['label' => 'About', 'route' => '/about', 'subitems' => []],
    ['label' => 'Services', 'route' => '/services', 'subitems' => [
        ['label' => 'Web Development', 'route' => '/services/web'],
        ['label' => 'App Development', 'route' => '/services/app'],
        ['label' => 'SEO Optimization', 'route' => '/services/seo'],
    ]],
    ['label' => 'Inicio', 'route' => '/inicio', 'subitems' => []],
];
?>

<nav class="navbar navbarbackground">
    <!-- Imagen a la derecha -->
    <div class="navbar-logo">
        <img src="{{ asset('assets/imgs/Grupo-LN1.png') }}" alt="Grupo LN1 Logo">
    </div>
    <!-- Menú de navegación -->
    <ul class="navbar-menu">
        @foreach ($navItems as $item)
        <li class="navbar-item" onclick="toggleSubMenu({{ $loop->index }})">
            <a href="{{ $item['route'] }}" data-route="{{ $item['route'] }}" class="navbar-link" onclick="setActiveLink(this)">
                {{ $item['label'] }}
            </a>
            @if (count($item['subitems']) > 0)
            <ul class="sub-menu sub-menubg" id="sub-menu-{{ $loop->index }}">
                @foreach ($item['subitems'] as $subitem)
                <li>
                    <a href="{{ $subitem['route'] }}" class="navbar-link" onclick="setActiveLink(this)">
                        {{ $subitem['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
    </ul>

    <!-- Icono para cambiar el modo -->
    <div class="theme-toggle">
        <button onclick="toggleDarkMode()" class="theme-toggle-button">
            <div class="theme-icons">
                <!-- Icono de sol -->
                <img id="sun-icon" src="{{ asset('assets/icons/sun-icon.svg') }}" alt="Sol Icono" class="theme-icon" style="display:none;" />
                <!-- Icono de luna -->
                <img id="moon-icon" src="{{ asset('assets/icons/moon-icon.svg') }}" alt="Luna Icono" class="theme-icon" />
            </div>
        </button>
    </div>
</nav>


<style>
    .navbar {
        /* background-color: #333; */
        color: white;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        position: relative;
        /* Inicialmente no sticky */
        top: 0;
        z-index: 1000;
        transition: top 0.3s;
        width: 100%;
        /* Suaviza la transición al aparecer/desaparecer */
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
        color: var(--menu-active);

    }

    /* Estilo del submenú */
    .sub-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #333;
        padding: 20px;
        opacity: 0;
        min-width: 140px;
    }


    .navbar-item:hover>.sub-menu {
        visibility: visible;
        opacity: 1;
        display: block;
    }

    .sub-menu li {
        display: block;
        margin-bottom: 5px;
        margin: 5px 15px;
    }

    .navbar-item {
        position: relative;
        padding: 5px 15px;
    }

    .sub-menu {
        width: auto;
    }

    /* Estilos del botón de cambio de tema */
    .theme-toggle button {
        background-color: #333;
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

    /* Responsividad: menú desplegable */
    @media (max-width: 768px) {
        .navbar {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: relative;
            /* Inicialmente no sticky */
            top: 0;
            z-index: 1000;
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


<script>
    // Función para alternar entre modo claro y oscuro
    function toggleDarkMode() {
        const body = document.body; // Asegúrate de que trabajas con el <body>
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');

        // Alterna las clases de modo claro y oscuro
        if (body.classList.contains('dark')) {
            body.classList.remove('dark');
            body.classList.add('light');
            moonIcon.style.display = 'block';
            sunIcon.style.display = 'none';
            localStorage.setItem('theme', 'light'); // Guardar en localStorage

        } else {
            body.classList.remove('light');
            body.classList.add('dark');
            moonIcon.style.display = 'none';
            sunIcon.style.display = 'block';
            localStorage.setItem('theme', 'dark'); // Guardar en localStorage

        }
    }


    // Configurar el tema al cargar la página
    window.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        const body = document.body;

        if (savedTheme) {
            body.classList.add(savedTheme);
        } else {
            body.classList.add('light'); // Tema predeterminado
        }
    });
    let lastScrollTop = 0; // Variable para almacenar la última posición de desplazamiento

    window.addEventListener("scroll", function() {
        let navbar = document.querySelector(".navbar");
        let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        if (currentScroll > lastScrollTop) {
            // Si estamos desplazándonos hacia abajo
            navbar.classList.add("sticky");
        } else {
            // Si estamos desplazándonos hacia arriba
            navbar.classList.remove("sticky");
        }

        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Evita que el scroll sea negativo
    });
    // Función para manejar la clase activa en los enlaces
    function setActiveLink(link) {
        // Eliminar la clase activa de todos los enlaces
        const links = document.querySelectorAll('.navbar-link');
        links.forEach(function(item) {
            item.classList.remove('active');
        });

        // Agregar la clase activa al enlace seleccionado
        link.classList.add('active');
    }

    function toggleSubMenu(index) {
        const subMenu = document.getElementById('sub-menu-' + index);
        if (subMenu.style.display === 'block') {
            subMenu.style.display = 'none';
        } else {
            subMenu.style.display = 'block';
        }
    }
</script>