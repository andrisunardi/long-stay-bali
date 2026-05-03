<?php

namespace App\Observers;

use App\Models\Guide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GuideObserver
{
    public function creating(Guide $guide): void
    {
        $guide->slug = Str::slug($guide->title);
        $guide->created_by = Auth::user()->id ?? null;
    }

    public function created(Guide $guide): void
    {
        $guide->slug = Str::slug($guide->title);
        $guide->created_by = Auth::user()->id ?? null;
    }

    public function updating(Guide $guide): void
    {
        $guide->slug = Str::slug($guide->title);
        $guide->updated_by = Auth::user()->id ?? null;
    }

    public function updated(Guide $guide): void
    {
        $guide->slug = Str::slug($guide->title);
        $guide->updated_by = Auth::user()->id ?? null;
    }

    public function deleting(Guide $guide): void
    {
        $guide->deleted_by = Auth::user()->id ?? null;
    }

    public function deleted(Guide $guide): void
    {
        $guide->deleted_by = Auth::user()->id ?? null;
    }

    public function restoring(Guide $guide): void
    {
        $guide->deleted_by = null;
    }

    public function restored(Guide $guide): void
    {
        $guide->deleted_by = null;
    }
}
