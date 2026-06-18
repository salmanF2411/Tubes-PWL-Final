<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            StoreSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            UserSeeder::class,
            TransactionSeeder::class,
            TransactionItemSeeder::class,
            StockTransferSeeder::class,
            StockMovementSeeder::class,
        ]);
    }
}