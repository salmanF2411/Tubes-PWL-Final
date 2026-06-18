<?php

namespace Database\Seeders;

use App\Models\Store;
use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (MinimarketSeedData::stores() as $store) {
            Store::updateOrCreate(
                ['code' => $store['code']],
                $store + ['is_active' => true]
            );
        }
    }
}