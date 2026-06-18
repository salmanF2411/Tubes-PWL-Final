<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\StockTransfer;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;

class StockMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedInitialStockMovements();
        $this->seedSaleStockMovements();
        $this->seedTransferStockMovements();
    }

    private function seedInitialStockMovements(): void
    {
        $stores = Store::query()->get()->keyBy('code');
        $products = Product::query()->get()->keyBy('code');

        foreach (MinimarketSeedData::stockMatrix() as $productCode => $stockByStore) {
            foreach ($stockByStore as $storeCode => $quantity) {
                $stock = Stock::query()
                    ->where('store_id', $stores[$storeCode]->id)
                    ->where('product_id', $products[$productCode]->id)
                    ->first();

                StockMovement::updateOrCreate(
                    [
                        'store_id' => $stores[$storeCode]->id,
                        'product_id' => $products[$productCode]->id,
                        'type' => 'adjustment',
                        'notes' => 'Stok awal seeder',
                    ],
                    [
                        'quantity' => $quantity,
                        'before_stock' => 0,
                        'after_stock' => $stock?->current_stock ?? $quantity,
                        'movement_date' => Carbon::parse('2026-06-01 08:00:00'),
                    ]
                );
            }
        }
    }

    private function seedSaleStockMovements(): void
    {
        $stores = Store::query()->get()->keyBy('code');
        $products = Product::query()->get()->keyBy('code');
        $cashiers = User::role('cashier')->get()->keyBy('store_id');
        $transactions = Transaction::query()->get()->keyBy('invoice_number');

        foreach (MinimarketSeedData::transactions() as $seed) {
            $store = $stores[$seed['store']];
            $transaction = $transactions[$seed['invoice']];

            foreach ($seed['items'] as $item) {
                $product = $products[$item['product']];
                $stock = Stock::query()
                    ->where('store_id', $store->id)
                    ->where('product_id', $product->id)
                    ->first();

                StockMovement::updateOrCreate(
                    [
                        'store_id' => $store->id,
                        'product_id' => $product->id,
                        'type' => 'sale',
                        'reference_type' => Transaction::class,
                        'reference_id' => $transaction->id,
                    ],
                    [
                        'user_id' => $cashiers[$store->id]?->id,
                        'quantity' => $item['qty'],
                        'before_stock' => max(0, ($stock?->current_stock ?? 0) + $item['qty']),
                        'after_stock' => $stock?->current_stock ?? 0,
                        'movement_date' => Carbon::parse($seed['date']),
                        'notes' => 'Penjualan dari data seeder',
                    ]
                );
            }
        }
    }

    private function seedTransferStockMovements(): void
    {
        $stores = Store::query()->get()->keyBy('code');
        $products = Product::query()->get()->keyBy('code');
        $requester = User::role('warehouse_staff')->first();
        $confirmer = User::role('store_manager')->first();
        $transfers = StockTransfer::query()->get()->keyBy('transfer_code');

        foreach (MinimarketSeedData::stockTransfers() as $seed) {
            $transfer = $transfers[$seed['code']];

            StockMovement::updateOrCreate(
                [
                    'store_id' => $stores[$seed['from']]->id,
                    'product_id' => $products[$seed['product']]->id,
                    'type' => 'transfer_out',
                    'reference_type' => StockTransfer::class,
                    'reference_id' => $transfer->id,
                ],
                [
                    'user_id' => $requester?->id,
                    'quantity' => $seed['qty'],
                    'before_stock' => $seed['qty'],
                    'after_stock' => 0,
                    'movement_date' => Carbon::parse($seed['date']),
                    'notes' => 'Pengiriman stok dari seeder',
                ]
            );

            if ($seed['status'] === 'confirmed') {
                StockMovement::updateOrCreate(
                    [
                        'store_id' => $stores[$seed['to']]->id,
                        'product_id' => $products[$seed['product']]->id,
                        'type' => 'transfer_in',
                        'reference_type' => StockTransfer::class,
                        'reference_id' => $transfer->id,
                    ],
                    [
                        'user_id' => $confirmer?->id,
                        'quantity' => $seed['qty'],
                        'before_stock' => 0,
                        'after_stock' => $seed['qty'],
                        'movement_date' => Carbon::parse($seed['date'])->addHours(2),
                        'notes' => 'Penerimaan stok dari seeder',
                    ]
                );
            }
        }
    }
}