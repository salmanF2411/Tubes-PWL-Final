<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Store;
use App\Models\Transaction as SaleTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::query()
            ->whereIn('id', $this->visibleStoreIds())
            ->orderBy('name')
            ->get();

        $selectedStoreId = $this->resolveSelectedStoreId($request, $stores->pluck('id')->all());

        $products = Product::query()
            ->active()
            ->with(['category', 'stocks' => fn ($query) => $query->where('store_id', $selectedStoreId)])
            ->whereHas('stocks', fn ($query) => $query->where('store_id', $selectedStoreId))
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q');
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->get();

        return view('pages.transaksi', compact('stores', 'selectedStoreId', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'quantities' => ['required', 'array'],
            'payment_method' => ['required', 'in:cash,qris,transfer,debit'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $storeId = $this->ensureVisibleStore((int) $validated['store_id']);
        $quantities = collect($validated['quantities'])
            ->map(fn ($quantity) => (int) $quantity)
            ->filter(fn ($quantity) => $quantity > 0);

        if ($quantities->isEmpty()) {
            throw ValidationException::withMessages([
                'quantities' => 'Minimal pilih satu produk untuk transaksi.',
            ]);
        }

        $transaction = DB::transaction(function () use ($quantities, $storeId, $validated) {
            $products = Product::query()
                ->whereIn('id', $quantities->keys())
                ->get()
                ->keyBy('id');

            $subtotal = 0;

            foreach ($quantities as $productId => $quantity) {
                $product = $products->get((int) $productId);
                $stock = Stock::query()
                    ->where('store_id', $storeId)
                    ->where('product_id', $productId)
                    ->lockForUpdate()
                    ->first();

                if (! $product || ! $stock || $stock->current_stock < $quantity) {
                    throw ValidationException::withMessages([
                        'quantities' => 'Stok produk tidak cukup untuk menyelesaikan transaksi.',
                    ]);
                }

                $subtotal += $product->selling_price * $quantity;
            }

            $discountPercent = (float) ($validated['discount'] ?? 0);
            $discount = round($subtotal * ($discountPercent / 100), 2);
            $total = max(0, $subtotal - $discount);
            $paidAmount = (float) ($validated['paid_amount'] ?? $total);

            if ($paidAmount < $total) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Nominal bayar kurang dari total transaksi.',
                ]);
            }

            $transaction = SaleTransaction::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'store_id' => $storeId,
                'cashier_id' => $this->currentUser()->id,
                'transaction_date' => now(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'paid_amount' => $paidAmount,
                'change_amount' => $paidAmount - $total,
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
            ]);

            foreach ($quantities as $productId => $quantity) {
                $product = $products[(int) $productId];
                $stock = Stock::query()
                    ->where('store_id', $storeId)
                    ->where('product_id', $productId)
                    ->lockForUpdate()
                    ->firstOrFail();
                $beforeStock = $stock->current_stock;
                $afterStock = $beforeStock - $quantity;

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->selling_price,
                    'subtotal' => $product->selling_price * $quantity,
                ]);

                $stock->update([
                    'current_stock' => $afterStock,
                    'last_updated_at' => now(),
                ]);

                StockMovement::create([
                    'store_id' => $storeId,
                    'product_id' => $product->id,
                    'user_id' => $this->currentUser()->id,
                    'type' => 'sale',
                    'quantity' => $quantity,
                    'before_stock' => $beforeStock,
                    'after_stock' => $afterStock,
                    'movement_date' => now(),
                    'reference_type' => SaleTransaction::class,
                    'reference_id' => $transaction->id,
                    'notes' => 'Penjualan kasir',
                ]);
            }

            return $transaction;
        });

        return redirect()
            ->route('transaksi', ['store_id' => $storeId])
            ->with('success', 'Transaksi '.$transaction->invoice_number.' berhasil disimpan.');
    }

    private function resolveSelectedStoreId(Request $request, array $visibleStoreIds): ?int
    {
        if ($request->filled('store_id')) {
            return $this->ensureVisibleStore($request->integer('store_id'));
        }

        return $visibleStoreIds[0] ?? null;
    }

    private function generateInvoiceNumber(): string
    {
        return 'TRX-'.now()->format('Ymd-His').'-'.random_int(100, 999);
    }
}