<?php

use Illuminate\Support\Facades\Route;

// Redirigir todas las rutas a Vue.js, EXCEPTO las de la API
Route::get('/{any}', function () {
    return view('main'); // Un solo archivo Blade que carga Vue
})->where('any', '^(?!api).*$'); // Esto asegura que las rutas /api no sean redirigidas
