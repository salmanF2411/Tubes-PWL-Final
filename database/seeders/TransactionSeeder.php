<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = Store::query()->get()->keyBy('code');
        $products = Product::query()->get()->keyBy('code');
        $cashiers = User::role('cashier')->get()->keyBy('store_id');

        foreach (MinimarketSeedData::transactions() as $seed) {
            $store = $stores[$seed['store']];
            $subtotal = collect($seed['items'])->sum(function (array $item) use ($products) {
                return $products[$item['product']]->selling_price * $item['qty'];
            });

            Transaction::updateOrCreate(
                ['invoice_number' => $seed['invoice']],
                [
                    'store_id' => $store->id,
                    'cashier_id' => $cashiers[$store->id]?->id,
                    'transaction_date' => Carbon::parse($seed['date']),
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'total' => $subtotal,
                    'paid_amount' => $subtotal,
                    'change_amount' => 0,
                    'payment_method' => $seed['payment'],
                    'status' => 'completed',
                ]
            );
        }
    }
}