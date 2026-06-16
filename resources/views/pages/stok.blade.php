@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-warehouse text-blue-600 mr-2"></i>
        Manajemen Stok
    </h1>
    <p class="text-slate-500 text-sm mt-1">
        Kelola stok barang di semua cabang
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg p-6 border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-600 text-sm font-medium">Total Stok</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">8.920</p>
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
                <p class="text-2xl font-bold text-slate-900 mt-1">7</p>
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
                <p class="text-2xl font-bold text-slate-900 mt-1">4</p>
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
                <p class="text-2xl font-bold text-orange-900 mt-1">12</p>
                <p class="text-xs text-slate-500 mt-2">Produk kritis</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-exclamation-triangle text-red-600 text-lg"></i>
            </div>
        </div>
    </div>
</div>

<form action="#" class="bg-white rounded-lg border border-slate-200 p-6 mb-8">
    <div class="flex flex-col md:flex-row gap-4 items-start md:items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Cabang
            </label>
            <select name="store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200">
                <option value="">Semua Cabang</option>
                <option value="1">Cabang Cianjur</option>
                <option value="2">Cabang Bandung</option>
                <option value="3">Cabang Bogor</option>
                <option value="4">Cabang Sukabumi</option>
                <option value="5">Cabang Jakarta</option>
            </select>
        </div>

        <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            <i class="fa-solid fa-search"></i>
            Filter
        </button>
    </div>
</form>

<div class="space-y-8">
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-blue-600"></i>
                Stok Saat Ini per Cabang
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Cianjur</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Bandung</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Bogor</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Sukabumi</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Jakarta</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-600">Total</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-200 bg-white">
                                    <img src="/img/logo_minimarket.png" alt="Minyak Goreng Premium" class="w-full h-full object-contain bg-white p-1">
                                </div>
                                Minyak Goreng Premium
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">45</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">38</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">15</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">5</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">25</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">128</td>
                    </tr>

                    <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-200 bg-white">
                                    <img src="/img/logo_minimarket.png" alt="Beras Premium 5kg" class="w-full h-full object-contain bg-white p-1">
                                </div>
                                Beras Premium 5kg
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">8</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">42</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">12</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">30</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">28</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">120</td>
                    </tr>

                    <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-200 bg-white">
                                    <img src="/img/logo_minimarket.png" alt="Gula Pasir 1kg" class="w-full h-full object-contain bg-white p-1">
                                </div>
                                Gula Pasir 1kg
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">16</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">6</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">34</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">29</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">18</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">103</td>
                    </tr>

                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-200 bg-white">
                                    <img src="/img/logo_minimarket.png" alt="Teh Celup Melati" class="w-full h-full object-contain bg-white p-1">
                                </div>
                                Teh Celup Melati
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">33</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">27</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">21</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">14</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">40</span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">135</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h2 class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-truck text-blue-600"></i>
                Pengiriman
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
                    <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">TRF-001</td>
                        <td class="px-6 py-4">Cabang Cianjur</td>
                        <td class="px-6 py-4">Cabang Bandung</td>
                        <td class="px-6 py-4">Minyak Goreng Premium</td>
                        <td class="px-6 py-4 font-bold text-blue-600">20</td>
                        <td class="px-6 py-4">14-06-2026</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                Diproses
                            </span>
                        </td>
                    </tr>

                    <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">TRF-002</td>
                        <td class="px-6 py-4">Cabang Jakarta</td>
                        <td class="px-6 py-4">Cabang Sukabumi</td>
                        <td class="px-6 py-4">Beras Premium 5kg</td>
                        <td class="px-6 py-4 font-bold text-blue-600">15</td>
                        <td class="px-6 py-4">15-06-2026</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Selesai
                            </span>
                        </td>
                    </tr>

                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-900">TRF-003</td>
                        <td class="px-6 py-4">Cabang Bogor</td>
                        <td class="px-6 py-4">Cabang Cianjur</td>
                        <td class="px-6 py-4">Gula Pasir 1kg</td>
                        <td class="px-6 py-4 font-bold text-blue-600">25</td>
                        <td class="px-6 py-4">16-06-2026</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                Tertunda
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-truck text-green-600"></i>
                    Pengiriman Masuk
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">ID</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">Dari</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">Qty</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b border-slate-100 hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">IN-001</td>
                            <td class="px-6 py-4">Cabang Bandung</td>
                            <td class="px-6 py-4">Minyak Goreng Premium</td>
                            <td class="px-6 py-4 font-bold text-green-600">10</td>
                            <td class="px-6 py-4">
                                <button type="button" class="px-3 py-2 rounded-lg transition inline-flex items-center gap-2 text-xs font-medium bg-green-600 text-white hover:bg-green-700">
                                    <i class="fa-solid fa-check"></i>
                                    Konfirmasi
                                </button>
                            </td>
                        </tr>

                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">IN-002</td>
                            <td class="px-6 py-4">Cabang Jakarta</td>
                            <td class="px-6 py-4">Teh Celup Melati</td>
                            <td class="px-6 py-4 font-bold text-green-600">18</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    Menunggu
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-truck-loading text-orange-600"></i>
                    Pengiriman Keluar
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200">
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">ID</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">Ke</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">Qty</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b border-slate-100 hover:bg-orange-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">OUT-001</td>
                            <td class="px-6 py-4">Cabang Cianjur</td>
                            <td class="px-6 py-4">Beras Premium 5kg</td>
                            <td class="px-6 py-4 font-bold text-slate-900">12</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    Diproses
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-orange-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-900">OUT-002</td>
                            <td class="px-6 py-4">Cabang Bogor</td>
                            <td class="px-6 py-4">Gula Pasir 1kg</td>
                            <td class="px-6 py-4 font-bold text-slate-900">20</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Selesai
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-slate-200 p-8">
        <h2 class="font-bold text-slate-900 text-xl mb-6 flex items-center gap-2">
            <i class="fa-solid fa-plus-circle text-green-600"></i>
            Kirim Stok
        </h2>

        <form action="#">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Cabang Asal
                    </label>
                    <select name="from_store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                        <option value="">Pilih cabang asal</option>
                        <option value="1">Cabang Cianjur</option>
                        <option value="2">Cabang Bandung</option>
                        <option value="3">Cabang Bogor</option>
                        <option value="4">Cabang Sukabumi</option>
                        <option value="5">Cabang Jakarta</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Cabang Tujuan
                    </label>
                    <select name="to_store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                        <option value="">Pilih cabang tujuan</option>
                        <option value="1">Cabang Cianjur</option>
                        <option value="2">Cabang Bandung</option>
                        <option value="3">Cabang Bogor</option>
                        <option value="4">Cabang Sukabumi</option>
                        <option value="5">Cabang Jakarta</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Produk
                    </label>
                    <select name="product_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                        <option value="">Pilih produk</option>
                        <option value="1">Minyak Goreng Premium</option>
                        <option value="2">Beras Premium 5kg</option>
                        <option value="3">Gula Pasir 1kg</option>
                        <option value="4">Teh Celup Melati</option>
                        <option value="5">Sabun Mandi Herbal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Jumlah
                    </label>
                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        value="10"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-green-400"
                        required>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Keterangan
                </label>
                <textarea
                    name="notes"
                    rows="3"
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                    placeholder="Alasan penambahan/pemindahan stok...">Pemindahan stok untuk menjaga ketersediaan barang antar cabang.</textarea>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                    <i class="fa-solid fa-save"></i>
                    Kirim Stok
                </button>

                <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200">
                    <i class="fa-solid fa-times"></i>
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection