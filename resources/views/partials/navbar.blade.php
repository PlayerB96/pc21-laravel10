<!-- resources/views/partials/navbar.blade.php -->

<?php
$navItems = [
    ['label' => 'eLearning', 'route' => '/home', 'subitems' => []],
    ['label' => 'About', 'route' => '/about', 'subitems' => []],
    ['label' => 'Services', 'route' => '/services', 'subitems' => [
        ['label' => 'Web Development', 'route' => '/services/web'],
        ['label' => 'App Development', 'route' => '/services/app'],
        ['label' => 'SEO Optimization', 'route' => '/services/seo'],
    ]],
    ['label' => 'Inicio', 'route' => '/inicio', 'subitems' => []],
];
?>

<head>
    <link rel="stylesheet" href="{{ asset('css/navbar/navbar.css') }}">
</head>
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
    <div class="navbar-right">
        <div class="nav-item dropdown" style="display: none;">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </a>
            <div class="dropdown-menu" aria-labelledby="userProfileDropdown">
                <div class="user-profile-section">
                    <div class="media mx-auto">
                        <div class="media-body">
                            <h5></h5> <!-- El nombre del usuario se insertará aquí -->
                        </div>
                    </div>
                </div>
                <div class="dropdown-item">
                    <a href="url_to_profile_page">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Mi Perfil</span>
                    </a>
                </div>
                <div class="dropdown-item">
                    <a href="logout_url">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Salir</span>
                    </a>
                </div>
            </div>
        </div>

        <button class="login-button" style="display: none;" data-route="{{ '/login' }}" onclick="redirectToLogin(this)">
            Iniciar sesión
        </button>
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
    </div>
</nav>
<script src="{{ asset('js/navbar/navbar.js') }}"></script>