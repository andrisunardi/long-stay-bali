<?php

use App\Exports\DistrictExport;
use App\Livewire\Component;
use App\Models\District;
use App\Services\DistrictService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('District')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: [])]
    public array $is_show = [];

    #[Url(except: [])]
    public array $is_active = [];

    public function updating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search', 'is_show', 'is_active']);
    }

    public function changeShow(District $district): void
    {
        $service = new DistrictService();
        $service->show(district: $district);

        $this->alertSuccess(title: trans('index.change_show') . ' ' . trans('index.success'), body: trans('page.district') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function changeActive(District $district): void
    {
        $service = new DistrictService();
        $service->active(district: $district);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.district') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(District $district): void
    {
        $service = new DistrictService();
        $service->delete(district: $district);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.district') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function districts(bool $paginate = true): object
    {
        $service = new DistrictService();
        $districts = $service->index(search: $this->search, isShow: $this->is_show, isActive: $this->is_active, paginate: $paginate);
        $districts->loadCount(['areas', 'contacts', 'properties']);

        return $districts;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.district') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new DistrictService();
        $districts = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $districts->loadCount(['areas', 'contacts', 'properties']);
        $districts->loadMissing(['createdBy', 'updatedBy']);

        return Excel::download(new DistrictExport(districts: $districts), trans('page.district') . '.xlsx');
    }
};
?>

@section('title', trans('page.district'))

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
                        <label class="form-label" for="is_show">
                            {{ trans('field.is_show') }}
                        </label>
                        <div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_show_1" name="is_show"
                                    value="1" wire:model.lazy="is_show" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_show_1">
                                    {{ trans('index.yes') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_show_0" name="is_show"
                                    value="0" wire:model.lazy="is_show" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_show_0">
                                    {{ trans('no') }}
                                </label>
                            </div>
                        </div>
                    </div>

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
                @can('district.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.district.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            <span>{{ trans('index.add') }}</span>
                        </a>
                    </div>
                @endcan

                @can('district.export')
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
                <table
                    class="table table-striped table-hover table-bordered text-nowrap table-responsive align-middle">
                    <thead>
                        <tr class="text-center align-middle table-primary">
                            <th width="1%">{{ trans('field.#') }}</th>
                            <th width="1%">{{ trans('field.id') }}</th>
                            <th>{{ trans('field.name') }}</th>
                            <th width="1%">{{ trans('index.total') }} {{ trans('page.area') }}</th>
                            <th width="1%">{{ trans('index.total') }} {{ trans('page.contact') }}</th>
                            <th width="1%">{{ trans('index.total') }} {{ trans('page.property') }}</th>
                            <th width="1%">{{ trans('field.created_at') }}</th>
                            <th width="1%">{{ trans('field.show') }}</th>
                            <th width="1%">{{ trans('field.active') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->districts() as $district)
                            <tr wire:key="district-{{ $district->id }}">
                                <td class="text-center">
                                    {{ ($this->districts()->currentPage() - 1) * $this->districts()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.district.detail', ['district' => $district]) }}"
                                        wire:navigate>
                                        {{ $district->id }}
                                    </a>
                                </td>
                                <td>
                                    <a draggable="false"
                                        href="{{ route('cms.district.detail', ['district' => $district]) }}"
                                        wire:navigate>
                                        {{ $district->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.area.index', ['district_id' => $district->id]) }}"
                                        wire:navigate>
                                        {{ $district->areas_count }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.contact.index', ['district_id' => $district->id]) }}"
                                        wire:navigate>
                                        {{ $district->contacts_count }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.property.index', ['district_id' => $district->id]) }}"
                                        wire:navigate>
                                        {{ $district->properties_count }}
                                    </a>
                                </td>
                                <td>{{ $district->created_at?->isoFormat('HH:mm - ddd, DD MMM YYYY') }}</td>
                                <td>
                                    @can('district.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_show_{{ $district->id }}" name="is_show" value="1"
                                                {{ $district->is_show ? 'checked' : '' }}
                                                wire:click="changeShow({{ $district->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($district->is_show) }}"
                                                for="is_show_{{ $district->id }}">
                                                {{ Str::yesNo($district->is_show) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($district->is_show) }}">
                                            {{ Str::yesNo($district->is_show) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    @can('district.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_active_{{ $district->id }}" name="is_active" value="1"
                                                {{ $district->is_active ? 'checked' : '' }}
                                                wire:click="changeActive({{ $district->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($district->is_active) }}"
                                                for="is_active_{{ $district->id }}">
                                                {{ Str::yesNo($district->is_active) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($district->is_active) }}">
                                            {{ Str::yesNo($district->is_active) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('district.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.district.detail', ['district' => $district]) }}"
                                                wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                <span>{{ trans('index.detail') }}</span>
                                            </a>
                                        @endcan

                                        @can('district.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.district.edit', ['district' => $district]) }}"
                                                wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                <span>{{ trans('index.edit') }}</span>
                                            </a>
                                        @endcan

                                        @can('district.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $district->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $district->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                                <span wire:loading wire:target="delete({{ $district->id }})"
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

            {{ $this->districts()->links('pagination') }}
        </div>
    </div>
</div>
