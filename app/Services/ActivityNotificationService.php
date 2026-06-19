<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\ActivityNotification;
use Illuminate\Support\Facades\Notification;

class ActivityNotificationService
{
    /**
     * Kirim kepada seluruh owner aktif dan manager aktif di cabang terkait.
     *
     * @param  array<int, int|string>  $storeIds
     */
    public function send(
        array $storeIds,
        string $category,
        string $title,
        string $message,
        string $url,
        array $meta = [],
    ): void {
        $storeIds = collect($storeIds)
            ->filter(fn ($storeId) => is_numeric($storeId))
            ->map(fn ($storeId) => (int) $storeId)
            ->unique()
            ->values()
            ->all();

        $recipients = User::query()
            ->where('status', 'active')
            ->where(function ($query) use ($storeIds) {
                $query->whereHas('roles', fn ($roleQuery) => $roleQuery->where('name', 'owner'));

                if ($storeIds !== []) {
                    $query->orWhere(function ($managerQuery) use ($storeIds) {
                        $managerQuery
                            ->whereIn('store_id', $storeIds)
                            ->whereHas('roles', fn ($roleQuery) => $roleQuery->where('name', 'store_manager'));
                    });
                }
            })
            ->get();

        if ($recipients->isEmpty()) {
            return;
        }

        // Notifikasi aplikasi tetap tersimpan walaupun layanan SMTP sedang bermasalah.
        Notification::send($recipients, new ActivityNotification(
            $category,
            $title,
            $message,
            $url,
            $meta,
            ['database'],
        ));

        try {
            Notification::send($recipients, new ActivityNotification(
                $category,
                $title,
                $message,
                $url,
                $meta,
                ['mail'],
            ));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
