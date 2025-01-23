<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SkeletonLoader extends Component
{
    public $type;
    public $count;

    public function __construct($type = 'div', $count = 1)
    {
        $this->type = $type;
        $this->count = $count;
    }

    public function render()
    {
        return view('components.skeleton-loader');
    }
}
