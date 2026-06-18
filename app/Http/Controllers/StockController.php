<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\StockTransfer;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $visibleStoreIds = $this->visibleStoreIds();
        $stores = Store::query()
            ->whereIn('id', $visibleStoreIds)
            ->orderBy('name')
            ->get();
        $allStores = Store::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $selectedStoreId = $request->filled('store_id')
            ? $this->ensureVisibleStore($request->integer('store_id'))
            : null;
        $displayStoreIds = $selectedStoreId ? [$selectedStoreId] : $visibleStoreIds;
        $isAllStoresView = $selectedStoreId === null && $this->currentUser()->canAccessAllStores();

        $displayStores = $stores->whereIn('id', $displayStoreIds)->values();

        $products = Product::query()
            ->active()
            ->with(['stocks' => fn ($query) => $query->whereIn('store_id', $displayStoreIds)])
            ->whereHas('stocks', fn ($query) => $query->whereIn('store_id', $displayStoreIds))
            ->orderBy('name')
            ->get();

        $summary = [
            'total_stock' => Stock::query()->whereIn('store_id', $displayStoreIds)->sum('current_stock'),
            'incoming_pending' => StockTransfer::query()->whereIn('to_store_id', $displayStoreIds)->where('status', 'pending')->count(),
            'outgoing_pending' => StockTransfer::query()->whereIn('from_store_id', $displayStoreIds)->where('status', 'pending')->count(),
            'low_stock' => Stock::query()->whereIn('store_id', $displayStoreIds)->whereColumn('current_stock', '<=', 'minimum_stock')->count(),
        ];

        $incomingTransfers = StockTransfer::query()
            ->with(['fromStore', 'toStore', 'product'])
            ->whereIn('to_store_id', $displayStoreIds)
            ->where('status', 'pending')
            ->latest('transfer_date')
            ->get();

        $outgoingTransfers = StockTransfer::query()
            ->with(['fromStore', 'toStore', 'product'])
            ->whereIn('from_store_id', $displayStoreIds)
            ->latest('transfer_date')
            ->limit(5)
            ->get();

        $transfers = collect();

        if ($isAllStoresView) {
            $transfers = StockTransfer::query()
                ->with(['fromStore', 'toStore', 'product'])
                ->where(function ($query) use ($displayStoreIds) {
                    $query->whereIn('from_store_id', $displayStoreIds)
                        ->orWhereIn('to_store_id', $displayStoreIds);
                })
                ->latest('transfer_date')
                ->latest('id')
                ->get();
        }

        return view('pages.stok', compact(
            'stores',
            'allStores',
            'displayStores',
            'products',
            'summary',
            'isAllStoresView',
            'transfers',
            'incomingTransfers',
            'outgoingTransfers'
        ));
    }

    public function storeTransfer(Request $request)
    {
        $validated = $request->validate([
            'from_store_id' => ['nullable', 'exists:stores,id'],
            'to_store_id' => ['required', 'exists:stores,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($this->currentUser()->canAccessAllStores() && empty($validated['from_store_id'])) {
            throw ValidationException::withMessages([
                'from_store_id' => 'Cabang asal wajib dipilih.',
            ]);
        }

        $fromStoreId = $this->currentUser()->canAccessAllStores()
            ? $this->ensureVisibleStore((int) $validated['from_store_id'])
            : $this->ensureVisibleStore((int) $this->currentUser()->store_id);
        $toStoreId = (int) $validated['to_store_id'];

        if ($fromStoreId === $toStoreId) {
            throw ValidationException::withMessages([
                'to_store_id' => 'Cabang tujuan harus berbeda dari cabang asal.',
            ]);
        }

        DB::transaction(function () use ($validated, $fromStoreId, $toStoreId) {
            $sourceStock = Stock::query()
                ->where('store_id', $fromStoreId)
                ->where('product_id', $validated['product_id'])
                ->lockForUpdate()
                ->first();

            if (! $sourceStock || $sourceStock->current_stock < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok cabang asal tidak cukup untuk dikirim.',
                ]);
            }

            $beforeStock = $sourceStock->current_stock;
            $afterStock = $beforeStock - $validated['quantity'];

            $transfer = StockTransfer::create([
                'transfer_code' => $this->generateTransferCode(),
                'from_store_id' => $fromStoreId,
                'to_store_id' => $toStoreId,
                'product_id' => $validated['product_id'],
                'requested_by' => $this->currentUser()->id,
                'quantity' => $validated['quantity'],
                'status' => 'pending',
                'transfer_date' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);

            $sourceStock->update([
                'current_stock' => $afterStock,
                'last_updated_at' => now(),
            ]);

            StockMovement::create([
                'store_id' => $fromStoreId,
                'product_id' => $validated['product_id'],
                'user_id' => $this->currentUser()->id,
                'type' => 'transfer_out',
                'quantity' => $validated['quantity'],
                'before_stock' => $beforeStock,
                'after_stock' => $afterStock,
                'movement_date' => now(),
                'reference_type' => StockTransfer::class,
                'reference_id' => $transfer->id,
                'notes' => 'Pengiriman stok antar cabang',
            ]);
        });

        return redirect()->route('stok')->with('success', 'Transfer stok berhasil dibuat dan menunggu konfirmasi cabang tujuan.');
    }

    public function confirmTransfer(StockTransfer $stockTransfer)
    {
        if ($this->currentUser()->canAccessAllStores()) {
            return redirect()->route('stok')->with('success', 'Owner hanya dapat melihat data pengiriman stok.');
        }

        $this->ensureVisibleStore($stockTransfer->to_store_id);

        if ($stockTransfer->status !== 'pending') {
            return redirect()->route('stok')->with('success', 'Transfer stok sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($stockTransfer) {
            $destinationStock = Stock::query()->firstOrCreate(
                [
                    'store_id' => $stockTransfer->to_store_id,
                    'product_id' => $stockTransfer->product_id,
                ],
                [
                    'current_stock' => 0,
                    'minimum_stock' => $stockTransfer->product->minimum_stock,
                    'last_updated_at' => now(),
                ]
            );

            $destinationStock->refresh();
            $beforeStock = $destinationStock->current_stock;
            $afterStock = $beforeStock + $stockTransfer->quantity;

            $destinationStock->update([
                'current_stock' => $afterStock,
                'last_updated_at' => now(),
            ]);

            $stockTransfer->update([
                'status' => 'confirmed',
                'confirmed_by' => $this->currentUser()->id,
                'confirmed_at' => now(),
            ]);

            StockMovement::create([
                'store_id' => $stockTransfer->to_store_id,
                'product_id' => $stockTransfer->product_id,
                'user_id' => $this->currentUser()->id,
                'type' => 'transfer_in',
                'quantity' => $stockTransfer->quantity,
                'before_stock' => $beforeStock,
                'after_stock' => $afterStock,
                'movement_date' => now(),
                'reference_type' => StockTransfer::class,
                'reference_id' => $stockTransfer->id,
                'notes' => 'Konfirmasi penerimaan transfer stok',
            ]);
        });

        return redirect()->route('stok')->with('success', 'Transfer stok berhasil dikonfirmasi.');
    }

    private function generateTransferCode(): string
    {
        return 'TRF-'.now()->format('Ymd-His').'-'.random_int(100, 999);
    }
}