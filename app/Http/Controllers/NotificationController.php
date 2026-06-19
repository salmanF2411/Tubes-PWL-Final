<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = $this->currentUser()
            ->notifications()
            ->latest()
            ->paginate(12);

        return view('pages.notifikasi', compact('notifications'));
    }

    public function open(string $notification): RedirectResponse
    {
        $notification = $this->findForCurrentUser($notification);
        $notification->markAsRead();
        $url = $notification->data['url'] ?? null;

        if (! is_string($url) || ! Str::startsWith($url, '/') || Str::startsWith($url, '//')) {
            $url = route('notifikasi.index');
        }

        return redirect()->to($url);
    }

    public function markAsRead(string $notification): RedirectResponse
    {
        $this->findForCurrentUser($notification)->markAsRead();

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead(): RedirectResponse
    {
        $this->currentUser()->unreadNotifications->markAsRead();

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    private function findForCurrentUser(string $notification): DatabaseNotification
    {
        return $this->currentUser()
            ->notifications()
            ->findOrFail($notification);
    }
}
