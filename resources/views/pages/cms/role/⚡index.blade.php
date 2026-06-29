<?php

use App\Exports\RoleExport;
use App\Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Services\PermissionService;
use App\Services\RoleService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Role')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $permission_id = '';

    public function updating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search', 'permission_id']);
    }

    public function delete(Role $role): void
    {
        $service = new RoleService();
        $service->delete(role: $role);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.role') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function permissions(): object
    {
        $service = new PermissionService();
        return $service->index(orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function roles(bool $paginate = true): object
    {
        $service = new RoleService();
        $roles = $service->index(search: $this->search, guardName: 'web', permissionId: $this->permission_id, paginate: $paginate);
        $roles->loadMissing(['permissions', 'users']);

        return $roles;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.role') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new RoleService();
        $roles = $service->index(guardName: 'web', orderBy: 'id', sortBy: 'asc', paginate: false);
        $roles->loadCount(['permissions', 'users']);
        return Excel::download(new RoleExport(roles: $roles), trans('page.role') . '.xlsx');
    }
};
?>

@section('title', trans('page.role'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-search fa-fw"></span>
            {{ trans('index.search') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="d-grid gap-3">
                <div class="row g-3">
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-search fa-fw "></span>
                            </div>
                            <input type="search" class="form-control" id="search" name="search" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.search') }}" wire:model.lazy="search"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="button" class="btn btn-warning" wire:click="resetFilter"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="resetFilter">
                                <span class="fas fa-eraser fa-fw"></span>
                                {{ trans('index.reset_filter') }}
                            </span>
                            <span wire:loading wire:target="resetFilter" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.reset_filter') }}
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col" wire:ignore>
                        <label class="form-label" for="permission_id">
                            {{ trans('validation.attributes.permission_id') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-lock-open fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="permission_id" name="permission_id"
                                wire:model.lazy="permission_id" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.all') }} {{ trans('validation.attributes.permission_id') }}
                                </option>
                                @foreach ($this->permissions() as $permission)
                                    <option value="{{ $permission->id }}" wire:key="permission-{{ $permission->id }}"
                                        {{ $permission->id == $permission_id ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header text-bg-primary">
            <span class="fas fa-table fa-fw"></span>
            {{ trans('index.data') }} @yield('title')
        </div>

        <div class="card-body">
            <div class="row g-3">
                @can('role.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.role.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            {{ trans('add') }}
                        </a>
                    </div>
                @endcan

                @can('role.export')
                    <div class="col-auto">
                        <button type="button" class="btn btn-success w-100" wire:click="export"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="export">
                                <span class="fas fa-file-excel fa-fw"></span>
                                {{ trans('index.export') }}
                            </span>
                            <span wire:loading wire:target="export" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.export') }}
                            </span>
                        </button>
                    </div>
                @endcan
            </div>

            <hr />

            <div class="table-responsive border-bottom mb-3">
                <table
                    class="table table-striped table-hover table-bordered text-nowrap table-responsive align-middle">
                    <thead>
                        <tr class="text-center align-middle table-primary">
                            <th width="1%">#</th>
                            <th width="1%">{{ trans('field.id') }}</th>
                            <th>{{ trans('field.name') }}</th>
                            <th width="1%">{{ trans('field.guard_name') }}</th>
                            <th width="1%">{{ trans('index.total') }} {{ trans('page.permission') }}</th>
                            <th width="1%">{{ trans('index.total') }} {{ trans('page.user') }}</th>
                            <th width="1%">{{ trans('field.created_at') }}</th>
                            <th width="1%">{{ trans('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->roles() as $role)
                            <tr wire:key="role-{{ $role->id }}">
                                <td class="text-center">
                                    {{ ($this->roles()->currentPage() - 1) * $this->roles()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false" href="{{ route('cms.role.detail', ['role' => $role]) }}"
                                        wire:navigate>
                                        {{ $role->id }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false" href="{{ route('cms.role.detail', ['role' => $role]) }}"
                                        wire:navigate>
                                        {{ $role->name }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $role->guard_name }}</td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.permission.index', ['role_id' => $role->id]) }}"
                                        wire:navigate>
                                        {{ $role->permissions->count() }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.user.index', ['role_id' => $role->id]) }}" wire:navigate>
                                        {{ $role->users->count() }}
                                    </a>
                                </td>
                                <td>{{ $role->created_at?->isoFormat('HH:mm - ddd, DD MMM YYYY') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('role.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.role.detail', ['role' => $role]) }}" wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                {{ trans('index.detail') }}
                                            </a>
                                        @endcan

                                        @can('role.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.role.edit', ['role' => $role]) }}" wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                {{ trans('index.edit') }}
                                            </a>
                                        @endcan

                                        @can('role.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $role->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $role->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    {{ trans('index.delete') }}
                                                </span>
                                                <span wire:loading wire:target="delete({{ $role->id }})"
                                                    class="w-100">
                                                    <span class="spinner-border spinner-border-sm"></span>
                                                    {{ trans('index.delete') }}
                                                </span>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="100%">
                                    {{ trans('message.no_data_available') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $this->roles()->links('pagination') }}
        </div>
    </div>
</div>

@script
    <script>
        $("#permission_id").on("change", function() {
            @this.set("permission_id", $(this).val())
        })
    </script>
@endscript
