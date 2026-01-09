<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RoleExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public object $roles;

    public function __construct(object $roles)
    {
        $this->roles = $roles;
    }

    public function view(): View
    {
        return view('excel.role', [
            'roles' => $this->roles,
        ]);
    }
}
