@extends('layouts.layoutAdminPanel')

@section('content')
@php
    $brandLogo = file_exists(public_path('img/logo_minimarket.jpg'))
        ? 'img/logo_minimarket.jpg'
        : 'img/logo_minimarket.png';
@endphp

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-warehouse text-blue-600 mr-2"></i>Manajemen Stok
    </h1>
    <p class="text-slate-500 text-sm mt-1">Kelola stok barang di semua cabang</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">Total Stok</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($summary['total_stock'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">Unit barang</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-boxes-stacked text-blue-600 text-lg"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">Pengiriman Masuk</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($summary['incoming_pending'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">Menunggu konfirmasi</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-truck text-green-600 text-lg"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">Pengiriman Keluar</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($summary['outgoing_pending'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">Dalam proses</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-truck-loading text-orange-600 text-lg"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">Stok Rendah</p>
                <p class="text-2xl font-bold text-orange-900 mt-1">{{ number_format($summary['low_stock'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">Produk kritis</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-exclamation-triangle text-red-600 text-lg"></i>
            </div>
        </div>
    </div>
</div>

<form method="GET" action="{{ route('stok') }}" class="bg-white rounded-lg border border-slate-200 p-6 mb-8">
    <div class="flex flex-col md:flex-row gap-4 items-start md:items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-slate-700 mb-2">Cabang</label>
            <select name="store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200">
                <option value="">Semua Cabang</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @selected(request('store_id') == $store->id)>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            <i class="fa-solid fa-search"></i>
            Filter
        </button>
    </div>
</form>

<div class="space-y-8">
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-blue-600"></i>Stok Saat Ini per Cabang
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                        @foreach($displayStores as $store)
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">{{ $store->city }}</th>
                        @endforeach
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        @php
                            $stocksByStore = $product->stocks->keyBy('store_id');
                            $total = $product->stocks->sum('current_stock');
                        @endphp
                        <tr class="border-b border-slate-100 hover:bg-blue-50">
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden border">
                                        <img src="{{ asset($product->image_path ?: $brandLogo) }}" alt="{{ $product->name }}" class="w-full h-full object-contain bg-white p-1">
                                    </div>
                                    {{ $product->name }}
                                </div>
                            </td>
                            @foreach($displayStores as $store)
                                @php
                                    $stock = $stocksByStore->get($store->id);
                                    $quantity = (int) ($stock->current_stock ?? 0);
                                    $badgeType = $stock?->badge_type ?? $product->stockBadgeType($quantity);
                                @endphp
                                <td class="px-6 py-4"><x-badge :type="$badgeType">{{ $quantity }}</x-badge></td>
                            @endforeach
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $displayStores->count() + 2 }}" class="px-6 py-8 text-center text-slate-500">Data stok belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($isAllStoresView)
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-truck text-blue-600"></i>Pengiriman
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Dari Cabang</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Ke Cabang</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Qty</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Tanggal</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transfers as $transfer)
                        <tr class="border-b border-slate-100 hover:bg-blue-50">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $transfer->transfer_code }}</td>
                            <td class="px-6 py-4">{{ $transfer->fromStore->name }}</td>
                            <td class="px-6 py-4">{{ $transfer->toStore->name }}</td>
                            <td class="px-6 py-4">{{ $transfer->product->name }}</td>
                            <td class="px-6 py-4 font-bold text-blue-600">{{ $transfer->quantity }}</td>
                            <td class="px-6 py-4">{{ $transfer->transfer_date->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">
                                <x-badge :type="$transfer->badge_type">{{ $transfer->status_label }}</x-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">Tidak ada data pengiriman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-truck text-green-600"></i>Pengiriman Masuk
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Dari Cabang</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Qty</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Tanggal</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incomingTransfers as $transfer)
                        <tr class="border-b border-slate-100 hover:bg-green-50">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $transfer->transfer_code }}</td>
                            <td class="px-6 py-4">{{ $transfer->fromStore->name }}</td>
                            <td class="px-6 py-4">{{ $transfer->product->name }}</td>
                            <td class="px-6 py-4 font-bold text-green-600">{{ $transfer->quantity }}</td>
                            <td class="px-6 py-4">{{ $transfer->transfer_date->format('d-m-Y') }}</td>
                            <td class="px-6 py-4">
                                @if(auth()->user()->canAccessAllStores())
                                    <x-badge type="warning">Menunggu</x-badge>
                                @else
                                    @can('manage stock')
                                    <form method="POST" action="{{ route('stok.transfer.confirm', $transfer) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 rounded-lg transition inline-flex items-center gap-2 text-xs font-medium bg-green-600 text-white hover:bg-green-700">
                                            <i class="fa-solid fa-check"></i>
                                            Konfirmasi
                                        </button>
                                    </form>
                                    @else
                                        <x-badge type="warning">Menunggu</x-badge>
                                    @endcan
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Tidak ada pengiriman masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-truck-loading text-orange-600"></i>Pengiriman Keluar
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Ke Cabang</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Qty</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($outgoingTransfers as $transfer)
                        <tr class="border-b border-slate-100 hover:bg-orange-50">
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $transfer->transfer_code }}</td>
                            <td class="px-6 py-4">{{ $transfer->toStore->name }}</td>
                            <td class="px-6 py-4">{{ $transfer->product->name }}</td>
                            <td class="px-6 py-4 font-bold">{{ $transfer->quantity }}</td>
                            <td class="px-6 py-4">
                                <x-badge :type="$transfer->badge_type">{{ $transfer->status_label }}</x-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada pengiriman keluar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @can('manage stock')
    <div class="bg-white rounded-lg border border-slate-200 p-8">
        <h2 class="font-bold text-slate-900 text-xl mb-6 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-green-600"></i>Kirim Stok
        </h2>
        <form method="POST" action="{{ route('stok.transfer.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @if(auth()->user()->canAccessAllStores())
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Cabang Asal</label>
                        <select name="from_store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                            <option value="">Pilih cabang asal</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cabang Tujuan</label>
                    <select name="to_store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                        <option value="">Pilih cabang tujuan</option>
                        @foreach($allStores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Produk</label>
                    <select name="product_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                        <option value="">Pilih produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah</label>
                    <input type="number" name="quantity" min="1" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-green-400" required>
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan</label>
                <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" placeholder="Alasan penambahan/pemindahan stok..."></textarea>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                    <i class="fa-solid fa-save"></i>
                    Kirim Stok
                </button>
            </div>
        </form>
    </div>
    @endcan
</div>
@endsection