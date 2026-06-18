<table>
    <tr>
        <th colspan="8">Laporan Transaksi Mini Market Pak Jayusman</th>
    </tr>
    <tr>
        <td colspan="8">Cabang: {{ $filters['store_label'] }}</td>
    </tr>
    <tr>
        <td colspan="8">Periode: {{ $filters['period_label'] }}</td>
    </tr>
    <tr>
        <td colspan="8">Dicetak: {{ $filters['printed_at'] }}</td>
    </tr>
    <tr></tr>
    <tr>
        <th>No</th>
        <th>ID Transaksi</th>
        <th>Kasir</th>
        <th>Cabang</th>
        <th>Tanggal</th>
        <th>Total</th>
        <th>Pembayaran</th>
        <th>Status</th>
    </tr>
    @forelse($transactions as $transaction)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $transaction->invoice_number }}</td>
            <td>{{ $transaction->cashier->name ?? '-' }}</td>
            <td>{{ $transaction->store->name }}</td>
            <td>{{ $transaction->transaction_date->format('d-m-Y H:i') }}</td>
            <td>{{ $transaction->total }}</td>
            <td>{{ $transaction->payment_method_label }}</td>
            <td>{{ $transaction->status_label }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="8">Tidak ada transaksi sesuai filter.</td>
        </tr>
    @endforelse
</table>