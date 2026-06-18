<table>
    <tr>
        <th colspan="10">Laporan Stok Mini Market Pak Jayusman</th>
    </tr>
    <tr>
        <td colspan="10">Cabang: {{ $filters['store_label'] }}</td>
    </tr>
    <tr>
        <td colspan="10">Periode: {{ $filters['period_label'] }}</td>
    </tr>
    <tr>
        <td colspan="10">Dicetak: {{ $filters['printed_at'] }}</td>
    </tr>
    <tr></tr>
    <tr>
        <th>No</th>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Cabang</th>
        <th>Stok Awal</th>
        <th>Masuk</th>
        <th>Keluar</th>
        <th>Stok Akhir</th>
        <th>Status</th>
    </tr>
    @forelse($rows as $row)
        @php($stock = $row['stock'])
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stock->product->code }}</td>
            <td>{{ $stock->product->name }}</td>
            <td>{{ $stock->product->category->name }}</td>
            <td>{{ $stock->store->name }}</td>
            <td>{{ $row['initial_stock'] }}</td>
            <td>{{ $row['incoming'] }}</td>
            <td>{{ $row['outgoing'] }}</td>
            <td>{{ $row['final_stock'] }}</td>
            <td>{{ $stock->status_label }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="10">Tidak ada data stok sesuai filter.</td>
        </tr>
    @endforelse
</table>