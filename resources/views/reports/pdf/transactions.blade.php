<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
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
            background: #e0f2fe;
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
    <h1>Laporan Transaksi Mini Market Pak Jayusman</h1>
    <div class="muted">Dicetak pada {{ $filters['printed_at'] }}</div>

    <div class="meta">
        <strong>Cabang:</strong> {{ $filters['store_label'] }}<br>
        <strong>Periode:</strong> {{ $filters['period_label'] }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Kasir</th>
                <th>Cabang</th>
                <th>Tanggal</th>
                <th class="text-right">Total</th>
                <th>Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->invoice_number }}</td>
                    <td>{{ $transaction->cashier->name ?? '-' }}</td>
                    <td>{{ $transaction->store->name }}</td>
                    <td>{{ $transaction->transaction_date->format('d-m-Y H:i') }}</td>
                    <td class="text-right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td>{{ $transaction->payment_method_label }}</td>
                    <td>{{ $transaction->status_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada transaksi sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>