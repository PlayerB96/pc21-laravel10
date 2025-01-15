<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    // Definir las propiedades del modal
    public $id;
    public $title;
    public $actionButton;

    /**
     * Create a new component instance.
     *
     * @param string $id
     * @param string $title
     * @param string $actionButton
     */
    public function __construct($id, $title, $actionButton = 'Guardar')
    {
        $this->id = $id;
        $this->title = $title;
        $this->actionButton = $actionButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
