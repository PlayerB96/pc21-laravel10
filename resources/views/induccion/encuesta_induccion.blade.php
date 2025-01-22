@extends('layouts.app')
@section('title', 'Inducción')
@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/induccion/encuesta_induccion.css') }}">
</head>
<div class="container">
    <div id="contentSection" class="content-section">
        <h3>Evaluación de Inducción</h3>
        <form action="{{ route('induccion.submit_survey') }}" method="POST" id="surveyForm">
            @csrf
            @foreach($preguntas as $index => $pregunta)
            <div class="form-group-encuesta">
                <label>Pregunta {{ $index + 1 }}: {{ $pregunta->pregunta }}</label>
                @foreach($pregunta->respuestas as $respuesta)
                <div class="form-responses">
                    <input type="checkbox" name="respuestas[{{ $pregunta->id_pregunta }}][]"
                        value="{{ $respuesta->id_respuesta }}" class="respuesta-checkbox">
                    <label>{{ $respuesta->desc_respuesta }}</label>
                </div>
                @endforeach
            </div>
            @endforeach
            <button type="submit" class="btn btn-submit">Enviar Encuesta</button>
        </form>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tu código JavaScript aquí
        const preguntaGrupos = document.querySelectorAll('.form-group-encuesta');
        preguntaGrupos.forEach((grupo) => {
            const checkboxes = grupo.querySelectorAll('.respuesta-checkbox');
            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', function() {
                    let seleccionados = grupo.querySelectorAll('.respuesta-checkbox:checked').length;
                    if (seleccionados > 3) {
                        this.checked = false;
                        Swal.fire({
                            icon: 'warning',
                            title: 'Límite alcanzado',
                            text: 'Solo puedes seleccionar un máximo de 3 respuestas por pregunta.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Entendido'
                        });
                    }
                });
            });
        });
    });
</script>
@endsection