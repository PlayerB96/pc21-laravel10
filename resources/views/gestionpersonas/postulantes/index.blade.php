@extends('layouts.app')
@section('title', 'REGISTRO POSTULANTES')
@section('content')
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            .form-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }
            .form-group {
                flex: 1;
                min-width: 45%;
            }
            .form-group label {
                font-weight: bold;
            }
            .form-group input, .form-group select {
                width: 100%;
                padding: 8px;
                margin-top: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            .btn-submit {
                display: block;
                width: 100%;
                padding: 10px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-top: 20px;
            }
            #map {
                width: 100%;
                height: 300px;
                margin-top: 20px;
                border-radius: 5px;
            }
        </style>
    </head>
    <div class="layout-container-section-content">
        <div class="page-header">
            <div class="page-title">
                <h3>Registro de POSTULANTES</h3>
            </div>
        </div>
        <div class="widget-container-section-content">
            <form action="{{ route('gestionpersonas.store_rpo') }}" method="POST" id="surveyForm">
                @csrf
                <div class="form-container">
                    <div class="form-group">
                        <label>Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido Materno</label>
                        <input type="text" name="apellido_materno" required>
                    </div>
                    <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" name="nombres" required>
                    </div>
                    <div class="form-group">
                        <label>Nacionalidad</label>
                        <input type="text" name="nacionalidad" required>
                    </div>
                    <div class="form-group">
                        <label>Número de Documento</label>
                        <input type="text" name="numero_documento" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Documento</label>
                        <select name="tipo_documento" required>
                            <option value="DNI">DNI</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" required>
                    </div>
                    <div class="form-group">
                        <label>Edad</label>
                        <input type="number" name="edad" required>
                    </div>
                    <div class="form-group">
                        <label>Estado Civil</label>
                        <select name="estado_civil" required>
                            <option value="Soltero">Soltero</option>
                            <option value="Casado">Casado</option>
                            <option value="Divorciado">Divorciado</option>
                            <option value="Viudo">Viudo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label>Número Celular</label>
                        <input type="text" name="celular" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono Fijo</label>
                        <input type="text" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label>Departamento</label>
                        <input type="text" name="departamento" required>
                    </div>
                    <div class="form-group">
                        <label>Provincia</label>
                        <input type="text" name="provincia" required>
                    </div>
                    <div class="form-group">
                        <label>Distrito</label>
                        <input type="text" name="distrito" required>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label>Ubicación de tu vivienda</label>
                        <input type="text" id="ubicacion" name="ubicacion" required>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Registrar Postulante</button>
            </form>
            <div id="map"></div>
        </div>
    </div>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -12.0464, lng: -77.0428},
                zoom: 12
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap"></script>
@endsection
