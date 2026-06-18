<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     */
    public $user;
    public $notifCount;
    public function __construct($user = 'Pak Salman Fauzi', $notifCount = 5)
    {
        //
        $this->user = $user;
        $this->notifCount = $notifCount;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}