<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard');
});

Route::get('/produk', function () {
    return view('pages.produk');
});

Route::get('/transaksi', function () {
    return view('pages.transaksi');
});


