<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GuideExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public object $guides;

    public function __construct(object $guides)
    {
        $this->guides = $guides;
    }

    public function view(): View
    {
        return view('excel.guide', [
            'guides' => $this->guides,
        ]);
    }
}
