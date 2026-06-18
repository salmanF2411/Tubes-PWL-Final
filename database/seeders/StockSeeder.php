<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Store;
use Carbon\Carbon;
use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::query()->get()->keyBy('code');
        $products = Product::query()->get()->keyBy('code');

        foreach (MinimarketSeedData::stockMatrix() as $productCode => $stockByStore) {
            foreach ($stockByStore as $storeCode => $quantity) {
                Stock::updateOrCreate(
                    [
                        'store_id' => $stores[$storeCode]->id,
                        'product_id' => $products[$productCode]->id,
                    ],
                    [
                        'current_stock' => $quantity,
                        'minimum_stock' => $products[$productCode]->minimum_stock,
                        'last_updated_at' => Carbon::parse('2026-06-11 08:00:00'),
                    ]
                );
            }
        }
    }
}