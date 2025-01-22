<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\InduccionController;

// routes/web.php
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::controller(InduccionController::class)->group(function () {
    Route::get('induccion', 'index')->name('induccion.video_induccion');
    Route::get('/induccion/encuesta_induccion', 'index_encuesta')->name('induccion.encuesta_induccion');
    Route::post('induccion/submit_survey', 'submitSurvey')->name('induccion.submit_survey');
});


Route::get('/services', function () {
    return view('services');
});

Route::get('/inicio', function () {
    return view('inicio');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/', function () {
    return view('inicio');
});

Route::controller(ChatController::class)->group(function () {
    Route::post('chatbot/messages', 'getResponse')->name('chatbot.messages');
});
