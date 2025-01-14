<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('inicio');
});
Route::get('/footer/view', function () {
    return view('partials.footer'); // Asegúrate de que este es el archivo Blade correcto para el footer
})->name('footer.view');
