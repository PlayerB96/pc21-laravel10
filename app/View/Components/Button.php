<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $text;
    public $route;
    public $style;
    public $action;  // Acción a ejecutar
    public $id;      // ID único del botón
    public $icon;    // Icono SVG opcional

    public function __construct($text = 'Button', $route = '#', $style = 'bg-blue-500 text-white', $action = null, $id = null, $icon = null)
    {
        $this->text = $text;
        $this->route = $route;
        $this->style = $style;
        $this->action = $action;
        $this->id = $id ?? 'btn-' . uniqid(); // Si no se pasa un ID, genera uno único
        $this->icon = $icon; // Asigna el icono si se pasa
    }

    public function render()
    {
        return view('components.button');
    }
}
