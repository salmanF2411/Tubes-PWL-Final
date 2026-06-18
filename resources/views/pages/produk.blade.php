@extends('layouts.layoutAdminPanel')

@section('content')
@php
    $brandLogo = file_exists(public_path('img/logo_minimarket.jpg'))
        ? 'img/logo_minimarket.jpg'
        : 'img/logo_minimarket.png';
@endphp

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-box text-blue-600 mr-2"></i>Daftar Produk
    </h1>
    <p class="text-slate-500 text-sm mt-1">Kelola semua produk mini market</p>
</div>

<div class="mb-6 flex items-center justify-between gap-4">
    <form method="GET" action="{{ route('produk') }}" class="flex-1 flex flex-col md:flex-row gap-3">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari produk..."
            class="w-full md:max-w-md px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
        <select name="store_id" class="w-full md:w-64 px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
            <option value="">Semua Cabang</option>
            @foreach($stores as $store)
                <option value="{{ $store->id }}" @selected($selectedStoreId == $store->id)>
                    {{ $store->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 rounded-lg transition inline-flex items-center justify-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            <i class="fa-solid fa-search"></i>
            Filter
        </button>
    </form>
</div>

@canany(['create product', 'edit product'])
<div id="form-produk" class="bg-white rounded-lg border border-slate-200 p-6 mb-8">
    <h2 class="font-bold text-slate-900 mb-4">
        {{ $editingProduct ? 'Edit Produk' : 'Tambah Produk' }}
    </h2>

    @php
        $defaultStockStoreId = old('stock_store_id', $editingProduct ? ($editingStock->store_id ?? $selectedStoreId ?? $stores->first()?->id) : 'all');
        $defaultInitialStock = old('initial_stock', $editingStock->current_stock ?? 0);
    @endphp

    <form
        method="POST"
        action="{{ $editingProduct ? route('produk.update', $editingProduct) : route('produk.store') }}"
        enctype="multipart/form-data"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @csrf
        @if($editingProduct)
            @method('PUT')
        @endif

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Kode</label>
            <input name="code" value="{{ old('code', $editingProduct->code ?? '') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Produk</label>
            <input name="name" value="{{ old('name', $editingProduct->name ?? '') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
            <select name="category_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="">Pilih kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $editingProduct->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Satuan</label>
            <input name="unit" value="{{ old('unit', $editingProduct->unit ?? 'unit') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Harga Beli</label>
            <input type="number" name="purchase_price" min="0" value="{{ old('purchase_price', $editingProduct->purchase_price ?? 0) }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Harga Jual</label>
            <input type="number" name="selling_price" min="0" value="{{ old('selling_price', $editingProduct->selling_price ?? 0) }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Minimum Stok</label>
            <input type="number" name="minimum_stock" min="0" value="{{ old('minimum_stock', $editingProduct->minimum_stock ?? 0) }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Cabang Produk</label>
            <select name="stock_store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="all" @selected($defaultStockStoreId === 'all')>Semua Cabang</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @selected($defaultStockStoreId == $store->id)>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Stok Awal</label>
            <input type="number" name="initial_stock" min="0" value="{{ $defaultInitialStock }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">Gambar Produk</label>
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                    <img
                        id="product-image-preview"
                        src="{{ asset($editingProduct->image_path ?? $brandLogo) }}"
                        alt="Preview produk"
                        class="w-full h-full object-contain bg-white p-1">
                </div>
                <div class="flex-1">
                    <input id="product-image-input" type="file" name="image" accept="image/*" class="hidden">
                    <label for="product-image-input" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 cursor-pointer">
                        <i class="fa-solid fa-image"></i>
                        Pilih Gambar
                    </label>
                    <p id="product-image-name" class="text-xs text-slate-500 mt-2">
                        {{ $editingProduct?->image_path ? basename($editingProduct->image_path) : 'Belum ada file dipilih' }}
                    </p>
                </div>
            </div>
        </div>
        <div class="md:col-span-2 lg:col-span-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">{{ old('description', $editingProduct->description ?? '') }}</textarea>
        </div>
        <div class="md:col-span-2 lg:col-span-4 flex gap-3">
            <button type="submit" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                <i class="fa-solid fa-save"></i>
                Simpan
            </button>
            @if($editingProduct)
                <a href="{{ route('produk') }}" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200">
                    <i class="fa-solid fa-times"></i>
                    Batal
                </a>
            @endif
        </div>
    </form>
</div>
@endcanany

<div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="font-bold text-slate-900">Daftar Produk</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Kode</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Nama Produk</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Gambar</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Kategori</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Cabang</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Harga</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Stok</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    @php
                        $totalStock = (int) ($product->total_stock ?? 0);
                    @endphp
                    <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $product->code }}</td>
                        <td class="px-6 py-4 text-slate-700">{{ $product->name }}</td>
                        <td class="px-6 py-4">
                            <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                                <img src="{{ asset($product->image_path ?: $brandLogo) }}" alt="{{ $product->name }}" class="w-full h-full object-contain bg-white p-1">
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            @if($selectedStoreId)
                                {{ $product->stocks->first()?->store->name ?? '-' }}
                            @else
                                {{ $product->stocks->pluck('store.city')->filter()->join(', ') ?: '-' }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-green-600 font-medium">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <x-badge :type="$product->stockBadgeType($totalStock)">
                                {{ $product->stockLabel($totalStock) }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4">
                            <x-badge :type="$product->is_active ? 'success' : 'danger'">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @can('edit product')
                                    <a href="{{ route('produk', ['edit' => $product->id]) }}#form-produk" class="text-blue-600 hover:text-blue-700" title="Edit">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                @endcan
                                @can('delete product')
                                    <form method="POST" action="{{ route('produk.destroy', $product) }}" onsubmit="return confirm('Nonaktifkan produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-slate-500">Data produk belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    const productImageInput = document.getElementById('product-image-input');
    const productImagePreview = document.getElementById('product-image-preview');
    const productImageName = document.getElementById('product-image-name');

    productImageInput?.addEventListener('change', () => {
        const file = productImageInput.files?.[0];

        if (!file) {
            return;
        }

        productImageName.textContent = file.name;
        productImagePreview.src = URL.createObjectURL(file);
    });
</script>
@endsection