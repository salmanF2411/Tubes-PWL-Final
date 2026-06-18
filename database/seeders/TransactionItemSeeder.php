<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Database\Seeders\Support\MinimarketSeedData;
use Illuminate\Database\Seeder;

class TransactionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::query()->get()->keyBy('code');
        $transactions = Transaction::query()->get()->keyBy('invoice_number');

        foreach (MinimarketSeedData::transactions() as $seed) {
            $transaction = $transactions[$seed['invoice']];

            foreach ($seed['items'] as $item) {
                $product = $products[$item['product']];
                $itemSubtotal = $product->selling_price * $item['qty'];

                TransactionItem::updateOrCreate(
                    [
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'quantity' => $item['qty'],
                        'price' => $product->selling_price,
                        'subtotal' => $itemSubtotal,
                    ]
                );
            }
        }
    }
}