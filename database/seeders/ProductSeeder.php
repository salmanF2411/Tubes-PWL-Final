<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::query()->get()->keyBy('code');

        foreach (MinimarketSeedData::products() as $product) {
            Product::updateOrCreate(
                ['code' => $product['code']],
                [
                    'category_id' => $categories[$product['category']]->id,
                    'name' => $product['name'],
                    'image_path' => $product['image_path'],
                    'unit' => $product['unit'],
                    'purchase_price' => $product['purchase_price'],
                    'selling_price' => $product['selling_price'],
                    'minimum_stock' => $product['minimum_stock'],
                    'is_active' => true,
                ]
            );
        }
    }
}