<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->created_by = Auth::user()->id ?? null;
    }

    public function created(User $user): void
    {
        $user->created_by = Auth::user()->id ?? null;
    }

    public function updating(User $user): void
    {
        $user->updated_by = Auth::user()->id ?? null;
    }

    public function updated(User $user): void
    {
        $user->updated_by = Auth::user()->id ?? null;
    }

    public function deleting(User $user): void
    {
        $user->deleted_by = Auth::user()->id ?? null;
    }

    public function deleted(User $user): void
    {
        $user->deleted_by = Auth::user()->id ?? null;
    }

    public function restoring(User $user): void
    {
        $user->deleted_by = null;
    }

    public function restored(User $user): void
    {
        $user->deleted_by = null;
    }
}
