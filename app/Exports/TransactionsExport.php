<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionsExport implements FromView, ShouldAutoSize
{
    public function __construct(
        private readonly Collection $transactions,
        private readonly array $filters
    ) {}

    public function view(): View
    {
        return view('reports.excel.transactions', [
            'transactions' => $this->transactions,
            'filters' => $this->filters,
        ]);
    }
}