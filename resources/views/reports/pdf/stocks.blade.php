<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Stok</title>
    <style>
        body {
            color: #0f172a;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h1 {
            font-size: 20px;
            margin: 0 0 4px;
        }

        .muted {
            color: #64748b;
        }

        .meta {
            margin: 14px 0 18px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 7px;
            vertical-align: top;
        }

        th {
            background: #dcfce7;
            color: #0f172a;
            font-weight: 700;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>Laporan Stok Mini Market Pak Jayusman</h1>
    <div class="muted">Dicetak pada {{ $filters['printed_at'] }}</div>

    <div class="meta">
        <strong>Cabang:</strong> {{ $filters['store_label'] }}<br>
        <strong>Periode:</strong> {{ $filters['period_label'] }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Cabang</th>
                <th class="text-right">Stok Awal</th>
                <th class="text-right">Masuk</th>
                <th class="text-right">Keluar</th>
                <th class="text-right">Stok Akhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                @php($stock = $row['stock'])
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $stock->product->code }}</td>
                    <td>{{ $stock->product->name }}</td>
                    <td>{{ $stock->product->category->name }}</td>
                    <td>{{ $stock->store->name }}</td>
                    <td class="text-right">{{ $row['initial_stock'] }}</td>
                    <td class="text-right">{{ $row['incoming'] }}</td>
                    <td class="text-right">{{ $row['outgoing'] }}</td>
                    <td class="text-right">{{ $row['final_stock'] }}</td>
                    <td>{{ $stock->status_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Tidak ada data stok sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>