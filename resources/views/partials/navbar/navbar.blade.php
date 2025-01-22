@include('partials.navbar.modal_login')

<?php
$navItems = [
    ['label' => 'eLearning', 'route' => '/home', 'subitems' => []],
    ['label' => 'Inducción', 'route' => '/induccion', 'subitems' => []],
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
<nav class="navbar primarybg">
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
            <ul class="sub-menu primarybg" id="sub-menu-{{ $loop->index }}">
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
            <div class="dropdown-menu primarybg" aria-labelledby="userProfileDropdown">
                <div class="user-profile-section">
                    <div class="media mx-auto">
                        <div class="media-body">
                            <h5></h5>
                        </div>
                    </div>
                </div>
                <div class="dropdown-item">
                    <a href="url_to_profile_page">
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

        <button
            id="login-btn-{{ uniqid() }}"
            class="btn-primary"
            style="padding: 0.8rem 1.6rem; font-size: 1rem; border-radius: 0.5rem; color:white;"
            onclick="handleLoginClick()">
            <span class="btn-icon" style="margin-right: 0.5rem; display: inline-block; width: 24px; height: 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
            </span>
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