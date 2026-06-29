<?php

use App\Exports\AreaExport;
use App\Livewire\Component;
use App\Models\Area;
use App\Services\AreaService;
use App\Services\DistrictService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Area')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $district_id = '';

    #[Url(except: [])]
    public array $is_promoted = [];

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

        $this->reset(['search', 'district_id', 'is_promoted', 'is_show', 'is_active']);
    }

    public function changePromoted(Area $area): void
    {
        $service = new AreaService();
        $service->promoted(area: $area);

        $this->alertSuccess(title: trans('index.change_promoted') . ' ' . trans('index.success'), body: trans('page.area') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function changeShow(Area $area): void
    {
        $service = new AreaService();
        $service->show(area: $area);

        $this->alertSuccess(title: trans('index.change_show') . ' ' . trans('index.success'), body: trans('page.area') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function changeActive(Area $area): void
    {
        $service = new AreaService();
        $service->active(area: $area);

        $this->alertSuccess(title: trans('index.change_active') . ' ' . trans('index.success'), body: trans('page.area') . ' ' . trans('message.has_been_successfully_changed'));
    }

    public function delete(Area $area): void
    {
        $service = new AreaService();
        $service->delete(area: $area);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.area') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function districts(): object
    {
        $service = new DistrictService();
        return $service->index(isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function areas(bool $paginate = true): object
    {
        $service = new AreaService();
        $areas = $service->index(search: $this->search, districtId: $this->district_id, isPromoted: $this->is_promoted, isShow: $this->is_show, isActive: $this->is_active, paginate: $paginate);
        $areas->loadMissing(['district']);
        $areas->loadCount(['contacts', 'properties']);

        return $areas;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.area') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new AreaService();
        $areas = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $areas->loadMissing(['district', 'createdBy', 'updatedBy']);
        $areas->loadCount(['contacts', 'properties']);

        return Excel::download(new AreaExport(areas: $areas), trans('page.area') . '.xlsx');
    }
};
?>

@section('title', trans('page.area'))

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
                    <div class="col">
                        <label class="form-label" for="district_id">
                            {{ trans('field.district_id') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-city fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="district_id" name="district_id"
                                wire:key="district_id" wire:model.lazy="district_id" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">{{ trans('index.all') }} {{ trans('page.district') }}</option>
                                @foreach ($this->districts() as $district)
                                    <option value="{{ $district->id }}"
                                        {{ $district->id == $district_id ? 'selected' : '' }}
                                        wire:key="district-{{ $district->id }}">
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-auto">
                        <label class="form-label" for="is_promoted">
                            {{ trans('field.is_promoted') }}
                        </label>
                        <div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_promoted_1" name="is_promoted"
                                    value="1" wire:model.lazy="is_promoted" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_promoted_1">
                                    {{ trans('index.yes') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_promoted_0" name="is_promoted"
                                    value="0" wire:model.lazy="is_promoted" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_promoted_0">
                                    {{ trans('no') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
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

                    <div class="col-auto">
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
                @can('area.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.area.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            <span>{{ trans('index.add') }}</span>
                        </a>
                    </div>
                @endcan

                @can('area.export')
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
                            <th width="1%">{{ trans('field.district_id') }}</th>
                            <th>{{ trans('field.name') }}</th>
                            <th width="1%">{{ trans('index.total') }} {{ trans('page.contact') }}</th>
                            <th width="1%">{{ trans('index.total') }} {{ trans('page.property') }}</th>
                            <th width="1%">{{ trans('field.created_at') }}</th>
                            <th width="1%">{{ trans('field.promoted') }}</th>
                            <th width="1%">{{ trans('field.show') }}</th>
                            <th width="1%">{{ trans('field.active') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->areas() as $area)
                            <tr wire:key="area-{{ $area->id }}">
                                <td class="text-center">
                                    {{ ($this->areas()->currentPage() - 1) * $this->areas()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false" href="{{ route('cms.area.detail', ['area' => $area]) }}"
                                        wire:navigate>
                                        {{ $area->id }}
                                    </a>
                                </td>
                                <td>
                                    @if ($area->district)
                                        <a draggable="false"
                                            href="{{ route('cms.district.detail', ['district' => $area->district]) }}"
                                            wire:navigate>
                                            {{ $area->district->name }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a draggable="false" href="{{ route('cms.area.detail', ['area' => $area]) }}"
                                        wire:navigate>
                                        {{ $area->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.contact.index', ['area_id' => $area->id]) }}"
                                        wire:navigate>
                                        {{ $area->contacts_count }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.property.index', ['area_id' => $area->id]) }}"
                                        wire:navigate>
                                        {{ $area->properties_count }}
                                    </a>
                                </td>
                                <td>{{ $area->created_at?->isoFormat('HH:mm - ddd, DD MMM YYYY') }}</td>
                                <td>
                                    @can('area.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_promoted_{{ $area->id }}" name="is_promoted" value="1"
                                                {{ $area->is_promoted ? 'checked' : '' }}
                                                wire:click="changePromoted({{ $area->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($area->is_promoted) }}"
                                                for="is_promoted_{{ $area->id }}">
                                                {{ Str::yesNo($area->is_promoted) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($area->is_promoted) }}">
                                            {{ Str::yesNo($area->is_promoted) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    @can('area.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_show_{{ $area->id }}" name="is_show" value="1"
                                                {{ $area->is_show ? 'checked' : '' }}
                                                wire:click="changeShow({{ $area->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label class="form-check-label text-{{ Str::successDanger($area->is_show) }}"
                                                for="is_show_{{ $area->id }}">
                                                {{ Str::yesNo($area->is_show) }}
                                            </label>
                                        </div>
                                    @else
                                        <span class="badge rounded-pill text-bg-{{ Str::successDanger($area->is_show) }}">
                                            {{ Str::yesNo($area->is_show) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    @can('area.edit')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="is_active_{{ $area->id }}" name="is_active" value="1"
                                                {{ $area->is_active ? 'checked' : '' }}
                                                wire:click="changeActive({{ $area->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                            <label
                                                class="form-check-label text-{{ Str::successDanger($area->is_active) }}"
                                                for="is_active_{{ $area->id }}">
                                                {{ Str::yesNo($area->is_active) }}
                                            </label>
                                        </div>
                                    @else
                                        <span
                                            class="badge rounded-pill text-bg-{{ Str::successDanger($area->is_active) }}">
                                            {{ Str::yesNo($area->is_active) }}
                                        </span>
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('area.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.area.detail', ['area' => $area]) }}" wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                <span>{{ trans('index.detail') }}</span>
                                            </a>
                                        @endcan

                                        @can('area.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.area.edit', ['area' => $area]) }}" wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                <span>{{ trans('index.edit') }}</span>
                                            </a>
                                        @endcan

                                        @can('area.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $area->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $area->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    <span>{{ trans('index.delete') }}</span>
                                                </span>
                                                <span wire:loading wire:target="delete({{ $area->id }})"
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

            {{ $this->areas()->links('pagination') }}
        </div>
    </div>
</div>

@script
    <script>
        $("#district_id").on("change", function() {
            @this.set("district_id", $(this).val())
        })
    </script>
@endscript
