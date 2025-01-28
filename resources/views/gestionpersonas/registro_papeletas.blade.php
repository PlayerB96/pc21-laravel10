@extends('layouts.app')
@section('title', 'REGISTRO PAPELETAS')
@include('gestionpersonas.modal_insert')
@section('content')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="layout-container-section-content">
        <div class="page-header">
            <div class="page-title">
                <h3>Registro de Papeletas</h3>
            </div>
        </div>
        <div class="widget-container-section-content">
            <div class="toolbar-section-content">
                {{-- A PARTIR DE AQUI CAMBIA EL CONTENIDO --}}
                <div class="toolbar-col">
                    <label class="control-label text-bold">Estado Solicitud11:</label>
                    <select id="estado_solicitud" name="estado_solicitud" class="form-control">
                        <option value="0">Todos</option>
                        <option value="1" selected>En Proceso de aprobacion</option>
                        <option value="2">Aprobados</option>
                        <option value="3">Denegados</option>
                    </select>
                </div>

                <div class="toolbar-col">
                    <button type="button" id="login-btn-{{ uniqid() }}" class="btn-section-content" title="Registrar"
                        data-toggle="modal" onclick="handleInsert()"
                        app_reg_grande="{{ url('gestionpersonas/modal_registro_papeletas') }}">
                        Registrar
                    </button>
                </div>

                {{-- @if ($registro_masivo == 1 || $id_nivel == 1 || $id_puesto == 314)
                    <div class="toolbar-col">
                        <button type="button" class="btn-section-content" title="Registrar Masivo" data-toggle="modal"
                            data-target="#ModalRegistroGrande"
                            app_reg_grande="{{ url('Papeletas/Modal_Papeletas_Salida/1') }}">
                            Registro Masivo
                        </button>
                    </div>
                @endif --}}
            </div>
            @csrf
            <div class="table-responsive" id="lista_colaborador">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Motivo</th>
                            <th>Destino</th>
                            <th>Trámite</th>
                            <th>Fecha</th>
                            <th>H. Salida</th>
                            <th>H. Retorno</th>
                            <th>Estado</th>
                            @if ($ultima_papeleta_salida_todo > 0)
                                <th class="no-content"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_papeletas_salida as $list)
                            <tr>
                                <td>{{ $list['id_motivo'] == 1 ? 'Laboral' : ($list['id_motivo'] == 2 ? 'Personal' : $list['motivo']) }}
                                </td>
                                <td>{{ $list['destino'] }}</td>
                                <td>{{ $list['tramite'] }}</td>
                                <td align="center">{{ date('d/m/Y', strtotime($list['fec_solicitud'])) }}</td>
                                <td align="center">
                                    {{ $list['sin_ingreso'] == 1 ? 'Sin Ingreso' : $list['hora_salida'] }}
                                </td>
                                <td align="center">
                                    {{ $list['sin_retorno'] == 1 ? 'Sin Retorno' : $list['hora_retorno'] }}
                                </td>
                                <td align="center">
                                    @if ($list['estado_solicitud'] == 1)
                                        <span class="badge badge-warning">En proceso</span>
                                    @elseif($list['estado_solicitud'] == 2)
                                        <span class="badge badge-primary">Aprobado</span>
                                    @elseif($list['estado_solicitud'] == 3)
                                        <span class="badge badge-danger">Denegado</span>
                                    @elseif($list['estado_solicitud'] == 4)
                                        <span class="badge badge-warning">En proceso - Aprobación Gerencia</span>
                                    @elseif($list['estado_solicitud'] == 5)
                                        <span class="badge badge-warning">En proceso - Aprobación RRHH</span>
                                    @else
                                        <span class="badge badge-primary">Error</span>
                                    @endif
                                </td>
                                @if ($ultima_papeleta_salida_todo > 0)
                                    <td class="text-center">
                                        @if ($list['estado_solicitud'] == 1)
                                            <a href="#" class="btn-action" title="Eliminar"
                                                onclick="Delete_Papeletas_Salida('{{ $list['id_solicitudes_user'] }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 text-danger">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg>
                                            </a>
                                        @else
                                            <a title="No puedes editar" class="anchor-tooltip tooltiped">
                                                <div class="divdea">
                                                    <svg id="Layer_1" width="13" height="13" data-name="Layer 1"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
                                                        <defs>
                                                            <style>
                                                                .cls-1 {
                                                                    fill: #2d3e50;
                                                                }
                                                            </style>
                                                        </defs>
                                                        <title>n</title>
                                                        <path class="cls-1"
                                                            d="M86.15787,99.25657c-3.54161,2.827-10.03158,6.41724-14.75995,6.08384-4.67736-.3298-3.78182-4.78987-2.85481-8.295l7.83763-29.63476a13.29171,13.29171,0,0,0-25.68221-6.86278C49.55418,64.7858,40.39666,102.57942,40.34023,102.816c-1.28065,5.36943-2.81226,12.2324-.45115,17.525,3.58188,8.02819,14.46035,5.69646,21.06968,3.78541a52.68574,52.68574,0,0,0,12.91952-5.64322,118.52775,118.52775,0,0,0,13.15678-10.41187Z" />
                                                        <path class="cls-1"
                                                            d="M74.55393,2.049c-9.8517-.61753-19.65075,8.23893-20.034,18.3877a15.14774,15.14774,0,0,0,2.23531,8.54311c6.11649,9.89677,20.16846,7.7415,27.76526.91074C94.54734,20.87483,87.832,2.88134,74.55393,2.049Z" />
                                                    </svg>
                                                </div>
                                            </a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#estado_solicitud').on('change', Busca_Registro_Papeleta);
        });

        function handleInsert() {
            const modalElement = document.getElementById("modalInsertPS");
            // Verifica si el modal existe
            if (modalElement) {
                console.log("Modal encontrado:", modalElement);
                openModal(modalElement.id);
            } else {
                alert("El modal no se encontró");
            }
        }


        function Busca_Registro_Papeleta() {
            var estado_solicitud = $('#estado_solicitud').val();
            const url = "/gestionpersonas/buscar_papeletas";
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'estado_solicitud': estado_solicitud
                },
                success: function(data) {
                    var tableBody = $('#lista_colaborador tbody');
                    tableBody.empty();
                    // Usamos la función para crear las filas y agregar al cuerpo de la tabla
                    data.list_papeletas_salida.forEach(function(list) {
                        var row = generateTableRow(list);
                        tableBody.append(row);
                    });
                }
            });
        }

        function generateTableRow(list) {
            const motivo = list.id_motivo === 1 ? 'Laboral' : (list.id_motivo === 2 ? 'Personal' : list.motivo);
            const estadoSolicitud = {
                1: '<span class="badge badge-warning">En proceso</span>',
                2: '<span class="badge badge-primary">Aprobado</span>',
                3: '<span class="badge badge-danger">Denegado</span>',
                4: '<span class="badge badge-warning">En proceso - Aprobación Gerencia</span>',
                5: '<span class="badge badge-warning">En proceso - Aprobación RRHH</span>',
            } [list.estado_solicitud] || '<span class="badge badge-primary">Error</span>';

            const horaSalida = list.sin_ingreso === 1 ? 'Sin Ingreso' : list.hora_salida;
            const horaRetorno = list.sin_retorno === 1 ? 'Sin Retorno' : list.hora_retorno;

            const deleteButton = list.estado_solicitud === 1 ? `
        <td class="text-center">
            <a href="#" class="btn-action" title="Eliminar" onclick="Delete_Papeletas_Salida('${list.id_solicitudes_user}')">
                <!-- SVG Icon -->
            </a>
        </td>` : '';

            return `
        <tr>
            <td>${motivo}</td>
            <td>${list.destino.nom_destino}</td> <!-- Nombre del destino -->
            <td>${list.tramite.nom_tramite}</td> <!-- Nombre del trámite -->
            <td align="center">${new Date(list.fec_solicitud).toLocaleDateString()}</td>
            <td align="center">${horaSalida}</td>
            <td align="center">${horaRetorno}</td>
            <td align="center">${estadoSolicitud}</td>
            ${deleteButton}
        </tr>`;
        }
    </script>

    <style>
        .page-header {
            padding: 20px;

            border-bottom: 1px solid #ddd;
        }

        .toolbar-row {
            background-color: red
        }

        .page-title h3 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .estado_solicitud {
            color: red !important
        }


        .toolbar-section-content .form-control {
            margin-right: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        body.dark .toolbar-section-content .form-control {
            background-color: var(--dark-primary-bg)
        }

        body.light .toolbar-section-content .form-control {
            background-color: white
        }

        .toolbar-section-content .btn {
            margin-right: 10px;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }


        .toolbar-col {
            display: flex;
            align-items: center;
            /* Alinea verticalmente el contenido dentro de cada columna */
            gap: 5px;
            /* Espacio entre el label y el select/button */
        }

        /* Estilos para la tabla */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            flex-grow: 1;
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .data-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .data-table tr:hover {
            background-color: #f1f1f1;
        }

        /* Estilos para los botones de acción */
        .btn-action {
            margin: 0 5px;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .btn-action svg {
            vertical-align: middle;
        }

        /* Estilos para los badges de estado */
        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            display: inline-block;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }

        .badge-primary {
            background-color: #007bff;
            color: #fff;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #fff;
        }

        /* Estilos para el contenedor de la tabla */
        .table-responsive {
            flex-grow: 1;
            overflow: auto;
        }
    </style>

@endsection
