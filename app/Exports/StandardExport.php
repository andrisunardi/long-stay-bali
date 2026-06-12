<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StandardExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public object $standards;

    public function __construct(object $standards)
    {
        $this->standards = $standards;
    }

    public function view(): View
    {
        return view('excel.standard', [
            'standards' => $this->standards,
        ]);
    }
}
