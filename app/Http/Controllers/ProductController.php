<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Store;
use App\Services\ActivityNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function __construct(private readonly ActivityNotificationService $activityNotifications) {}

    public function index(Request $request)
    {
        $storeIds = $this->visibleStoreIds();
        $selectedStoreId = $request->filled('store_id')
            ? $this->ensureVisibleStore($request->integer('store_id'))
            : null;
        $stockStoreIds = $selectedStoreId ? [$selectedStoreId] : $storeIds;

        $products = Product::query()
            ->with(['category', 'stocks' => fn ($query) => $query->whereIn('store_id', $stockStoreIds)->with('store')])
            ->withSum(['stocks as total_stock' => fn ($query) => $query->whereIn('store_id', $stockStoreIds)], 'current_stock')
            ->when($selectedStoreId, fn ($query) => $query->whereHas('stocks', fn ($query) => $query->where('store_id', $selectedStoreId)))
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q');

                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($query) => $query->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('code')
            ->get();

        $categories = Category::query()->orderBy('name')->get();
        $stores = Store::query()
            ->whereIn('id', $storeIds)
            ->orderBy('name')
            ->get();
        $editingProduct = $request->filled('edit')
            ? Product::query()
                ->with(['stocks' => fn ($query) => $query->whereIn('store_id', $storeIds)])
                ->findOrFail($request->integer('edit'))
            : null;
        $editingStock = $editingProduct
            ? $editingProduct->stocks->firstWhere('store_id', $selectedStoreId)
                ?? $editingProduct->stocks->first()
            : null;

        return view('pages.produk', compact('products', 'categories', 'stores', 'selectedStoreId', 'editingProduct', 'editingStock'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        $storeIds = $this->resolveStockStoreIds($validated['stock_store_id']);
        $initialStock = (int) $validated['initial_stock'];
        $productData = $this->productPayload($validated);
        $imagePath = $this->storeProductImage($request);

        if ($imagePath) {
            $productData['image_path'] = $imagePath;
        }

        $product = DB::transaction(function () use ($storeIds, $initialStock, $productData) {
            $product = Product::create($productData + ['is_active' => true]);

            foreach ($storeIds as $storeId) {
                $stock = Stock::create([
                    'store_id' => $storeId,
                    'product_id' => $product->id,
                    'current_stock' => $initialStock,
                    'minimum_stock' => $product->minimum_stock,
                    'last_updated_at' => now(),
                ]);

                if ($initialStock > 0) {
                    StockMovement::create([
                        'store_id' => $storeId,
                        'product_id' => $product->id,
                        'user_id' => $this->currentUser()->id,
                        'type' => 'adjustment',
                        'quantity' => $initialStock,
                        'before_stock' => 0,
                        'after_stock' => $stock->current_stock,
                        'movement_date' => now(),
                        'notes' => 'Stok awal saat tambah produk',
                    ]);
                }
            }

            return $product;
        });

        $storeNames = Store::query()->whereIn('id', $storeIds)->pluck('name')->join(', ');
        $this->activityNotifications->send(
            $storeIds,
            'product',
            'Produk Baru Ditambahkan',
            "Produk {$product->name} ditambahkan di {$storeNames} dengan stok awal {$initialStock} unit.",
            route('produk', absolute: false),
            ['product_id' => $product->id, 'store_ids' => $storeIds],
        );

        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product->id);
        $storeIds = $this->resolveStockStoreIds($validated['stock_store_id']);
        $initialStock = (int) $validated['initial_stock'];
        $productData = $this->productPayload($validated);
        $imagePath = $this->storeProductImage($request);

        if ($imagePath) {
            $productData['image_path'] = $imagePath;
        }

        $stockChanges = DB::transaction(function () use ($product, $storeIds, $initialStock, $productData) {
            $stockChanges = [];
            $product->update($productData);

            foreach ($storeIds as $storeId) {
                $stock = Stock::query()->firstOrCreate(
                    ['store_id' => $storeId, 'product_id' => $product->id],
                    [
                        'current_stock' => 0,
                        'minimum_stock' => $product->minimum_stock,
                        'last_updated_at' => now(),
                    ]
                );
                $beforeStock = $stock->current_stock;

                $stock->update([
                    'current_stock' => $initialStock,
                    'minimum_stock' => $product->minimum_stock,
                    'last_updated_at' => now(),
                ]);

                if ($beforeStock !== $initialStock) {
                    $stockChanges[] = [
                        'store_id' => $storeId,
                        'before' => $beforeStock,
                        'after' => $initialStock,
                    ];

                    StockMovement::create([
                        'store_id' => $storeId,
                        'product_id' => $product->id,
                        'user_id' => $this->currentUser()->id,
                        'type' => 'adjustment',
                        'quantity' => abs($initialStock - $beforeStock),
                        'before_stock' => $beforeStock,
                        'after_stock' => $initialStock,
                        'movement_date' => now(),
                        'notes' => 'Penyesuaian stok dari halaman produk',
                    ]);
                }
            }

            $product->stocks()->update(['minimum_stock' => $product->minimum_stock]);

            return $stockChanges;
        });

        if ($stockChanges === []) {
            $this->activityNotifications->send(
                $storeIds,
                'product',
                'Produk Diperbarui',
                "Data produk {$product->name} berhasil diperbarui.",
                route('produk', absolute: false),
                ['product_id' => $product->id, 'store_ids' => $storeIds],
            );
        }

        foreach ($stockChanges as $change) {
            $store = Store::find($change['store_id']);
            $this->activityNotifications->send(
                [$change['store_id']],
                'stock',
                'Stok Produk Diperbarui',
                "Stok {$product->name} di {$store?->name} berubah dari {$change['before']} menjadi {$change['after']} unit.",
                route('produk', ['store_id' => $change['store_id']], false),
                ['product_id' => $product->id, 'store_id' => $change['store_id']],
            );
        }

        return redirect()->route('produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $storeIds = $product->stocks()->pluck('store_id')->all();
        $product->update(['is_active' => false]);

        $this->activityNotifications->send(
            $storeIds,
            'product',
            'Produk Dinonaktifkan',
            "Produk {$product->name} telah dinonaktifkan oleh {$this->currentUser()->name}.",
            route('produk', absolute: false),
            ['product_id' => $product->id, 'store_ids' => $storeIds],
        );

        return redirect()->route('produk')->with('success', 'Produk berhasil dinonaktifkan.');
    }

    private function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'code' => ['required', 'string', 'max:50', Rule::unique('products', 'code')->ignore($ignoreId)],
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'unit' => ['required', 'string', 'max:50'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'stock_store_id' => ['required'],
            'initial_stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);
    }

    private function productPayload(array $validated): array
    {
        unset($validated['stock_store_id'], $validated['initial_stock'], $validated['image']);

        return $validated;
    }

    private function resolveStockStoreIds(string|int $storeId): array
    {
        $visibleStoreIds = $this->visibleStoreIds();

        if ($storeId === 'all') {
            return $visibleStoreIds;
        }

        if (! is_numeric($storeId)) {
            throw ValidationException::withMessages([
                'stock_store_id' => 'Cabang produk tidak valid.',
            ]);
        }

        return [$this->ensureVisibleStore((int) $storeId)];
    }

    private function storeProductImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');
        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $fileName = ($fileName ?: 'produk').'-'.now()->format('YmdHis').'-'.Str::random(6).'.'.$file->getClientOriginalExtension();

        if (! is_dir(public_path('img'))) {
            mkdir(public_path('img'), 0755, true);
        }

        $file->move(public_path('img'), $fileName);

        return 'img/'.$fileName;
    }
}
