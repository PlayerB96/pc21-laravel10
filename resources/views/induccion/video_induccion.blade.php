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

        <button
            id="loginButtonManual"
            style="width: 16rem; padding: 1rem; margin: 1rem 0rem; background: var(--light-primary-bg); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
            Descargar Manual
        </button>


        <button
            id="btnContinuar"
            style="width: 16rem; padding: 1rem; margin: 1rem 0rem; background: var(--text-secondary); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
            data-route="{{ route('induccion.encuesta_induccion') }}"
            data-js="alert('JavaScript dinámico ejecutado');">
            Continuar
        </button>



    </div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const video = document.getElementById('induccionVideo');
        const contentSection = document.getElementById('contentSection');
        // video.onended = function() {
        contentSection.style.display = 'block';
        // };
    });
</script>


@endsection