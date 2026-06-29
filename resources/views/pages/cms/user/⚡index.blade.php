<?php

use App\Exports\UserExport;
use App\Livewire\Component;
use App\Models\User;
use App\Services\RoleService;
use App\Services\PermissionService;
use App\Services\UserService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('User')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: [])]
    public array $is_active = [];

    #[Url(except: '')]
    public string $role_id = '';

    #[Url(except: '')]
    public string $permission_id = '';

    public function updating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search', 'is_active', 'role_id', 'permission_id']);
    }

    public function changeActive(User $user): void
    {
        $service = new UserService();
        $service->active(user: $user);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.user') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(User $user): void
    {
        $service = new UserService();
        $service->delete(user: $user);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.user') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function roles(): object
    {
        $service = new RoleService();
        return $service->index(guardName: 'web', orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function permissions(): object
    {
        $service = new PermissionService();
        return $service->index(guardName: 'web', orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function users(bool $paginate = true): object
    {
        $service = new UserService();
        $users = $service->index(search: $this->search, isActive: $this->is_active, roleId: $this->role_id, permissionId: $this->permission_id, paginate: $paginate);
        $users->loadCount(['properties', 'roles', 'permissions']);
        $users->loadMissing(['roles']);

        return $users;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.user') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new UserService();
        $users = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $users->loadCount(['properties', 'roles', 'permissions']);
        $users->loadMissing(['roles', 'createdBy', 'updatedBy']);

        return Excel::download(new UserExport(users: $users), trans('page.user') . '.xlsx');
    }
};
?>

@section('title', trans('page.user'))

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
                    <div class="col-sm-6 col-md" wire:ignore>
                        <label class="form-label" for="role_id">
                            {{ trans('validation.attributes.role_id') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-key fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="role_id" name="role_id" wire:model.lazy="role_id"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.all') }}
                                    {{ trans('validation.attributes.role_id') }}
                                </option>
                                @foreach ($this->roles() as $role)
                                    <option value="{{ $role->id }}" wire:key="role-{{ $role->id }}"
                                        {{ $role->id == $role_id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md" wire:ignore>
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
                                    {{ trans('index.all') }}
                                    {{ trans('validation.attributes.permission_id') }}
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

                    <div class="col-sm-auto">
                        <label class="form-label" for="is_active">
                            {{ trans('validation.attributes.is_active') }}
                        </label>
                        <div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active_1" name="is_active"
                                    value="1" wire:model.lazy="is_active" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_active_1">
                                    {{ trans('index.yes') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active_0" name="is_active"
                                    value="0" wire:model.lazy="is_active" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_active_0">
                                    {{ trans('index.no') }}
                                </label>
                            </div>
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
                @can('user.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.user.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            {{ trans('index.add') }}
                        </a>
                    </div>
                @endcan

                @can('user.export')
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
                            <th width="1%">{{ trans('field.#') }}</th>
                            <th width="1%">{{ trans('field.id') }}</th>
                            <th width="1%">{{ trans('field.image') }}</th>
                            <th>{{ trans('field.name') }}</th>
                            <th>{{ trans('field.email') }}</th>
                            <th>{{ trans('field.phone') }}</th>
                            <th>{{ trans('field.username') }}</th>
                            <th>{{ trans('field.created_at') }}</th>
                            <th>{{ trans('field.roles') }}</th>
                            <th width="1%">{{ trans('index.total') }}</th>
                            <th width="1%">{{ trans('field.active') }}</th>
                            <th width="1%">{{ trans('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->users() as $user)
                            <tr wire:key="user-{{ $user->id }}">
                                <td class="text-center">
                                    {{ ($this->users()->currentPage() - 1) * $this->users()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false" href="{{ route('cms.user.detail', ['user' => $user]) }}"
                                        wire:navigate>
                                        {{ $user->id }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if ($user->image_path)
                                        <a draggable="false" href="{{ $user->image }}" target="_blank">
                                            <div class="ratio ratio-1x1">
                                                <img draggable="false" loading="lazy" decoding="async"
                                                    class="img-fluid w-100 h-100 rounded-circle object-fit-cover"
                                                    src="{{ $user->image }}"
                                                    alt="{{ trans('page.user') }} - {{ $user->id }}"
                                                    onerror="asset('images/user.png')" />
                                            </div>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a draggable="false" href="{{ route('cms.user.detail', ['user' => $user]) }}"
                                        wire:navigate>
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false" href="mailto:{{ $user->email }}">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false"
                                        href="https://api.whatsapp.com/send?phone={{ Str::slug($user->phone, '') }}"
                                        target="_blank">
                                        {{ $user->phone }}
                                    </a>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->created_at?->isoFormat('HH:mm - ddd, DD MMM YYYY') }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <div wire:key="role-{{ $role->id }}">
                                            <a draggable="false"
                                                href="{{ route('cms.role.detail', ['role' => $role]) }}">
                                                {{ $loop->iteration }}. {{ $role->name }}
                                            </a>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    <div>
                                        {{ trans('page.property') }} :
                                        <a draggable="false"
                                            href="{{ route('cms.property.index', ['user_id' => $user->id]) }}"
                                            wire:navigate>
                                            {{ $user->properties_count }}
                                        </a>
                                    </div>
                                    <div>{{ trans('page.role') }} : {{ $user->roles_count }}</div>
                                    <div>{{ trans('page.permission') }} : {{ $user->permissions_count }}</div>
                                </td>
                                <td>
                                    @can('user.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_active_{{ $user->id }}" name="is_active" value="1"
                                                {{ $user->is_active ? 'checked' : '' }}
                                                wire:click="changeActive({{ $user->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($user->is_active) }}"
                                                for="is_active_{{ $user->id }}">
                                                {{ Str::yesNo($user->is_active) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($user->is_active) }}">
                                            {{ Str::yesNo($user->is_active) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('user.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.user.detail', ['user' => $user]) }}" wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                {{ trans('index.detail') }}
                                            </a>
                                        @endcan

                                        @can('user.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.user.edit', ['user' => $user]) }}" wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                {{ trans('index.edit') }}
                                            </a>
                                        @endcan

                                        @can('user.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $user->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $user->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    {{ trans('index.delete') }}
                                                </span>
                                                <span wire:loading wire:target="delete({{ $user->id }})"
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

            {{ $this->users()->links('pagination') }}
        </div>
    </div>
</div>

@script
    <script>
        $("#role_id").on("change", function() {
            @this.set("role_id", $(this).val())
        })
        $("#permission_id").on("change", function() {
            @this.set("permission_id", $(this).val())
        })
    </script>
@endscript
