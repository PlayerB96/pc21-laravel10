<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionPersonas;
use App\Http\Controllers\InduccionController;

use App\Http\Controllers\AuthController; // Asegúrate de importar tu controlador
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\UbigeoController;
use App\Http\Controllers\ChatController;

use App\Http\Controllers\WebLn1Controller;
use Illuminate\Session\Middleware\StartSession;



Route::middleware(['api', StartSession::class])->group(function () {
    Route::post('/auth/validate_user', [AuthController::class, 'auth']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    // GESTIÓN PERSONAS: Papeletas de Salida - Registro Colaboradores
    Route::post('/gestionpersonas/buscar_papeletas', [GestionPersonas::class, 'buscar_papeletas']);
    Route::get('/gestionpersonas/cambiar_motivo', [GestionPersonas::class, 'cambiar_motivo']);
    Route::get('/gestionpersonas/traer_tramite', [GestionPersonas::class, 'traer_tramite']);
    Route::post('/gestionpersonas/store',  [GestionPersonas::class, 'store']);
    Route::post('/gestionpersonas/aprobado_papeletas_salida',  [GestionPersonas::class, 'aprobado_papeletas_salida']);
    Route::post('/gestionpersonas/store_colaborador',  [GestionPersonas::class, 'store_colaborador']);
    // Ubigeo
    Route::get('/departamentos', [UbigeoController::class, 'getDepartamentos']);
    Route::get('/anios', [UbigeoController::class, 'getAnio']);
    Route::get('/provincias', [UbigeoController::class, 'getProvincias']);
    Route::get('/distritos', [UbigeoController::class, 'getDistritos']);
    Route::get('/distritos-departamento', [UbigeoController::class, 'getDistritosByDepartamento']);

    // PRODUCCIÓN: Fichas Técnicas
    Route::post('/produccion/buscar_fichas_tecnicas',  [ProduccionController::class, 'buscar_fichas_tecnicas']);
    
    // INDUCCIÓN: Video_induccion - Formulario de Inducción
    Route::get('/induccion/preguntas_induccion',  [InduccionController::class, 'preguntas_induccion']);
    Route::post('/induccion/submit_survey', [InduccionController::class, 'submit_survey']);

    // VERIFICACIÓN DE PERMISOS
    Route::post('/verificar-permisos',  [AuthController::class, 'verificar_permisos']);

    // CHATBOT
    Route::post('/chat_response',  [ChatController::class, 'chat_response']);
    Route::get('/tickets',  [ChatController::class, 'getTickets']);


});

//NUESTRAS TIENDAS - WEB LN1
Route::get('nuestras_tiendas', [WebLn1Controller::class, 'nuestras_tiendas']);
Route::get('modal_nuestras_tiendas/{parametro}', [WebLn1Controller::class, 'modal_nuestras_tiendas']);