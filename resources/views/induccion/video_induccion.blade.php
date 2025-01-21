@extends('layouts.app')
@section('title', 'Inducción')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/induccion/video_induccion.css') }}">
</head>
<div class="container">
    <h1>Bienvenido a la Inducción</h1>
    <h3>Una vez que finalice el video, se habilitará una encuesta para evaluar tu experiencia. ¡Gracias por tu participación!</h3>
    <div class="video-container">
        <video id="induccionVideo" class="video" controls>
            <source src="{{ asset('assets/videos/induccion.mp4') }}" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
    </div>

    <div id="contentSection" class="content-section">
        <a href="#" class="btn btn-download">
            Descargar Manual
        </a>

        <a data-route="{{ route('induccion.encuesta_induccion') }}" class="btn btn-continue">
            Continuar
        </a>
    </div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const video = document.getElementById('induccionVideo');
        const contentSection = document.getElementById('contentSection');
        video.onended = function() {
            contentSection.style.display = 'block'; // Mostrar la sección
        };
    });
</script>


@endsection