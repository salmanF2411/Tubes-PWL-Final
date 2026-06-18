<?php

namespace Database\Seeders;

use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        foreach (MinimarketSeedData::permissions() as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}