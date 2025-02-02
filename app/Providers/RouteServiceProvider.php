<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * El namespace para las rutas de la aplicación.
     *
     * @var string
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Registra los servicios de las rutas.
     *
     * @return void
     */
    public function boot()
    {
        $this->map();
    }

    /**
     * Mapea las rutas de la aplicación.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * Mapea las rutas de la API.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
