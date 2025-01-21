@extends('layouts.app')
@section('title', 'Bienvenido a Extranet La Número Uno')
@section('content')
<!-- Sección con video de fondo -->
<section class="video-background-container">
    <!-- Fondo degradado encima del video -->
    <div class="gradient-overlay"></div>

    <!-- Video de fondo -->
    <video autoplay loop muted class="video-background">
        <source src="{{ asset('assets/videos/induccion.mp4') }}" type="video/mp4">
    </video>

    <!-- Contenido sobre el video -->
    <div class="content">
        <!-- <h1>Bienvenido <label for=""></label></h1>
        <p>Extranet - Lanúmerouno</p> -->
    </div>
</section>


<button class="button px-4 py-2 rounded mt-6">Botón de ejemplo</button>

<!-- Servicios -->
<section class="services mt-10">
    <div class="container mx-auto">
        <div class="service-cards real-content hidden" id="real-content">
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 1</h3>
                <p class="mt-2">Accede a herramientas avanzadas para mejorar tu productividad.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 2</h3>
                <p class="mt-2">Conéctate con tu equipo de forma rápida y segura.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 3</h3>
                <p class="mt-2">Gestiona tus proyectos en tiempo real con facilidad.</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="service-cards real-content hidden" id="real-content">
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 1</h3>
                <p class="mt-2">Accede a herramientas avanzadas para mejorar tu productividad.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 2</h3>
                <p class="mt-2">Conéctate con tu equipo de forma rápida y segura.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 3</h3>
                <p class="mt-2">Gestiona tus proyectos en tiempo real con facilidad.</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="service-cards real-content hidden" id="real-content">
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 1</h3>
                <p class="mt-2">Accede a herramientas avanzadas para mejorar tu productividad.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 2</h3>
                <p class="mt-2">Conéctate con tu equipo de forma rápida y segura.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 3</h3>
                <p class="mt-2">Gestiona tus proyectos en tiempo real con facilidad.</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="service-cards real-content hidden" id="real-content">
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 1</h3>
                <p class="mt-2">Accede a herramientas avanzadas para mejorar tu productividad.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 2</h3>
                <p class="mt-2">Conéctate con tu equipo de forma rápida y segura.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 3</h3>
                <p class="mt-2">Gestiona tus proyectos en tiempo real con facilidad.</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="service-cards real-content hidden" id="real-content">
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 1</h3>
                <p class="mt-2">Accede a herramientas avanzadas para mejorar tu productividad.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 2</h3>
                <p class="mt-2">Conéctate con tu equipo de forma rápida y segura.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 3</h3>
                <p class="mt-2">Gestiona tus proyectos en tiempo real con facilidad.</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="service-cards real-content hidden" id="real-content">
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 1</h3>
                <p class="mt-2">Accede a herramientas avanzadas para mejorar tu productividad.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 2</h3>
                <p class="mt-2">Conéctate con tu equipo de forma rápida y segura.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 3</h3>
                <p class="mt-2">Gestiona tus proyectos en tiempo real con facilidad.</p>
            </div>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="service-cards real-content hidden" id="real-content">
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 1</h3>
                <p class="mt-2">Accede a herramientas avanzadas para mejorar tu productividad.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 2</h3>
                <p class="mt-2">Conéctate con tu equipo de forma rápida y segura.</p>
            </div>
            <div class="card p-4 rounded light:bg-white dark:bg-gray-700 shadow">
                <h3 class="font-bold light:text-blue-600 dark:text-blue-300">Servicio 3</h3>
                <p class="mt-2">Gestiona tus proyectos en tiempo real con facilidad.</p>
            </div>
        </div>
    </div>
</section>
<style>
    /* Contenedor general */
    .video-background-container {
        position: relative;
        width: 100%;
        height: 100vh;
        /* Altura completa de la ventana */
        overflow: hidden;
    }

    /* Fondo de video */
    .video-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Asegura que el video cubra todo el contenedor */
    }

    /* Contenido sobre el video */
    .content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        text-align: center;
        z-index: 20;
        /* Asegura que el contenido esté por encima del fondo degradado y el video */
    }

    .content h1 {
        font-size: 6rem;
        font-weight: bold;
        background: linear-gradient(to right, var(--light-secondary-bg), var(--light-secondary-bg));
        /* Gradiente de fondo */
        -webkit-background-clip: text;
        /* Para Safari y Chrome */
        background-clip: text;
        /* Propiedad estándar para otros navegadores */
        color: transparent;
        /* Hace que solo se vea el gradiente en el texto */
        border: 2px solid var(--light-secondary-bg);
        /* Borde alrededor del texto */
        padding: 5px;
        /* Espaciado para que el borde se vea bien */
    }



    .content p {
        font-size: 1.25rem;
        margin-top: 1rem;
        background: linear-gradient(to right, var(--light-secondary-bg), var(--light-secondary-bg));

    }
</style>

@endsection