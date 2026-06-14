<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $icon;
    public function __construct($type = 'primary', $icon = null)
    {
        $this->type = $type;
        $this->icon = $icon;
    }

    public function getStyle()
    {
        return [
            'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
            'danger'  => 'bg-red-600 text-white hover:bg-red-700',
            'secondary' => 'bg-green-600 text-white hover:bg-gray-700',
        ][$this->type] ?? 'bg-blue-600 text-white hover:bg-blue-700';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
