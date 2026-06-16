@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-file-lines text-blue-600 mr-2"></i>Laporan Transaksi
    </h1>
    <p class="text-slate-500 text-sm mt-1">Laporan rincian penjualan di semua cabang</p>
</div>

<form action="#" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Filter Laporan</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="store_id" class="block text-sm font-medium text-slate-700 mb-2">Cabang</label>
            <select id="store_id" name="store_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Cabang</option>
                <option value="1">Cabang Cianjur</option>
                <option value="2">Cabang Bandung</option>
                <option value="3">Cabang Bogor</option>
                <option value="4">Cabang Sukabumi</option>
                <option value="5">Cabang Jakarta</option>
            </select>
        </div>

        <div>
            <label for="tanggal_mulai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="tanggal_akhir" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Akhir</label>
            <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="flex items-end">
            <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                <i class="fa-solid fa-search"></i>
                Filter
            </button>
        </div>
    </div>
</form>

<div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
    <div class="text-sm text-slate-600">
        Menampilkan <span class="font-semibold">5</span> transaksi
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="#" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-emerald-600 text-white hover:bg-emerald-700">
            <i class="fa-solid fa-file-excel"></i>
            Excel
        </a>
        <a href="#" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-red-600 text-white hover:bg-red-700">
            <i class="fa-solid fa-file-pdf"></i>
            PDF
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h3 class="text-lg font-semibold text-slate-800">Data Laporan Transaksi</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">ID Transaksi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Kasir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Cabang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-slate-200">
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-sm">1</td>
                    <td class="px-6 py-4 font-medium">INV-001</td>
                    <td class="px-6 py-4">Siti Aminah</td>
                    <td class="px-6 py-4">Cianjur</td>
                    <td class="px-6 py-4">2026-06-14</td>
                    <td class="px-6 py-4 font-semibold text-green-600">Rp 245.000</td>
                    <td class="px-6 py-4">Tunai</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Berhasil
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-sm">2</td>
                    <td class="px-6 py-4 font-medium">INV-002</td>
                    <td class="px-6 py-4">Rizki Maulana</td>
                    <td class="px-6 py-4">Bandung</td>
                    <td class="px-6 py-4">2026-06-14</td>
                    <td class="px-6 py-4 font-semibold text-green-600">Rp 178.500</td>
                    <td class="px-6 py-4">QRIS</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Berhasil
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-sm">3</td>
                    <td class="px-6 py-4 font-medium">INV-003</td>
                    <td class="px-6 py-4">Dewi Lestari</td>
                    <td class="px-6 py-4">Bogor</td>
                    <td class="px-6 py-4">2026-06-15</td>
                    <td class="px-6 py-4 font-semibold text-green-600">Rp 312.000</td>
                    <td class="px-6 py-4">Transfer</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                            Diproses
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-sm">4</td>
                    <td class="px-6 py-4 font-medium">INV-004</td>
                    <td class="px-6 py-4">Andi Saputra</td>
                    <td class="px-6 py-4">Sukabumi</td>
                    <td class="px-6 py-4">2026-06-15</td>
                    <td class="px-6 py-4 font-semibold text-green-600">Rp 96.000</td>
                    <td class="px-6 py-4">Debit</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Berhasil
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-sm">5</td>
                    <td class="px-6 py-4 font-medium">INV-005</td>
                    <td class="px-6 py-4">Siti Aminah</td>
                    <td class="px-6 py-4">Jakarta</td>
                    <td class="px-6 py-4">2026-06-16</td>
                    <td class="px-6 py-4 font-semibold text-green-600">Rp 425.000</td>
                    <td class="px-6 py-4">Tunai</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                            Dibatalkan
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection