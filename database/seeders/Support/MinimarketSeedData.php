<?php

namespace Database\Seeders\Support;

final class MinimarketSeedData
{
    public static function permissions(): array
    {
        return [
            'view dashboard',
            'view users',
            'create user',
            'edit user',
            'delete user',
            'view products',
            'create product',
            'edit product',
            'delete product',
            'view stores',
            'create store',
            'edit store',
            'delete store',
            'view transactions',
            'create transaction',
            'edit transaction',
            'delete transaction',
            'print transaction',
            'view inventory',
            'create inventory',
            'edit inventory',
            'delete inventory',
            'print inventory',
            'manage stock',
            'view reports',
            'create reports',
            'export reports',
            'view settings',
            'edit settings',
        ];
    }

    public static function rolePermissions(): array
    {
        return [
            'owner' => self::permissions(),
            'store_manager' => [
                'view dashboard',
                'view users',
                'create user',
                'edit user',
                'view products',
                'create product',
                'edit product',
                'view transactions',
                'create transaction',
                'print transaction',
                'view inventory',
                'create inventory',
                'edit inventory',
                'print inventory',
                'manage stock',
                'view reports',
                'export reports',
                'view settings',
            ],
            'supervisor' => [
                'view dashboard',
                'view products',
                'view transactions',
                'view inventory',
                'view reports',
                'print inventory',
                'print transaction',
            ],
            'cashier' => [
                'view dashboard',
                'view transactions',
                'create transaction',
            ],
            'warehouse_staff' => [
                'view dashboard',
                'view products',
                'view inventory',
                'create inventory',
                'edit inventory',
                'manage stock',
            ],
        ];
    }

    public static function stores(): array
    {
        return [
            ['code' => 'CBG-JKT', 'name' => 'Cabang Jakarta Pusat', 'city' => 'Jakarta', 'address' => 'Jl. Melati No. 10, Jakarta Pusat', 'phone' => '021-555-1001'],
            ['code' => 'CBG-BDG', 'name' => 'Cabang Bandung', 'city' => 'Bandung', 'address' => 'Jl. Asia Afrika No. 21, Bandung', 'phone' => '022-555-1002'],
            ['code' => 'CBG-SBY', 'name' => 'Cabang Surabaya', 'city' => 'Surabaya', 'address' => 'Jl. Tunjungan No. 8, Surabaya', 'phone' => '031-555-1003'],
            ['code' => 'CBG-MDN', 'name' => 'Cabang Medan', 'city' => 'Medan', 'address' => 'Jl. Gatot Subroto No. 14, Medan', 'phone' => '061-555-1004'],
            ['code' => 'CBG-MKS', 'name' => 'Cabang Makassar', 'city' => 'Makassar', 'address' => 'Jl. Penghibur No. 7, Makassar', 'phone' => '0411-555-1005'],
        ];
    }

    public static function categories(): array
    {
        return [
            ['code' => 'KAT-BKP', 'name' => 'Bahan Pokok', 'description' => 'Produk kebutuhan harian utama.'],
            ['code' => 'KAT-MYL', 'name' => 'Minyak & Lemak', 'description' => 'Minyak goreng dan produk sejenis.'],
            ['code' => 'KAT-PRT', 'name' => 'Protein', 'description' => 'Telur dan sumber protein harian.'],
            ['code' => 'KAT-RBK', 'name' => 'Roti & Bakery', 'description' => 'Roti dan produk bakery.'],
        ];
    }

    public static function products(): array
    {
        return [
            ['category' => 'KAT-MYL', 'code' => 'PRD-001', 'name' => 'Minyak Goreng 2L', 'image_path' => 'img/minyak.jpg', 'unit' => 'unit', 'purchase_price' => 24000, 'selling_price' => 28000, 'minimum_stock' => 20],
            ['category' => 'KAT-BKP', 'code' => 'PRD-002', 'name' => 'Gula Pasir 1kg', 'image_path' => 'img/gula.jpg', 'unit' => 'unit', 'purchase_price' => 10500, 'selling_price' => 12500, 'minimum_stock' => 20],
            ['category' => 'KAT-BKP', 'code' => 'PRD-003', 'name' => 'Beras Putih 5kg', 'image_path' => 'img/beras.jpg', 'unit' => 'unit', 'purchase_price' => 47000, 'selling_price' => 52000, 'minimum_stock' => 20],
            ['category' => 'KAT-PRT', 'code' => 'PRD-004', 'name' => 'Telur 30 Butir', 'image_path' => 'img/telur.jpg', 'unit' => 'tray', 'purchase_price' => 40000, 'selling_price' => 45000, 'minimum_stock' => 20],
            ['category' => 'KAT-RBK', 'code' => 'PRD-005', 'name' => 'Roti Tawar', 'image_path' => 'img/roti.jpg', 'unit' => 'bungkus', 'purchase_price' => 6500, 'selling_price' => 8500, 'minimum_stock' => 20],
        ];
    }

    public static function stockMatrix(): array
    {
        return [
            'PRD-001' => ['CBG-JKT' => 15, 'CBG-BDG' => 0, 'CBG-SBY' => 45, 'CBG-MDN' => 8, 'CBG-MKS' => 30],
            'PRD-002' => ['CBG-JKT' => 50, 'CBG-BDG' => 40, 'CBG-SBY' => 12, 'CBG-MDN' => 35, 'CBG-MKS' => 0],
            'PRD-003' => ['CBG-JKT' => 80, 'CBG-BDG' => 20, 'CBG-SBY' => 60, 'CBG-MDN' => 0, 'CBG-MKS' => 55],
            'PRD-004' => ['CBG-JKT' => 25, 'CBG-BDG' => 42, 'CBG-SBY' => 18, 'CBG-MDN' => 30, 'CBG-MKS' => 5],
            'PRD-005' => ['CBG-JKT' => 60, 'CBG-BDG' => 35, 'CBG-SBY' => 24, 'CBG-MDN' => 45, 'CBG-MKS' => 20],
        ];
    }

    public static function transactions(): array
    {
        return [
            [
                'invoice' => 'TRX-20260611-001',
                'store' => 'CBG-JKT',
                'date' => '2026-06-11 09:15:00',
                'payment' => 'cash',
                'items' => [
                    ['product' => 'PRD-002', 'qty' => 2],
                    ['product' => 'PRD-005', 'qty' => 3],
                ],
            ],
            [
                'invoice' => 'TRX-20260611-002',
                'store' => 'CBG-BDG',
                'date' => '2026-06-11 10:20:00',
                'payment' => 'qris',
                'items' => [
                    ['product' => 'PRD-003', 'qty' => 1],
                    ['product' => 'PRD-004', 'qty' => 1],
                ],
            ],
            [
                'invoice' => 'TRX-20260610-003',
                'store' => 'CBG-SBY',
                'date' => '2026-06-10 14:05:00',
                'payment' => 'transfer',
                'items' => [
                    ['product' => 'PRD-001', 'qty' => 4],
                    ['product' => 'PRD-002', 'qty' => 2],
                ],
            ],
            [
                'invoice' => 'TRX-20260609-004',
                'store' => 'CBG-MDN',
                'date' => '2026-06-09 16:35:00',
                'payment' => 'cash',
                'items' => [
                    ['product' => 'PRD-005', 'qty' => 5],
                ],
            ],
            [
                'invoice' => 'TRX-20260608-005',
                'store' => 'CBG-MKS',
                'date' => '2026-06-08 11:45:00',
                'payment' => 'qris',
                'items' => [
                    ['product' => 'PRD-003', 'qty' => 2],
                    ['product' => 'PRD-004', 'qty' => 1],
                ],
            ],
        ];
    }

    public static function stockTransfers(): array
    {
        return [
            ['code' => 'TRF-20260611-001', 'from' => 'CBG-SBY', 'to' => 'CBG-BDG', 'product' => 'PRD-001', 'qty' => 20, 'status' => 'pending', 'date' => '2026-06-11 08:40:00'],
            ['code' => 'TRF-20260610-002', 'from' => 'CBG-JKT', 'to' => 'CBG-MKS', 'product' => 'PRD-005', 'qty' => 15, 'status' => 'confirmed', 'date' => '2026-06-10 15:00:00'],
            ['code' => 'TRF-20260609-003', 'from' => 'CBG-BDG', 'to' => 'CBG-MDN', 'product' => 'PRD-003', 'qty' => 10, 'status' => 'pending', 'date' => '2026-06-09 13:25:00'],
        ];
    }
}