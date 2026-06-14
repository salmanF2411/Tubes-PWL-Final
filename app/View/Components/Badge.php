<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public $type;
    public function __construct($type = 'neutral')
    {
        $this->type = $type;
    }

    public function getColor()
    {
        return [
            'success' => 'bg-green-100 text-green-800',
            'warning' => 'bg-yellow-100 text-yellow-800',
            'danger' => 'bg-red-100 text-red-800',
            'info' => 'bg-blue-100 text-blue-800',
            'neutral' => 'bg-slate-100 text-slate-800',
        ][$this->type] ?? 'bg-slate-100 text-slate-800';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge');
    }
}
