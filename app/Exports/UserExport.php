<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public object $users;

    public function __construct(object $users)
    {
        $this->users = $users;
    }

    public function view(): View
    {
        return view('excel.user', [
            'users' => $this->users,
        ]);
    }
}
