@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-chart-bar text-blue-600 mr-2"></i>Laporan Stok
    </h1>
    <p class="text-slate-500 text-sm mt-1">Laporan stok barang di semua cabang</p>
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
        Menampilkan <span class="font-semibold">5</span> data stok
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
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">PRD001</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Minyak Goreng Premium</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Sembako</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Cianjur</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">40</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">20</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">15</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">45</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Stok Aman
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">2</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">PRD002</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Beras Premium 5kg</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Sembako</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Bandung</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">20</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">10</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">18</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">12</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                            Hampir Habis
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">PRD003</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Gula Pasir 1kg</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Sembako</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Bogor</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">30</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">15</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">11</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">34</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Stok Aman
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">4</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">PRD004</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Teh Celup Melati</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Minuman</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Sukabumi</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">18</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">8</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">12</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">14</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                            Hampir Habis
                        </span>
                    </td>
                </tr>

                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">5</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">PRD005</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Susu UHT Coklat</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Minuman</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Jakarta</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">10</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">0</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">10</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">0</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                            Habis
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection