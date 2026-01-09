<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PermissionExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public object $permissions;

    public function __construct(object $permissions)
    {
        $this->permissions = $permissions;
    }

    public function view(): View
    {
        return view('excel.permission', [
            'permissions' => $this->permissions,
        ]);
    }
}
