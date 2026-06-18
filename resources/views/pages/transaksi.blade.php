@extends('layouts.layoutAdminPanel')

@section('content')
@php
    $brandLogo = file_exists(public_path('img/logo_minimarket.jpg'))
        ? 'img/logo_minimarket.jpg'
        : 'img/logo_minimarket.png';
@endphp

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-receipt text-blue-600 mr-2"></i>Transaksi Kasir
    </h1>
    <p class="text-slate-500 text-sm mt-1">Lakukan transaksi penjualan dengan cepat dan mudah untuk pelanggan</p>
</div>

<form method="GET" action="{{ route('transaksi') }}" class="bg-white rounded-lg border border-slate-200 p-5 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Cabang</label>
            <select name="store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @selected($selectedStoreId == $store->id)>
                        {{ $store->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">Cari Produk</label>
            <div class="relative">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari produk (minyak, gula, beras...)"
                    class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 pl-12 text-sm">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            <i class="fa-solid fa-search"></i>
            Filter
        </button>
    </div>
</form>

<form method="POST" action="{{ route('transaksi.store') }}" id="transaction-form">
    @csrf
    <input type="hidden" name="store_id" value="{{ $selectedStoreId }}">
    <div id="cart-fields"></div>

    <div class="grid lg:grid-cols-4 gap-6">
        <div class="lg:col-span-3 space-y-6">
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                    <h2 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-boxes-stacked text-blue-600"></i>Daftar Produk Tersedia
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
                            @forelse($products as $product)
                                @php
                                    $stock = $product->stocks->first();
                                    $quantity = (int) ($stock->current_stock ?? 0);
                                @endphp
                                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                                            <img src="{{ asset($product->image_path ?: $brandLogo) }}" alt="{{ $product->name }}" class="w-full h-full object-contain bg-white p-1">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-900">{{ $product->name }}</td>
                                    <td class="px-6 py-4 text-green-600 font-medium">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <x-badge :type="$product->stockBadgeType($quantity)">
                                            {{ $quantity <= 0 ? 'Habis' : $quantity }}
                                        </x-badge>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input
                                            id="qty-{{ $product->id }}"
                                            type="number"
                                            min="0"
                                            max="{{ $quantity }}"
                                            value="0"
                                            data-product-id="{{ $product->id }}"
                                            @disabled($quantity <= 0)
                                            class="js-cart-qty w-24 px-2 py-1 border border-slate-200 rounded text-sm focus:outline-none focus:border-blue-400 disabled:bg-slate-100">
                                    </td>
                                    <td class="px-6 py-4">
                                        <button
                                            type="button"
                                            class="js-add-cart px-3 py-2 rounded-lg transition inline-flex items-center gap-2 text-xs font-medium bg-blue-600 text-white hover:bg-blue-700 disabled:bg-slate-300"
                                            data-product-id="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->selling_price }}"
                                            data-stock="{{ $quantity }}"
                                            data-image="{{ asset($product->image_path ?: $brandLogo) }}"
                                            @disabled($quantity <= 0)>
                                            <i class="fa-solid fa-plus"></i>
                                            Tambah
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">Produk tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="lg:sticky lg:top-8 lg:h-fit space-y-4">
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="font-bold text-slate-900 text-lg mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-shopping-cart text-blue-600"></i>Keranjang
                    <span id="cart-count" class="ml-auto text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">0</span>
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
                        <label class="block text-sm font-medium text-slate-700 mb-2">Diskon (%)</label>
                        <input id="discount-input" type="number" name="discount" min="0" max="100" value="{{ old('discount', 0) }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400 text-sm">
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
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nominal Bayar</label>
                        <input id="paid-amount" type="number" name="paid_amount" min="0" value="{{ old('paid_amount') }}" placeholder="Otomatis mengikuti total" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400 text-sm">
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200 p-6">
                <h4 class="font-bold text-green-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-credit-card text-green-600"></i>Pembayaran
                </h4>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-green-400 focus:ring-1 focus:ring-green-200 text-sm">
                            <option value="cash" @selected(old('payment_method') === 'cash')>Tunai</option>
                            <option value="qris" @selected(old('payment_method') === 'qris')>QRIS</option>
                            <option value="transfer" @selected(old('payment_method') === 'transfer')>Transfer</option>
                            <option value="debit" @selected(old('payment_method') === 'debit')>Debit</option>
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

<script>
    const cart = new Map();
    const formatter = new Intl.NumberFormat('id-ID');
    const cartFields = document.getElementById('cart-fields');
    const cartItems = document.getElementById('cart-items');
    const cartEmpty = document.getElementById('cart-empty');
    const cartCount = document.getElementById('cart-count');
    const cartSubtotal = document.getElementById('cart-subtotal');
    const cartDiscount = document.getElementById('cart-discount');
    const cartTotal = document.getElementById('cart-total');
    const discountInput = document.getElementById('discount-input');
    const paidAmount = document.getElementById('paid-amount');
    let lastAutoPaid = '';

    function rupiah(value) {
        return `Rp ${formatter.format(Math.round(value))}`;
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value;

        return div.innerHTML;
    }

    function renderCart() {
        let subtotal = 0;
        let totalQty = 0;

        cartFields.innerHTML = '';
        cartItems.innerHTML = '';

        cart.forEach((item, productId) => {
            const itemSubtotal = item.price * item.qty;
            subtotal += itemSubtotal;
            totalQty += item.qty;

            cartFields.insertAdjacentHTML('beforeend', `<input type="hidden" name="quantities[${productId}]" value="${item.qty}">`);
            cartItems.insertAdjacentHTML('beforeend', `
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg">
                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-slate-100 border border-slate-200">
                        <img src="${item.image}" alt="${escapeHtml(item.name)}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-slate-900 text-sm truncate">${escapeHtml(item.name)}</p>
                        <p class="text-xs text-slate-500">${rupiah(item.price)} x ${item.qty}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-slate-900">${rupiah(itemSubtotal)}</p>
                        <button type="button" class="js-remove-cart text-red-500 hover:text-red-600 text-xs mt-1" data-product-id="${productId}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);
        });

        const discountPercent = Math.min(100, Math.max(0, Number(discountInput.value || 0)));
        const discountAmount = subtotal * (discountPercent / 100);
        const total = Math.max(0, subtotal - discountAmount);

        cartEmpty.classList.toggle('hidden', cart.size > 0);
        cartCount.textContent = totalQty;
        cartSubtotal.textContent = rupiah(subtotal);
        cartDiscount.textContent = rupiah(discountAmount);
        cartTotal.textContent = rupiah(total);

        const totalValue = String(Math.round(total));
        if (!paidAmount.dataset.manual || paidAmount.value === '' || paidAmount.value === lastAutoPaid) {
            paidAmount.value = totalValue;
            paidAmount.dataset.manual = '0';
            lastAutoPaid = totalValue;
        }
    }

    document.querySelectorAll('.js-add-cart').forEach((button) => {
        button.addEventListener('click', () => {
            const productId = button.dataset.productId;
            const qtyInput = document.getElementById(`qty-${productId}`);
            const requestedQty = Number(qtyInput.value || 0);
            const stock = Number(button.dataset.stock || 0);
            const existingQty = cart.get(productId)?.qty || 0;
            const nextQty = existingQty + requestedQty;

            if (requestedQty <= 0) {
                alert('Isi qty lebih dari 0 terlebih dahulu.');
                return;
            }

            if (nextQty > stock) {
                alert('Qty melebihi stok yang tersedia.');
                return;
            }

            cart.set(productId, {
                name: button.dataset.name,
                price: Number(button.dataset.price),
                stock,
                image: button.dataset.image,
                qty: nextQty,
            });

            qtyInput.value = 0;
            renderCart();
        });
    });

    document.querySelectorAll('.js-cart-qty').forEach((input) => {
        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.querySelector(`.js-add-cart[data-product-id="${input.dataset.productId}"]`)?.click();
            }
        });
    });

    cartItems.addEventListener('click', (event) => {
        const removeButton = event.target.closest('.js-remove-cart');

        if (!removeButton) {
            return;
        }

        cart.delete(removeButton.dataset.productId);
        renderCart();
    });

    discountInput.addEventListener('input', renderCart);
    paidAmount.addEventListener('input', () => {
        if (paidAmount.value !== lastAutoPaid) {
            paidAmount.dataset.manual = '1';
        }
    });

    document.getElementById('transaction-form').addEventListener('submit', (event) => {
        if (cart.size === 0) {
            event.preventDefault();
            alert('Tambahkan minimal satu produk ke keranjang terlebih dahulu.');
        }
    });

    renderCart();
</script>
@endsection