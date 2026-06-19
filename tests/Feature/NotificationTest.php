<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use App\Notifications\ActivityNotification;
use App\Services\ActivityNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_receives_all_store_notifications_and_manager_only_receives_own_store(): void
    {
        foreach (['owner', 'store_manager', 'cashier'] as $role) {
            Role::create(['name' => $role]);
        }

        $jakarta = $this->createStore('JKT');
        $bandung = $this->createStore('BDG');

        $owner = $this->createUser(null, 'owner@example.test', 'owner');
        $jakartaManager = $this->createUser($jakarta->id, 'manager.jakarta@example.test', 'store_manager');
        $bandungManager = $this->createUser($bandung->id, 'manager.bandung@example.test', 'store_manager');
        $cashier = $this->createUser($jakarta->id, 'cashier@example.test', 'cashier');

        app(ActivityNotificationService::class)->send(
            [$jakarta->id],
            'transaction',
            'Transaksi Berhasil',
            'Transaksi pengujian berhasil.',
            '/laporan-transaksi',
        );

        $this->assertSame(1, $owner->notifications()->count());
        $this->assertSame(1, $jakartaManager->notifications()->count());
        $this->assertSame(0, $bandungManager->notifications()->count());
        $this->assertSame(0, $cashier->notifications()->count());
    }

    public function test_user_can_mark_one_or_all_notifications_as_read(): void
    {
        $user = User::factory()->create(['status' => 'active']);

        $user->notify(new ActivityNotification(
            'product',
            'Produk Baru',
            'Produk baru ditambahkan.',
            '/produk',
            channels: ['database'],
        ));
        $user->notify(new ActivityNotification(
            'stock',
            'Stok Diperbarui',
            'Stok berhasil diperbarui.',
            '/stok',
            channels: ['database'],
        ));

        $firstNotification = $user->notifications()->latest()->firstOrFail();

        $this->actingAs($user)
            ->patch(route('notifikasi.read', $firstNotification->id))
            ->assertRedirect();

        $this->assertNotNull($firstNotification->fresh()->read_at);
        $this->assertSame(1, $user->unreadNotifications()->count());

        $this->actingAs($user)
            ->patch(route('notifikasi.read-all'))
            ->assertRedirect();

        $this->assertSame(0, $user->unreadNotifications()->count());
    }

    private function createStore(string $code): Store
    {
        return Store::create([
            'code' => $code,
            'name' => 'Cabang '.$code,
            'city' => $code,
            'address' => 'Alamat '.$code,
            'phone' => '0800000000',
            'is_active' => true,
        ]);
    }

    private function createUser(?int $storeId, string $email, string $role): User
    {
        $user = User::factory()->create([
            'store_id' => $storeId,
            'email' => $email,
            'status' => 'active',
        ]);
        $user->assignRole($role);

        return $user;
    }
}
