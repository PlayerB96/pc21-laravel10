<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $id;
    public $title;
    public $actionButton;
    public $extraClass;

    /**
     * Create a new component instance.
     *
     * @param string $id
     * @param string $title
     * @param string $actionButton
     * @param string|null $extraClass
     */
    public function __construct($id, $title, $actionButton = 'Guardar', $extraClass = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->actionButton = $actionButton;
        $this->extraClass = $extraClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
