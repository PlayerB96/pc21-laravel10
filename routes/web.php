<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\InduccionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElearningController;
use App\Http\Controllers\GestionPersonas;



Route::controller(GestionPersonas::class)->group(function () {
    Route::get('gestionpersonas', 'index')->name('gestionpersonas');
    Route::get('gestionpersonas/registro_papeletas', 'registro_papeletas')->name('gestionpersonas.registro_papeletas');
    Route::post('gestionpersonas/buscar_papeletas', 'buscar_papeletas')->name('gestionpersonas.buscar_papeletas');
    // REGISTRO DE PAPELETAS DE SALIDA
    Route::post('gestionpersonas/cambiar_motivo', 'cambiar_motivo')->name('gestionpersonas.cambiar_motivo');
    Route::post('gestionpersonas/traer_tramite', 'traer_tramite')->name('gestionpersonas.traer_tramite');
    Route::post('gestionpersonas/store', 'store')->name('gestionpersonas.store');
    // REGISTRO DE POSTULANTE
    Route::get('gestionpersonas/registro_postulante', 'index_rpo')->name('gestionpersonas.registro_postulante');
    Route::post('gestionpersonas/store_rpo', 'store_rpo')->name('gestionpersonas.store_rpo');
    Route::post('gestionpersonas/store_rpo', 'store_rpo')->name('gestionpersonas.store_rpo');


});

Route::get('/produccion', function () {
    return view('produccion');
});
Route::get('/empresas', function () {
    return view('empresas');
});
Route::get('/productos', function () {
    return view('productos');
});
Route::get('/blog', function () {

    return view('blog');
});
Route::get('/identidadcorporativa', function () {
    return view('identidadcorporativa');
});
Route::get('/ecommerce', function () {
    return view('ecommerce');
});



Route::get('/inicio', function () {
    return view('inicio');
})->name('inicio');

Route::get('/', function () {
    return view('inicio');
})->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::post('auth/validate_user', 'auth')->name('auth.validate_user');
    Route::post('auth/logout', 'logout')->name('auth.logout');
});

// Rutas públicas

Route::controller(ChatController::class)->group(function () {
    Route::post('chatbot/messages', 'getResponse')->name('chatbot.messages');
});

// Rutas protegidas por el middleware 'checkSession'
// Route::middleware(['checkSession'])->group(function () {
// routes/web.php
Route::controller(ElearningController::class)->group(function () {
    Route::get('elearning/cursos', 'index')->name('elearning.cursos');
});

Route::controller(InduccionController::class)->group(function () {
    Route::get('induccion', 'index')->name('induccion.video_induccion');
    Route::get('induccion/encuesta_induccion', 'index_encuesta')->name('induccion.encuesta_induccion');
    Route::post('induccion/submit_survey', 'submitSurvey')->name('induccion.submit_survey');
});
// });
