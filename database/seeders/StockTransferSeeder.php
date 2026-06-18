<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockTransfer;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;

class StockTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::query()->get()->keyBy('code');
        $products = Product::query()->get()->keyBy('code');
        $requester = User::role('warehouse_staff')->first();
        $confirmer = User::role('store_manager')->first();

        foreach (MinimarketSeedData::stockTransfers() as $seed) {
            StockTransfer::updateOrCreate(
                ['transfer_code' => $seed['code']],
                [
                    'from_store_id' => $stores[$seed['from']]->id,
                    'to_store_id' => $stores[$seed['to']]->id,
                    'product_id' => $products[$seed['product']]->id,
                    'requested_by' => $requester?->id,
                    'confirmed_by' => $seed['status'] === 'confirmed' ? $confirmer?->id : null,
                    'quantity' => $seed['qty'],
                    'status' => $seed['status'],
                    'transfer_date' => Carbon::parse($seed['date']),
                    'confirmed_at' => $seed['status'] === 'confirmed' ? Carbon::parse($seed['date'])->addHours(2) : null,
                    'notes' => 'Transfer stok data seeder',
                ]
            );
        }
    }
}