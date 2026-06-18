<?php

namespace Database\Seeders;

use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (MinimarketSeedData::rolePermissions() as $roleName => $permissions) {
            Role::firstOrCreate(['name' => $roleName])
                ->syncPermissions($permissions);
        }
    }
}