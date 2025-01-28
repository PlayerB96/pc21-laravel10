<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $title;
    public $actionButton;
    public $secondButton; // Nueva propiedad
    public $extraClass;

    /**
     * Crear una nueva instancia del componente.
     *
     * @param string $id
     * @param string $title
     * @param string $actionButton
     * @param string|null $secondButton
     * @param string|null $extraClass
     */
    public function __construct($id, $title, $actionButton = null, $secondButton = null, $extraClass = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->actionButton = $actionButton;
        $this->secondButton = $secondButton; // Asignación de segundo botón
        $this->extraClass = $extraClass;
    }

    /**
     * Obtener la vista / contenido que representa el componente.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
