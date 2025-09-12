<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $label;
    public $loadingLabel;
    public $icon;

    public function __construct($label, $loadingLabel = 'Loading...', $icon = null)
    {
        $this->label = $label;
        $this->loadingLabel = $loadingLabel;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.button');
    }
}

