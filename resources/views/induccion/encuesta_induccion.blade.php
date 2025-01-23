@extends('layouts.app')
@section('title', 'Inducción')
@section('content')

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
            <button type="submit" class="btn btn-submit">Enviar Respuestas</button>
        </form>
    </div>
</div>

<script>
    $('#surveyForm').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: "{{ route('induccion.submit_survey') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.porcentaje > 90) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Felicidades!',
                        text: `Has aprobado con un ${response.porcentaje}% de aciertos.`,
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Inténtalo de nuevo',
                        text: `Tu puntaje es del ${response.porcentaje}%.`,
                    });
                }
            }
        });
    });

    var preguntaGrupos = document.querySelectorAll('.form-group-encuesta');
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
</script>

<style>
.container {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
    text-align: center;
    font-family: 'Arial', sans-serif;
}

h3 {
    font-size: 1.75rem;
    font-weight: 600;
    margin-top: 1.5rem;
    color: var(--light-text);
    border-bottom: 2px solid var(--light-secondary-bg);
    display: inline-block;
    padding-bottom: 0.2rem;
    margin-bottom: 1.5rem;

}

/* Sección de contenido */
.content-section {
    margin-top: 1.5rem;
    padding: 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Formularios */
.form-group-encuesta {
    margin-bottom: 1.5rem;
    text-align: left;
    background-color: #f9f9f9;
    /* Fondo distinto para cada pregunta */
    border-radius: 10px;
    /* Bordes redondeados */
    padding: 1rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /* Sombra suave */
}

.form-group-encuesta label {
    font-weight: bold;
    display: block;
    margin-bottom: 0.5rem;
    color: black !important;
    font-size: 1.2rem;
}

.form-responses label {
    color: var(--text-secondary) !important;

}

/* Estilos para los checkboxes y respuestas */
.form-group-encuesta div {
    display: flex;
    justify-content: flex-start;
    /* Alinea los elementos al inicio */
    align-items: center;
    /* Centra los elementos verticalmente */
    margin-bottom: 1rem;
    /* Espacio entre cada checkbox */
}

.form-group-encuesta input[type="checkbox"] {
    margin-left: 10px;
    /* Margen a la izquierda del checkbox */
    width: 20px;
    height: 20px;
    accent-color: var(--light-secondary-bg);
}

/* Estilo para el texto de la respuesta */
.form-group-encuesta label {
    margin-left: 10px;
    /* Añadir un margen entre el checkbox y el texto */
    font-size: 1rem;
    color: var(--light-text);
}

/* Botones */
.btn {
    display: inline-block;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: bold;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
    cursor: pointer;
}

.btn-submit {
    background-color: var(--light-secondary-bg);
    color: white;
    border: none;
    box-shadow: 0 4px 6px rgba(255, 167, 0, 0.3);
    margin-top: 1.5rem;
}

.btn-submit:hover {
    background-color: var(--light-text);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 1.5rem;
    }

    h3 {
        font-size: 1.5rem;
    }

    .form-control {
        font-size: 0.95rem;
    }

    .btn {
        font-size: 1rem;
    }
}</style>
@endsection