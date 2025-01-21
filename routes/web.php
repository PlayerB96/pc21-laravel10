<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

// routes/web.php
Route::get('/home', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
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
