<?php

use App\Exports\ValueExport;
use App\Livewire\Component;
use App\Models\Value;
use App\Services\ValueService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Value')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: [])]
    public array $is_active = [];

    public function updating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search', 'is_active']);
    }

    public function changeActive(Value $value): void
    {
        $service = new ValueService();
        $service->active(value: $value);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.value') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(Value $value): void
    {
        $service = new ValueService();
        $service->delete(value: $value);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.value') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function values(bool $paginate = true): object
    {
        $service = new ValueService();
        $values = $service->index(search: $this->search, isActive: $this->is_active, paginate: $paginate);

        return $values;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.value') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new ValueService();
        $values = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $values->loadMissing(['createdBy', 'updatedBy']);

        return Excel::download(new ValueExport(values: $values), trans('page.value') . '.xlsx');
    }
};
?>

@section('title', trans('page.value'))

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
                                maxlength="50" placeholder="{{ trans('field.search') }}" wire:model.lazy="search"
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
                    <div class="col-sm-auto">
                        <label class="form-label" for="is_active">
                            {{ trans('field.is_active') }}
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
                @can('value.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.value.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            <span>{{ trans('index.add') }}</span>
                        </a>
                    </div>
                @endcan

                @can('value.export')
                    <div class="col-auto">
                        <button type="button" class="btn btn-success w-100" wire:click="export"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="export">
                                <span class="fas fa-file-excel fa-fw"></span>
                                <span>{{ trans('index.export') }}</span>
                            </span>
                            <span wire:loading wire:target="export" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>{{ trans('index.export') }}</span>
                            </span>
                        </button>
                    </div>
                @endcan
            </div>

            <hr />

            <div class="table-responsive border-bottom mb-3">
                <table class="table table-striped table-hover table-bordered text-nowrap table-responsive align-middle">
                    <thead>
                        <tr class="text-center align-middle table-primary">
                            <th width="1%">{{ trans('field.#') }}</th>
                            <th width="1%">{{ trans('field.id') }}</th>
                            <th>{{ trans('field.title') }}</th>
                            <th>{{ trans('field.short_description') }}</th>
                            <th>{{ trans('field.description') }}</th>
                            <th width="1%">{{ trans('field.icon') }}</th>
                            <th width="1%">{{ trans('field.active') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->values() as $value)
                            <tr wire:key="value-{{ $value->id }}">
                                <td class="text-center">
                                    {{ ($this->values()->currentPage() - 1) * $this->values()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.value.detail', ['value' => $value]) }}"
                                        wire:navigate>
                                        {{ $value->id }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false"
                                        href="{{ route('cms.value.detail', ['value' => $value]) }}"
                                        wire:navigate>
                                        {{ $value->title }}
                                    </a>
                                    <div>{{ $value->title_id }}</div>
                                    <div>{{ $value->title_zh }}</div>
                                    <div>{{ $value->title_fr }}</div>
                                </td>
                                <td>
                                    <div>{{ $value->short_description }}</div>
                                    <div>{{ $value->short_description_id }}</div>
                                    <div>{{ $value->short_description_zh }}</div>
                                    <div>{{ $value->short_description_fr }}</div>
                                </td>
                                <td>
                                    <div>{{ $value->description }}</div>
                                    <div>{{ $value->description_id }}</div>
                                    <div>{{ $value->description_zh }}</div>
                                    <div>{{ $value->description_fr }}</div>
                                </td>
                                <td>
                                    <div>{{ $value->icon }}</div>
                                    <div><span class="{{ $value->icon }}"></span></div>
                                </td>
                                <td>
                                    @can('value.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_active_{{ $value->id }}" name="is_active" value="1"
                                                {{ $value->is_active ? 'checked' : '' }}
                                                wire:click="changeActive({{ $value->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($value->is_active) }}"
                                                for="is_active_{{ $value->id }}">
                                                {{ Str::yesNo($value->is_active) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($value->is_active) }}">
                                            {{ Str::yesNo($value->is_active) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('value.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.value.detail', ['value' => $value]) }}"
                                                wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                <span>{{ trans('index.detail') }}</span>
                                            </a>
                                        @endcan

                                        @can('value.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.value.edit', ['value' => $value]) }}"
                                                wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                <span>{{ trans('index.edit') }}</span>
                                            </a>
                                        @endcan

                                        @can('value.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $value->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $value->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                                <span wire:loading wire:target="delete({{ $value->id }})"
                                                    class="w-100">
                                                    <span class="spinner-border spinner-border-sm"></span>
                                                    <span>{{ trans('index.delete') }}</span>
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

            {{ $this->values()->links('pagination') }}
        </div>
    </div>
</div>
