<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Transaction as SaleTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $storeIds = $this->visibleStoreIds();

        $transactionQuery = SaleTransaction::query()
            ->completed()
            ->whereIn('store_id', $storeIds);

        $summary = [
            'total_sales' => (clone $transactionQuery)
                ->whereBetween('transaction_date', [now()->startOfMonth(), now()->endOfMonth()])
                ->sum('total'),
            'total_transactions' => (clone $transactionQuery)->count(),
            'total_stock' => Stock::query()->whereIn('store_id', $storeIds)->sum('current_stock'),
            'active_users' => User::query()
                ->where('status', 'active')
                ->when(! $this->currentUser()->canAccessAllStores(), fn ($query) => $query->whereIn('store_id', $storeIds))
                ->count(),
        ];

        $latestTransactions = SaleTransaction::query()
            ->with(['cashier', 'store'])
            ->completed()
            ->whereIn('store_id', $storeIds)
            ->latest('transaction_date')
            ->limit(5)
            ->get();

        $lowStocks = Stock::query()
            ->with(['product.category', 'store'])
            ->whereIn('store_id', $storeIds)
            ->whereColumn('current_stock', '<=', 'minimum_stock')
            ->orderBy('current_stock')
            ->limit(5)
            ->get();

        return view('pages.dashboard', compact('summary', 'latestTransactions', 'lowStocks'));
    }
}