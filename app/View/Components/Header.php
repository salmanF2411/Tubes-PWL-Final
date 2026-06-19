<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $user;

    public $notifCount;

    public $notifications;

    public function __construct($user = 'Pak Salman Fauzi')
    {
        $this->user = $user;

        if (auth()->check()) {
            $this->notifCount = auth()->user()->unreadNotifications()->count();
            $this->notifications = auth()->user()->notifications()->latest()->limit(5)->get();
        } else {
            $this->notifCount = 0;
            $this->notifications = collect();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
