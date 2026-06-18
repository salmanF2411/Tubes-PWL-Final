<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::query()->get()->keyBy('code');

        $owner = User::updateOrCreate(
            ['email' => 'owner@minimarket.test'],
            [
                'store_id' => null,
                'name' => 'Pak Jayusman (Owner)',
                'phone' => '0812-1000-0001',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );
        $owner->syncRoles(['owner']);

        $users = [
            ['store' => 'CBG-JKT', 'role' => 'store_manager', 'name' => 'Budi Santoso', 'email' => 'manager.jakarta@minimarket.test', 'phone' => '0812-2000-0001'],
            ['store' => 'CBG-BDG', 'role' => 'store_manager', 'name' => 'Siti Nurhaliza', 'email' => 'manager.bandung@minimarket.test', 'phone' => '0812-2000-0002'],
            ['store' => 'CBG-SBY', 'role' => 'store_manager', 'name' => 'Ahmad Wijaya', 'email' => 'manager.surabaya@minimarket.test', 'phone' => '0812-2000-0003'],
            ['store' => 'CBG-MDN', 'role' => 'store_manager', 'name' => 'Dewi Lestari', 'email' => 'manager.medan@minimarket.test', 'phone' => '0812-2000-0004'],
            ['store' => 'CBG-MKS', 'role' => 'store_manager', 'name' => 'Rina Kurnia', 'email' => 'manager.makassar@minimarket.test', 'phone' => '0812-2000-0005'],

            ['store' => 'CBG-JKT', 'role' => 'supervisor', 'name' => 'Andi Pratama', 'email' => 'supervisor.jakarta@minimarket.test', 'phone' => '0812-3000-0001'],
            ['store' => 'CBG-BDG', 'role' => 'supervisor', 'name' => 'Maya Putri', 'email' => 'supervisor.bandung@minimarket.test', 'phone' => '0812-3000-0002'],
            ['store' => 'CBG-SBY', 'role' => 'supervisor', 'name' => 'Fajar Nugroho', 'email' => 'supervisor.surabaya@minimarket.test', 'phone' => '0812-3000-0003'],
            ['store' => 'CBG-MDN', 'role' => 'supervisor', 'name' => 'Nadia Safitri', 'email' => 'supervisor.medan@minimarket.test', 'phone' => '0812-3000-0004'],
            ['store' => 'CBG-MKS', 'role' => 'supervisor', 'name' => 'Reza Firmansyah', 'email' => 'supervisor.makassar@minimarket.test', 'phone' => '0812-3000-0005'],

            ['store' => 'CBG-JKT', 'role' => 'cashier', 'name' => 'Dian Permata', 'email' => 'cashier.jakarta@minimarket.test', 'phone' => '0812-4000-0001'],
            ['store' => 'CBG-BDG', 'role' => 'cashier', 'name' => 'Rizki Hidayat', 'email' => 'cashier.bandung@minimarket.test', 'phone' => '0812-4000-0002'],
            ['store' => 'CBG-SBY', 'role' => 'cashier', 'name' => 'Lina Marlina', 'email' => 'cashier.surabaya@minimarket.test', 'phone' => '0812-4000-0003'],
            ['store' => 'CBG-MDN', 'role' => 'cashier', 'name' => 'Yoga Saputra', 'email' => 'cashier.medan@minimarket.test', 'phone' => '0812-4000-0004'],
            ['store' => 'CBG-MKS', 'role' => 'cashier', 'name' => 'Intan Sari', 'email' => 'cashier.makassar@minimarket.test', 'phone' => '0812-4000-0005'],

            ['store' => 'CBG-JKT', 'role' => 'warehouse_staff', 'name' => 'Hendra Gunawan', 'email' => 'gudang.jakarta@minimarket.test', 'phone' => '0812-5000-0001'],
            ['store' => 'CBG-BDG', 'role' => 'warehouse_staff', 'name' => 'Sri Wahyuni', 'email' => 'gudang.bandung@minimarket.test', 'phone' => '0812-5000-0002'],
            ['store' => 'CBG-SBY', 'role' => 'warehouse_staff', 'name' => 'Taufik Ramadhan', 'email' => 'gudang.surabaya@minimarket.test', 'phone' => '0812-5000-0003'],
            ['store' => 'CBG-MDN', 'role' => 'warehouse_staff', 'name' => 'Putri Amelia', 'email' => 'gudang.medan@minimarket.test', 'phone' => '0812-5000-0004'],
            ['store' => 'CBG-MKS', 'role' => 'warehouse_staff', 'name' => 'Ilham Maulana', 'email' => 'gudang.makassar@minimarket.test', 'phone' => '0812-5000-0005'],
        ];

        foreach ($users as $seed) {
            $user = User::updateOrCreate(
                ['email' => $seed['email']],
                [
                    'store_id' => $stores[$seed['store']]->id,
                    'name' => $seed['name'],
                    'phone' => $seed['phone'],
                    'password' => Hash::make('password'),
                    'status' => 'active',
                ]
            );

            $user->syncRoles([$seed['role']]);
        }

        User::query()
            ->whereIn('email', [
                'manager@minimarket.test',
                'supervisor@minimarket.test',
                'cashier@minimarket.test',
                'warehouse@minimarket.test',
            ])
            ->update(['status' => 'inactive']);
    }
}