<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\InduccionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElearningController;

// routes/web.php
Route::controller(ElearningController::class)->group(function () {
    Route::get('elearning/cursos', 'index')->name('elearning.cursos');
});

Route::controller(InduccionController::class)->group(function () {
    Route::get('induccion', 'index')->name('induccion.video_induccion');
    Route::get('induccion/encuesta_induccion', 'index_encuesta')->name('induccion.encuesta_induccion');
    Route::post('induccion/submit_survey', 'submitSurvey')->name('induccion.submit_survey');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('auth/validate_user', 'auth')->name('auth.validate_user');
});


Route::get('/services', function () {
    return view('services');
});

Route::get('/inicio', function () {
    return view('inicio');
});




Route::get('/', function () {
    return view('inicio');
});

Route::controller(ChatController::class)->group(function () {
    Route::post('chatbot/messages', 'getResponse')->name('chatbot.messages');
});
