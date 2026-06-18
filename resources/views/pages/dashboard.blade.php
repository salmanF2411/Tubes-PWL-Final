@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-chart-line text-blue-600 mr-2"></i>
        Dashboard
    </h1>
    <p class="text-slate-500 text-sm mt-1">
        Ringkasan aktivitas minimarket hari ini
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">Total Penjualan</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">Rp {{ number_format($summary['total_sales'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">Bulan ini</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-money-bill-wave text-green-600 text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">Total Transaksi</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($summary['total_transactions'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">Transaksi berhasil</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-receipt text-blue-600 text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">Total Stok</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($summary['total_stock'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">Unit barang</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-boxes-stacked text-orange-600 text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">User Aktif</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($summary['active_users'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-2">Pengguna sistem</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-users text-purple-600 text-lg"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-receipt text-blue-600"></i>Transaksi Terbaru
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Kasir</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Total</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestTransactions as $transaction)
                        <tr class="border-b border-slate-100">
                            <td class="px-6 py-3 font-medium text-slate-900">{{ $transaction->invoice_number }}</td>
                            <td class="px-6 py-3 text-slate-700">{{ $transaction->cashier->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-green-600 font-medium">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">
                                <x-badge :type="$transaction->badge_type">{{ $transaction->status_label }}</x-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @can('view reports')
            <div class="px-6 py-3 border-t border-slate-200 text-center">
                <a href="{{ route('laporan-transaksi') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua &rarr;</a>
            </div>
        @endcan
    </div>

    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-warehouse text-orange-600"></i>Stok Rendah
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Cabang</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Stok</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowStocks as $stock)
                        <tr class="border-b border-slate-100">
                            <td class="px-6 py-3 font-medium text-slate-900">{{ $stock->product->name }}</td>
                            <td class="px-6 py-3 text-slate-700">{{ $stock->store->city }}</td>
                            <td class="px-6 py-3 text-slate-700">{{ $stock->current_stock }}</td>
                            <td class="px-6 py-3">
                                <x-badge :type="$stock->badge_type">{{ $stock->status_label }}</x-badge>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">Tidak ada stok rendah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @can('view reports')
            <div class="px-6 py-3 border-t border-slate-200 text-center">
                <a href="{{ route('laporan-stok') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat semua &rarr;</a>
            </div>
        @endcan
    </div>
</div>
@endsection