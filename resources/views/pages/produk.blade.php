@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-box text-blue-600 mr-2"></i>
        Daftar Produk
    </h1>
    <p class="text-slate-500 text-sm mt-1">
        Kelola semua produk mini market
    </p>
</div>

<div class="mb-6 flex items-center justify-between gap-4">
    <form action="#" class="flex-1 flex flex-col md:flex-row gap-3">
        <input
            type="text"
            name="q"
            placeholder="Cari produk..."
            class="w-full md:max-w-md px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">

        <select name="store_id" class="w-full md:w-64 px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
            <option value="">Semua Cabang</option>
            <option value="1">Cabang Cianjur</option>
            <option value="2">Cabang Bandung</option>
            <option value="3">Cabang Bogor</option>
            <option value="4">Cabang Sukabumi</option>
            <option value="5">Cabang Jakarta</option>
        </select>

        <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center justify-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            <i class="fa-solid fa-search"></i>
            Filter
        </button>
    </form>
</div>

<div id="form-produk" class="bg-white rounded-lg border border-slate-200 p-6 mb-8">
    <h2 class="font-bold text-slate-900 mb-4">
        Tambah Produk
    </h2>

    <form action="#" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Kode
            </label>
            <input
                name="code"
                value="PRD001"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Nama Produk
            </label>
            <input
                name="name"
                value="Minyak Goreng Premium"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Kategori
            </label>
            <select name="category_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="">Pilih kategori</option>
                <option value="1" selected>Sembako</option>
                <option value="2">Minuman</option>
                <option value="3">Makanan Ringan</option>
                <option value="4">Peralatan Rumah</option>
                <option value="5">Kebutuhan Harian</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Satuan
            </label>
            <input
                name="unit"
                value="pcs"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Harga Beli
            </label>
            <input
                type="number"
                name="purchase_price"
                min="0"
                value="15000"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Harga Jual
            </label>
            <input
                type="number"
                name="selling_price"
                min="0"
                value="18000"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Minimum Stok
            </label>
            <input
                type="number"
                name="minimum_stock"
                min="0"
                value="10"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Cabang Produk
            </label>
            <select name="stock_store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="all" selected>Semua Cabang</option>
                <option value="1">Cabang Cianjur</option>
                <option value="2">Cabang Bandung</option>
                <option value="3">Cabang Bogor</option>
                <option value="4">Cabang Sukabumi</option>
                <option value="5">Cabang Jakarta</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Stok Awal
            </label>
            <input
                type="number"
                name="initial_stock"
                min="0"
                value="50"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Gambar Produk
            </label>

            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                    <img
                        id="product-image-preview"
                        src="{{ asset('img/logo_minimarket.png') }}"
                        alt="Preview produk"
                        class="w-full h-full object-contain bg-white p-1">
                </div>

                <div class="flex-1">
                    <input
                        id="product-image-input"
                        type="file"
                        name="image"
                        accept="image/*"
                        class="hidden">

                    <label for="product-image-input" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 cursor-pointer">
                        <i class="fa-solid fa-image"></i>
                        Pilih Gambar
                    </label>

                    <p id="product-image-name" class="text-xs text-slate-500 mt-2">
                        Belum ada file dipilih
                    </p>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 lg:col-span-4">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Deskripsi
            </label>
            <textarea
                name="description"
                rows="2"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">Produk kebutuhan minimarket yang tersedia di beberapa cabang.</textarea>
        </div>

        <div class="md:col-span-2 lg:col-span-4 flex gap-3">
            <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                <i class="fa-solid fa-save"></i>
                Simpan
            </button>

            <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-slate-100 text-slate-700 hover:bg-slate-200">
                <i class="fa-solid fa-times"></i>
                Batal
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="font-bold text-slate-900">
            Daftar Produk
        </h2>
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
                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">PRD001</td>
                    <td class="px-6 py-4 text-slate-700">Minyak Goreng Premium</td>
                    <td class="px-6 py-4">
                        <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                            <img src="{{ asset('img/minyak.jpg') }}" alt="Minyak Goreng Premium" class="w-full h-full object-contain bg-white p-1">
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Sembako</td>
                    <td class="px-6 py-4 text-slate-600">Cianjur, Bandung, Bogor</td>
                    <td class="px-6 py-4 text-green-600 font-medium">Rp 18.000</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Stok Aman
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-produk" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">PRD002</td>
                    <td class="px-6 py-4 text-slate-700">Beras Premium 5kg</td>
                    <td class="px-6 py-4">
                        <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                            <img src="{{ asset('img/beras.jpg') }}" alt="Beras Premium 5kg" class="w-full h-full object-contain bg-white p-1">
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Sembako</td>
                    <td class="px-6 py-4 text-slate-600">Cianjur</td>
                    <td class="px-6 py-4 text-green-600 font-medium">Rp 68.000</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                            Stok Rendah
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-produk" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">PRD003</td>
                    <td class="px-6 py-4 text-slate-700">Gula Pasir 1kg</td>
                    <td class="px-6 py-4">
                        <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                            <img src="{{ asset('img/gula.jpg') }}" alt="Gula Pasir 1kg" class="w-full h-full object-contain bg-white p-1">
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-600">Sembako</td>
                    <td class="px-6 py-4 text-slate-600">Bandung, Sukabumi</td>
                    <td class="px-6 py-4 text-green-600 font-medium">Rp 16.000</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                            Hampir Habis
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-produk" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection