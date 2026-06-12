<?php

namespace App\Observers;

use App\Models\Standard;
use Illuminate\Support\Facades\Auth;

class StandardObserver
{
    public function creating(Standard $standard): void
    {
        $standard->created_by = Auth::user()->id ?? null;
    }

    public function created(Standard $standard): void
    {
        $standard->created_by = Auth::user()->id ?? null;
    }

    public function updating(Standard $standard): void
    {
        $standard->updated_by = Auth::user()->id ?? null;
    }

    public function updated(Standard $standard): void
    {
        $standard->updated_by = Auth::user()->id ?? null;
    }

    public function deleting(Standard $standard): void
    {
        $standard->deleted_by = Auth::user()->id ?? null;
    }

    public function deleted(Standard $standard): void
    {
        $standard->deleted_by = Auth::user()->id ?? null;
    }

    public function restoring(Standard $standard): void
    {
        $standard->deleted_by = null;
    }

    public function restored(Standard $standard): void
    {
        $standard->deleted_by = null;
    }
}
