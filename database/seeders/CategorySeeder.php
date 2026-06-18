<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (MinimarketSeedData::categories() as $category) {
            Category::updateOrCreate(
                ['code' => $category['code']],
                $category
            );
        }
    }
}