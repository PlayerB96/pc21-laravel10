<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<x-modal id="modalInsertPS" title="Registrar Papeleta" actionButton="Guardar" secondButton="Cancelar" extraClass="wide-modal">
    <div class="wide-content">
        <form id="formulario_papeletas_salida_registro" method="POST"
            action="{{ url('Papeletas/Insert_or_Update_Papeletas_Salida') }}">
            <div class="papeletas_salida_card">
                <div class="form-container">
                    <div class="form-group">
                        <label class="control-label">Motivo de Salida:</label>
                        <div style="display: flex;">
                            <label class="radio-label">
                                <input type="radio" name="id_motivo" value="1" id="cambiar_motivo_laboral">
                                Laboral
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="id_motivo" value="2" id="cambiar_motivo_personal">
                                Personal
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Fecha de Solicitud:</label>
                        <input type="date" class="form-control" id="fec_solicitud" name="fec_solicitud">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Destino:</label>
                        <select class="form-control" id="destino" name="destino">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Especifique:</label>
                        <input type="text" class="form-control" id="especificacion_destino"
                            name="especificacion_destino" placeholder="Especifique destino">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Trámite:</label>
                        <select class="form-control" id="tramite" name="tramite">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Especifique:</label>
                        <input type="text" class="form-control" id="especificacion_tramite"
                            name="especificacion_tramite" placeholder="Especifique trámite">
                    </div>
                    <div class="form-group">
                        <div class="n-chk">

                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                <input type="checkbox" class="new-control-input" id="sin_retorno" name="sin_retorno"
                                    value="1">
                                <span class="new-control-indicator"></span>&nbsp;&nbsp;Sin retorno
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="n-chk">
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                <input type="checkbox" class="new-control-input" id="sin_ingreso" name="sin_ingreso"
                                    value="1">
                                <span class="new-control-indicator"></span>&nbsp;&nbsp;Sin ingreso
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Hora Salida:</label>
                        <input type="time" class="form-control" id="hora_salida" name="hora_salida"
                            placeholder="Ingresar hora de salida">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Hora Retorno:</label>
                        <input type="time" class="form-control" id="hora_retorno" name="hora_retorno"
                            placeholder="Ingresar hora de retorno">
                    </div>
                </div>
            </div>
        </form>

    </div>

</x-modal>

<script src="{{ asset('js/gestionpersonas/modal_insert.js') }}"></script>

<style scoped>
    .wide-content {
        padding: 20px;
    }

    .form-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }


    .control-label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .radio-label {
        display: inline-flex;
        align-items: center;
        margin-right: 15px;
        /* Espacio entre los radios */
    }

    .radio-label input {
        margin-right: 5px;
        /* Espacio entre el radio button y el texto */
    }

    .radio-label,
    .checkbox-label {
        margin-right: 5px;
        text-align: center;
    }

    .papeletas_salida_card .form-container .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 0.2rem;
    }

    select.form-control {
        height: auto;
    }

    input[type="date"],
    input[type="time"],
    input[type="text"] {
        border-bottom: 2px dashed #acb0c3;
        border-radius: 0;
        padding-bottom: 0;
    }

    input[type="checkbox"],
    input[type="radio"] {
        margin-right: 5px;
    }

    .form-group .form-control {
        width: 100%;
    }

    @media (max-width: 768px) {
        .form-container {
            grid-template-columns: 1fr 1fr;
        }

        .form-group {
            flex: 1 1 100%;
        }
    }
</style>
