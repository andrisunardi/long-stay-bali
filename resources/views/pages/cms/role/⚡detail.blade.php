<?php

use App\Livewire\Component;
use App\Services\RoleService;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Role;

new #[Title('Detail | Role')] class extends Component {
    public Role $role;

    public function mount(Role $role): void
    {
        $this->role = $role;
        $this->role->loadMissing(['permissions', 'users']);
        $this->role->loadCount(['permissions', 'users']);
    }

    public function delete(): void
    {
        $service = new RoleService();
        $service->delete(role: $this->role);

        session()->flash('success', [
            'title' => trans('index.delete') . ' ' . trans('index.success'),
            'message' => trans('page.role') . ' ' . trans('message.has_been_successfully_deleted'),
        ]);

        $this->redirect(route('cms.role.index'), navigate: true);
    }
};
?>

@section('title', trans('page.role'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-info">
            <span class="fas fa-list fa-fw"></span>
            {{ trans('index.detail') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-info w-100" href="{{ route('cms.role.index') }}" wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span>
                        {{ trans('index.back') }}
                    </a>
                </div>
            </div>

            <hr />

            <div class="d-grid gap-3">
                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $role->id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.name') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $role->name }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.guard_name') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $role->guard_name }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('index.total') }} {{ trans('page.permission') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <a draggable="false" href="{{ route('cms.permission.index', ['role_id' => $role->id]) }}"
                            wire:navigate>
                            {{ $role->permissions_count }}
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('index.total') }} {{ trans('page.user') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        <a draggable="false" href="{{ route('cms.user.index', ['role_id' => $role->id]) }}"
                            wire:navigate>
                            {{ $role->users_count }}
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($role->created_at)
                            {{ $role->created_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $role->created_at->diffForHumans() }})
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($role->updated_at)
                            {{ $role->updated_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $role->updated_at->diffForHumans() }})
                        @endif
                    </div>
                </div>
            </div>

            <hr />

            <div class="row g-3">
                <div class="col-lg-6">
                    <h6>{{ trans('index.list_permission') }} :</h6>
                    @foreach ($role->permissions as $permission)
                        <div>
                            {{ $loop->iteration }}.
                            <a draggable="false"
                                href="{{ route('cms.permission.detail', ['permission' => $permission]) }}">
                                {{ $permission->name }}
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-6">
                    <h6>{{ trans('index.list_user') }} :</h6>
                    @foreach ($role->users as $user)
                        <div>
                            {{ $loop->iteration }}.
                            <a draggable="false" href="{{ route('cms.user.detail', ['user' => $user]) }}">
                                {{ $user->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr />

            <div class="row g-3">
                @can('role.edit')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-success w-100"
                            href="{{ route('cms.role.edit', ['role' => $role]) }}" wire:navigate>
                            <span class="fas fa-edit fa-fw"></span>
                            {{ trans('index.edit') }}
                        </a>
                    </div>
                @endcan

                @can('role.delete')
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger w-100" wire:click="delete"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete">
                                <span class="fas fa-trash fa-fw"></span>
                                {{ trans('index.delete') }}
                            </span>
                            <span wire:loading wire:target="delete" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.delete') }}
                            </span>
                        </button>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
