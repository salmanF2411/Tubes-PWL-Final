<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StockReportExport implements FromView, ShouldAutoSize
{
    public function __construct(
        private readonly Collection $rows,
        private readonly array $filters
    ) {}

    public function view(): View
    {
        return view('reports.excel.stocks', [
            'rows' => $this->rows,
            'filters' => $this->filters,
        ]);
    }
}