@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-receipt text-blue-600 mr-2"></i>
        Transaksi Kasir
    </h1>
    <p class="text-slate-500 text-sm mt-1">
        Lakukan transaksi penjualan dengan cepat dan mudah untuk pelanggan
    </p>
</div>

<form action="#" class="bg-white rounded-lg border border-slate-200 p-5 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Cabang
            </label>
            <select name="store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
                <option value="1" selected>Cabang Cianjur</option>
                <option value="2">Cabang Bandung</option>
                <option value="3">Cabang Bogor</option>
                <option value="4">Cabang Sukabumi</option>
                <option value="5">Cabang Jakarta</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Cari Produk
            </label>
            <div class="relative">
                <input
                    type="text"
                    name="q"
                    placeholder="Cari produk (minyak, gula, beras...)"
                    class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 pl-12 text-sm">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            <i class="fa-solid fa-search"></i>
            Filter
        </button>
    </div>
</form>

<form action="#" id="transaction-form">
    <input type="hidden" name="store_id" value="1">
    <div id="cart-fields"></div>

    <div class="grid lg:grid-cols-4 gap-6">
        <div class="lg:col-span-3 space-y-6">
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <h2 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-blue-600"></i>
                        Daftar Produk Tersedia
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="px-6 py-3 text-left font-semibold text-slate-600">Gambar</th>
                                <th class="px-6 py-3 text-left font-semibold text-slate-600">Produk</th>
                                <th class="px-6 py-3 text-left font-semibold text-slate-600">Harga</th>
                                <th class="px-6 py-3 text-left font-semibold text-slate-600">Stok</th>
                                <th class="px-6 py-3 text-left font-semibold text-slate-600">Qty</th>
                                <th class="px-6 py-3 text-left font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                                        <img src="/img/minyak.jpg" alt="Minyak Goreng Premium" class="w-full h-full object-contain bg-white p-1">
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    Minyak Goreng Premium
                                </td>
                                <td class="px-6 py-4 text-green-600 font-medium">
                                    Rp 18.000
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        45
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <input
                                        id="qty-1"
                                        type="number"
                                        min="0"
                                        max="45"
                                        value="0"
                                        data-product-id="1"
                                        class="js-cart-qty w-24 px-2 py-1 border border-slate-200 rounded text-sm focus:outline-none focus:border-blue-400 disabled:bg-slate-100">
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        type="button"
                                        class="js-add-cart px-3 py-2 rounded-lg transition inline-flex items-center gap-2 text-xs font-medium bg-blue-600 text-white hover:bg-blue-700 disabled:bg-slate-300"
                                        data-product-id="1"
                                        data-name="Minyak Goreng Premium"
                                        data-price="18000"
                                        data-stock="45"
                                        data-image="/img/minyak.jpg">
                                        <i class="fa-solid fa-plus"></i>
                                        Tambah
                                    </button>
                                </td>
                            </tr>

                            <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                                        <img src="/img/beras.jpg" alt="Beras Premium 5kg" class="w-full h-full object-contain bg-white p-1">
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    Beras Premium 5kg
                                </td>
                                <td class="px-6 py-4 text-green-600 font-medium">
                                    Rp 68.000
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                        12
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <input
                                        id="qty-2"
                                        type="number"
                                        min="0"
                                        max="12"
                                        value="0"
                                        data-product-id="2"
                                        class="js-cart-qty w-24 px-2 py-1 border border-slate-200 rounded text-sm focus:outline-none focus:border-blue-400 disabled:bg-slate-100">
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        type="button"
                                        class="js-add-cart px-3 py-2 rounded-lg transition inline-flex items-center gap-2 text-xs font-medium bg-blue-600 text-white hover:bg-blue-700 disabled:bg-slate-300"
                                        data-product-id="2"
                                        data-name="Beras Premium 5kg"
                                        data-price="68000"
                                        data-stock="12"
                                        data-image="/img/beras.jpg">
                                        <i class="fa-solid fa-plus"></i>
                                        Tambah
                                    </button>
                                </td>
                            </tr>

                            <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                                        <img src="/img/gula.jpg" alt="Gula Pasir 1kg" class="w-full h-full object-contain bg-white p-1">
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-900">
                                    Gula Pasir 1kg
                                </td>
                                <td class="px-6 py-4 text-green-600 font-medium">
                                    Rp 16.000
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        34
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <input
                                        id="qty-3"
                                        type="number"
                                        min="0"
                                        max="34"
                                        value="0"
                                        data-product-id="3"
                                        class="js-cart-qty w-24 px-2 py-1 border border-slate-200 rounded text-sm focus:outline-none focus:border-blue-400 disabled:bg-slate-100">
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        type="button"
                                        class="js-add-cart px-3 py-2 rounded-lg transition inline-flex items-center gap-2 text-xs font-medium bg-blue-600 text-white hover:bg-blue-700 disabled:bg-slate-300"
                                        data-product-id="3"
                                        data-name="Gula Pasir 1kg"
                                        data-price="16000"
                                        data-stock="34"
                                        data-image="/img/gula.jpg">
                                        <i class="fa-solid fa-plus"></i>
                                        Tambah
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="lg:sticky lg:top-8 lg:h-fit space-y-4">
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="font-bold text-slate-900 text-lg mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-shopping-cart text-blue-600"></i>
                    Keranjang
                    <span id="cart-count" class="ml-auto text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                        0
                    </span>
                </h3>

                <div id="cart-empty" class="text-center py-8 text-slate-500">
                    <i class="fa-solid fa-cart-shopping text-3xl mb-3 opacity-50"></i>
                    <p class="text-sm">Belum ada item di keranjang</p>
                </div>

                <div id="cart-items" class="space-y-3 mb-5"></div>

                <div class="space-y-3 pt-4 border-t border-slate-200">
                    <div class="flex justify-between text-sm text-slate-700">
                        <span>Subtotal:</span>
                        <span id="cart-subtotal">Rp 0</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Diskon (%)
                        </label>
                        <input
                            id="discount-input"
                            type="number"
                            name="discount"
                            min="0"
                            max="100"
                            value="0"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400 text-sm">
                    </div>

                    <div class="flex justify-between text-sm text-slate-700">
                        <span>Potongan:</span>
                        <span id="cart-discount">Rp 0</span>
                    </div>

                    <div class="flex justify-between font-bold text-lg text-slate-900 pt-2">
                        <span>Total Bayar:</span>
                        <span id="cart-total">Rp 0</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nominal Bayar
                        </label>
                        <input
                            id="paid-amount"
                            type="number"
                            name="paid_amount"
                            min="0"
                            placeholder="Otomatis mengikuti total"
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400 text-sm">
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200 p-6">
                <h4 class="font-bold text-green-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-green-600"></i>
                    Pembayaran
                </h4>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">
                            Metode Pembayaran
                        </label>
                        <select name="payment_method" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-green-400 focus:ring-1 focus:ring-green-200 text-sm">
                            <option value="cash" selected>Tunai</option>
                            <option value="qris">QRIS</option>
                            <option value="transfer">Transfer</option>
                            <option value="debit">Debit</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 px-4 py-3 bg-green-600 text-white rounded-lg font-bold text-sm hover:bg-green-700 transition flex items-center justify-center gap-2 shadow-lg">
                    <i class="fa-solid fa-check"></i>
                    Selesaikan Transaksi
                </button>
            </div>
        </div>
    </div>
</form>
@endsection