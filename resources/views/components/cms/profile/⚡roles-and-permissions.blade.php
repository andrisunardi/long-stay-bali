<?php

use App\Livewire\Component;

new class extends Component {};
?>

<div class="card">
    <div class="card-header text-bg-primary">
        <span class="fas fa-key fa-fw"></span>
        Roles & Permissions
    </div>
    <div class="card-body">
        @foreach (Auth::user()->roles->loadMissing('permissions') as $role)
            <div wire:key="role-{{ $role->id }}">
                <div class="d-flex justify-content-between align-items-center">
                    <span>{{ $loop->iteration }}. {{ $role->name }}</span>
                    <span class="badge text-bg-primary rounded-pill">
                        {{ $role->permissions->count() }}
                    </span>
                </div>

                @if ($role->permissions->count())
                    <ol>
                        @foreach ($role->permissions as $permission)
                            <li wire:key="permission-{{ $permission->id }}">
                                {{ $loop->iteration }}. {{ $permission->name }}
                            </li>
                        @endforeach
                    </ol>
                @endif

                @if (!$loop->last)
                    <hr />
                @endif
            </div>
        @endforeach
    </div>
</div>
