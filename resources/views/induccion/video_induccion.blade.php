@extends('layouts.app')
@section('title', 'Inducción')
@section('content')


<div class="container">

    <h1 style="margin-bottom:0">Bienvenido a la Inducción</h1>
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
            style="width: 16rem; padding: 1rem; margin: 1rem 0rem; background: var(--text-secondary); color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
            data-route="{{ route('induccion.encuesta_induccion') }}">
            Continuar
        </button>


    </div>
</div>
<script>
    const video = document.getElementById('induccionVideo');
    const contentSection = document.getElementById('contentSection');
    // video.onended = function() {
        contentSection.style.display = 'block';
    // };
</script>

<style>
    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        text-align: center;
    }

    h1 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
    }

    .video-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .video {
        width: 100%;
        max-width: 900px;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .content-section {
        display: none;
        margin-top: 1.5rem;
    }

    .btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-download {
        background-color: #1d4ed8;
        color: white;
    }

    .btn-download:hover {
        background-color: #2563eb;
    }

    .btn-continue {
        background-color: #10b981;
        color: white;
        margin-top: 1rem;
    }

    .btn-continue:hover {
        background-color: #059669;
    }
</style>

@endsection