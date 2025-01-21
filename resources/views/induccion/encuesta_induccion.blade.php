@extends('layouts.app')
@section('title', 'Inducción')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/induccion/encuesta_induccion.css') }}">
</head>
<div class="container">

    <div id="contentSection" class="content-section">
        <h3>Encuesta de Evaluación</h3>
        <form action="{{ route('induccion.submit_survey') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="question1">¿Qué tan útil fue el contenido del video?</label>
                <select id="question1" name="question1" class="form-control" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Muy útil">Muy útil</option>
                    <option value="Útil">Útil</option>
                    <option value="Poco útil">Poco útil</option>
                    <option value="Nada útil">Nada útil</option>
                </select>
            </div>

            <div class="form-group">
                <label for="question2">¿Consideras que el video cubrió todos los aspectos importantes?</label>
                <select id="question2" name="question2" class="form-control" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Sí">Sí</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="question3">¿Cómo calificarías la calidad del video?</label>
                <select id="question3" name="question3" class="form-control" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Excelente">Excelente</option>
                    <option value="Buena">Buena</option>
                    <option value="Regular">Regular</option>
                    <option value="Mala">Mala</option>
                </select>
            </div>

            <div class="form-group">
                <label for="question4">Comentarios adicionales</label>
                <textarea id="question4" name="question4" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-submit">Enviar Encuesta</button>
        </form>
    </div>
</div>


@endsection