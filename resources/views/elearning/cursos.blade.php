@extends('layouts.app')
@section('title', 'eLearning')
@section('content')

<div class="header-cursos">
    <h1>Mis cursos </h1>
    <p>Vista general de curso</p>
</div>

<div class="video-grid">
    @foreach ($videos as $video)
    <div class="video-card">
        <div class="video-wrapper">
            <x-skeleton-loader type="div" count="1" class="video-skeleton" />
            <iframe
                class="video-iframe"
                width="100%"
                height="250"
                src="{{ str_replace('watch?v=', 'embed/', $video['url']) }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                onload="removeSkeleton(this)">
            </iframe>
        </div>

        <div class="video-description">
            <h3>{{ $video['title'] }}</h3>
            <p>{{ $video['description'] }}</p>
        </div>
    </div>
    @endforeach
</div>


<script>
    function removeSkeleton(iframe) {
        let skeleton = iframe.previousElementSibling;
        if (skeleton) {
            skeleton.remove(); // Elimina el skeleton
        }
        iframe.style.opacity = '1';
    }
</script>

<style>
    /*responsive*/
    @media(max-width: 767px) {
        .video-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr) !important;
            gap: 20px;
            padding: 2rem;
        }
    }

    /* Skeleton Loader Effect */
    .video-skeleton {
        width: 100%;
        height: 250px;
        background: linear-gradient(90deg, #eee 25%, #ddd 50%, #eee 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 10px;
    }

    @keyframes loading {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    .header-cursos {
        padding: 1rem 0rem 0rem 3rem;
    }

    .header-cursos h1 {
        font-size: 24px;
        font-weight: bold;
    }

    .video-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 2rem;
    }

    .video-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    body.light .video-card{
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        background-color: #f9f9f9;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    body.dark .video-card{
        border: 1px solid var(--light-secondary-bg);
        border-radius: 10px;
        padding: 15px;
        background-color: var(--dark-primary-bg);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .video-wrapper {
        position: relative;
        width: 100%;
        height: 250px;
    }

    .video-iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        border-radius: 10px;
    }

    body.dark .video-description h3 {
        margin: 10px 0 5px;
        font-size: 1.2rem;
        color: var(--dark-text);
    }
    body.light .video-description h3 {
        margin: 10px 0 5px;
        font-size: 1.2rem;
        color: var(--light-text);
    }

    .video-description p {
        font-size: 1rem;
        color: var(--text-secondary);
    }
</style>

@endsection