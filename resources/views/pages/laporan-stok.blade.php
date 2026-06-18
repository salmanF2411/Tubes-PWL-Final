@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-chart-bar text-blue-600 mr-2"></i>Laporan Stok
    </h1>
    <p class="text-slate-500 text-sm mt-1">Laporan stok barang di semua cabang</p>
</div>

<form method="GET" action="{{ route('laporan-stok') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Filter Laporan</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="store_id" class="block text-sm font-medium text-slate-700 mb-2">Cabang</label>
            <select id="store_id" name="store_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Cabang</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @selected(request('store_id') == $store->id)>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tanggal_mulai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="tanggal_akhir" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Akhir</label>
            <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex items-end">
            <button type="submit" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                <i class="fa-solid fa-search"></i>
                Filter
            </button>
        </div>
    </div>
</form>

<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <div class="text-sm text-slate-600">
        Menampilkan <span class="font-semibold">{{ $rows->count() }}</span> data stok
    </div>
    @can('export reports')
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('laporan-stok.excel', request()->query()) }}" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-emerald-600 text-white hover:bg-emerald-700">
                <i class="fa-solid fa-file-excel"></i>
                Excel
            </a>
            <a href="{{ route('laporan-stok.pdf', request()->query()) }}" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-red-600 text-white hover:bg-red-700">
                <i class="fa-solid fa-file-pdf"></i>
                PDF
            </a>
        </div>
    @endcan
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h3 class="text-lg font-semibold text-slate-800">Data Stok Barang</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kode Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Cabang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Stok Awal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Masuk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Keluar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Stok Akhir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($rows as $row)
                    @php($stock = $row['stock'])
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $stock->product->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $stock->product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $stock->product->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $stock->store->city }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $row['initial_stock'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $row['incoming'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $row['outgoing'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $row['final_stock'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-badge :type="$stock->badge_type">{{ $stock->status_label }}</x-badge>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-8 text-center text-slate-500">Tidak ada data stok sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection