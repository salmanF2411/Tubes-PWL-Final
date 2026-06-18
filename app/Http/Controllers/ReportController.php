<?php

namespace App\Http\Controllers;

use App\Exports\StockReportExport;
use App\Exports\TransactionsExport;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Store;
use App\Models\Transaction as SaleTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $data = $this->transactionReportData($request);

        return view('pages.laporan-transaksi', $data);
    }

    public function stocks(Request $request)
    {
        $data = $this->stockReportData($request);

        return view('pages.laporan-stok', $data);
    }

    public function transactionsPdf(Request $request)
    {
        $data = $this->transactionReportData($request);

        return Pdf::loadView('reports.pdf.transactions', $data)
            ->setPaper('a4', 'landscape')
            ->download($this->reportFileName('laporan-transaksi', 'pdf'));
    }

    public function transactionsExcel(Request $request): BinaryFileResponse
    {
        $data = $this->transactionReportData($request);

        return Excel::download(
            new TransactionsExport($data['transactions'], $data['filters']),
            $this->reportFileName('laporan-transaksi', 'xlsx')
        );
    }

    public function stocksPdf(Request $request)
    {
        $data = $this->stockReportData($request);

        return Pdf::loadView('reports.pdf.stocks', $data)
            ->setPaper('a4', 'landscape')
            ->download($this->reportFileName('laporan-stok', 'pdf'));
    }

    public function stocksExcel(Request $request): BinaryFileResponse
    {
        $data = $this->stockReportData($request);

        return Excel::download(
            new StockReportExport($data['rows'], $data['filters']),
            $this->reportFileName('laporan-stok', 'xlsx')
        );
    }

    private function transactionReportData(Request $request): array
    {
        $stores = $this->visibleStores();
        $storeIds = $this->filteredStoreIds($request, $stores->pluck('id')->all());

        $transactions = SaleTransaction::query()
            ->with(['cashier', 'store'])
            ->whereIn('store_id', $storeIds)
            ->betweenDates($request->input('tanggal_mulai'), $request->input('tanggal_akhir'))
            ->latest('transaction_date')
            ->get();

        return [
            'stores' => $stores,
            'transactions' => $transactions,
            'filters' => $this->reportFilters($request, $stores, $storeIds),
        ];
    }

    private function stockReportData(Request $request): array
    {
        $stores = $this->visibleStores();
        $storeIds = $this->filteredStoreIds($request, $stores->pluck('id')->all());
        $startDate = $request->input('tanggal_mulai');
        $endDate = $request->input('tanggal_akhir');

        $stocks = Stock::query()
            ->with(['product.category', 'store'])
            ->whereIn('store_id', $storeIds)
            ->orderBy('store_id')
            ->get();

        $rows = $this->stockReportRows($stocks, $startDate, $endDate);

        return [
            'stores' => $stores,
            'rows' => $rows,
            'filters' => $this->reportFilters($request, $stores, $storeIds),
        ];
    }

    private function stockReportRows(Collection $stocks, ?string $startDate, ?string $endDate): Collection
    {
        return $stocks->map(function (Stock $stock) use ($startDate, $endDate) {
            $movementQuery = StockMovement::query()
                ->where('store_id', $stock->store_id)
                ->where('product_id', $stock->product_id)
                ->when($startDate, fn ($query) => $query->whereDate('movement_date', '>=', $startDate))
                ->when($endDate, fn ($query) => $query->whereDate('movement_date', '<=', $endDate));

            $incoming = (clone $movementQuery)
                ->whereIn('type', ['in', 'transfer_in', 'adjustment'])
                ->sum('quantity');
            $outgoing = (clone $movementQuery)
                ->whereIn('type', ['out', 'sale', 'transfer_out'])
                ->sum('quantity');

            return [
                'stock' => $stock,
                'initial_stock' => max(0, $stock->current_stock - $incoming + $outgoing),
                'incoming' => $incoming,
                'outgoing' => $outgoing,
                'final_stock' => $stock->current_stock,
            ];
        });
    }

    private function visibleStores()
    {
        return Store::query()
            ->whereIn('id', $this->visibleStoreIds())
            ->orderBy('name')
            ->get();
    }

    private function filteredStoreIds(Request $request, array $visibleStoreIds): array
    {
        if ($request->filled('store_id')) {
            return [$this->ensureVisibleStore($request->integer('store_id'))];
        }

        return $visibleStoreIds;
    }

    private function reportFilters(Request $request, Collection $stores, array $storeIds): array
    {
        $selectedStores = $stores->whereIn('id', $storeIds);
        $startDate = $request->input('tanggal_mulai');
        $endDate = $request->input('tanggal_akhir');

        return [
            'store_label' => match (true) {
                $selectedStores->count() === 1 => $selectedStores->first()->name,
                $selectedStores->count() === $stores->count() => 'Semua Cabang',
                default => $selectedStores->pluck('name')->join(', '),
            },
            'period_label' => $this->periodLabel($startDate, $endDate),
            'printed_at' => now()->format('d-m-Y H:i'),
            'tanggal_mulai' => $startDate,
            'tanggal_akhir' => $endDate,
        ];
    }

    private function periodLabel(?string $startDate, ?string $endDate): string
    {
        if ($startDate && $endDate) {
            return $startDate.' s/d '.$endDate;
        }

        if ($startDate) {
            return 'Mulai '.$startDate;
        }

        if ($endDate) {
            return 'Sampai '.$endDate;
        }

        return 'Semua Tanggal';
    }

    private function reportFileName(string $prefix, string $extension): string
    {
        return $prefix.'-'.now()->format('Ymd-His').'.'.$extension;
    }
}