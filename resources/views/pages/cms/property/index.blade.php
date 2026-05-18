<?php

use App\Enums\Property\PropertyStatus;
use App\Exports\PropertyExport;
use App\Livewire\Component;
use App\Models\Property;
use App\Services\AreaService;
use App\Services\DistrictService;
use App\Services\PropertyService;
use App\Services\UserService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Property')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $user_id = '';

    #[Url(except: '')]
    public string $district_id = '';

    #[Url(except: '')]
    public string $area_id = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: '')]
    public string $start_date = '';

    #[Url(except: '')]
    public string $end_date = '';

    public function updating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search', 'user_id', 'district_id', 'area_id', 'status', 'start_date', 'end_date']);
    }

    public function delete(Property $property): void
    {
        $service = new PropertyService();
        $service->delete(property: $property);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.property') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function users(): object
    {
        $service = new UserService();
        return $service->index(roleName: 'Agent', isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function districts(): object
    {
        $service = new DistrictService();
        return $service->index(isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function areas(): object
    {
        $service = new AreaService();
        return $service->index(districtId: $this->district_id, isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function propertyStatuses(): array
    {
        return PropertyStatus::cases();
    }

    public function properties(bool $paginate = true): object
    {
        $service = new PropertyService();
        $properties = $service->index(search: $this->search, userId: $this->user_id, districtId: $this->district_id, areaId: $this->area_id, status: $this->status, startDate: $this->start_date, endDate: $this->end_date, paginate: $paginate);
        $properties->loadMissing(['user', 'district', 'area', 'owner', 'ownerRepresentative', 'image']);

        return $properties;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.property') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new PropertyService();
        $properties = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $properties->loadMissing(['user', 'district', 'area', 'owner', 'ownerRepresentative', 'image', 'createdBy', 'updatedBy']);

        return Excel::download(new PropertyExport(properties: $properties), trans('page.property') . '.xlsx');
    }
};
?>

@section('title', trans('page.property'))

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
                    <div class="col-12 col-sm-6 col-lg-3 col-xl">
                        <label class="form-label" for="user_id">
                            {{ trans('validation.attributes.user_id') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-user fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="user_id" name="user_id" wire:key="user_id"
                                wire:model.lazy="user_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.all') }} {{ trans('validation.attributes.user_id') }}
                                </option>
                                @foreach ($this->users() as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $user_id ? 'selected' : '' }}
                                        wire:key="user-{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3 col-xl">
                        <label class="form-label" for="district_id">
                            {{ trans('validation.attributes.district_id') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-city fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="district_id" name="district_id"
                                wire:key="district_id" wire:model.lazy="district_id" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.all') }} {{ trans('validation.attributes.district_id') }}
                                </option>
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

                    <div class="col-12 col-sm-6 col-lg-3 col-xl">
                        <label class="form-label" for="area_id">
                            {{ trans('validation.attributes.area_id') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-archway fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="area_id" name="area_id" wire:key="area_id"
                                wire:model.lazy="area_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.all') }} {{ trans('validation.attributes.area_id') }}
                                </option>
                                @foreach ($this->areas() as $area)
                                    <option value="{{ $area->id }}" {{ $area->id == $area_id ? 'selected' : '' }}
                                        wire:key="area-{{ $area->id }}">
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3 col-xl">
                        <label class="form-label" for="status">
                            {{ trans('validation.attributes.status') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-list fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="status" name="status" wire:key="status"
                                wire:model.lazy="status" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.all') }} {{ trans('validation.attributes.status') }}
                                </option>
                                @foreach ($this->propertyStatuses() as $propertyStatus)
                                    <option value="{{ $propertyStatus->value }}"
                                        wire:key="property-status-{{ $propertyStatus->value }}">
                                        {{ $propertyStatus->description() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6 col-sm-3 col-lg-auto">
                        <label class="form-label" for="start_date">
                            {{ trans('validation.attributes.start_date') }}
                        </label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                min="2026-01-01" max="2099-12-12" wire:key="start_date" wire:model.lazy="start_date"
                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                    </div>

                    <div class="col-6 col-sm-3 col-lg-auto">
                        <label class="form-label" for="end_date">
                            {{ trans('validation.attributes.end_date') }}
                        </label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                min="2026-01-01" max="2099-12-12" wire:key="end_date" wire:model.lazy="end_date"
                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
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
                @can('property.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.property.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            {{ trans('index.add') }}
                        </a>
                    </div>
                @endcan

                @can('property.export')
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
                            <th>
                                {{ trans('field.code') }} &
                                {{ trans('field.name') }} &
                                {{ trans('field.status') }}
                            </th>
                            <th width="1%">{{ trans('field.agent') }}</th>
                            <th width="1%">{{ trans('field.date') }}</th>
                            <th width="1%">
                                {{ trans('field.address') }} &
                                {{ trans('field.district_id') }} &
                                {{ trans('field.area_id') }}
                            </th>
                            <th width="1%">{{ trans('field.price') }}</th>
                            <th width="1%">{{ trans('field.owner') }} / {{ trans('field.representative') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->properties() as $property)
                            <tr wire:key="property-{{ $property->id }}">
                                <td class="text-center">
                                    {{ ($this->properties()->currentPage() - 1) * $this->properties()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.property.detail', ['property' => $property]) }}"
                                        wire:navigate>
                                        {{ $property->id }}
                                    </a>
                                </td>
                                <td class="p-0">
                                    @if ($property->image)
                                        <a draggable="false" href="{{ $property->image->image_url }}"
                                            target="_blank">
                                            <div class="ratio ratio-1x1">
                                                <img draggable="false" loading="lazy" decoding="async"
                                                    class="img-fluid w-100 h-100 object-fit-cover"
                                                    src="{{ $property->image->image_url }}"
                                                    alt="{{ trans('page.property') }} - {{ $property->id }}"
                                                    onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                                            </div>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">
                                        <a draggable="false"
                                            href="{{ route('cms.property.detail', ['property' => $property]) }}"
                                            wire:navigate>
                                            {{ $property->code }}
                                        </a>

                                        <span class="badge text-bg-{{ $property->status->color() }} rounded-pill">
                                            {{ $property->status->description() }}
                                        </span>

                                        <span class="badge text-bg-primary rounded-pill">
                                            <span class="fas fa-bed fa-fw"></span>
                                            {{ $property->bedroom?->description() ?? 0 }}
                                        </span>
                                    </div>
                                    <div>
                                        <a draggable="false"
                                            href="{{ route('cms.property.detail', ['property' => $property]) }}"
                                            wire:navigate>
                                            {{ $property->name }}
                                        </a>

                                        @if (in_array($property->status, [PropertyStatus::AcceptUpper, PropertyStatus::AcceptPremium]))
                                            <a draggable="false"
                                                href="{{ route('property.detail', ['slug' => $property->slug]) }}"
                                                target="_blank">
                                                <span class="fas fa-external-link fa-fw"></span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($property->user)
                                        <a draggable="false"
                                            href="{{ route('cms.user.detail', ['user' => $property->user]) }}"
                                            wire:navigate>
                                            {{ $property->user->name }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        {{ trans('index.availability') }} :
                                        {{ $property->availability_date?->isoFormat('ddd, DD MMM YYYY') }}
                                    </div>
                                    <div>
                                        {{ trans('index.visit') }} :
                                        {{ $property->visit_date?->isoFormat('ddd, DD MMM YYYY') }}
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $property->address }}</div>
                                    @if ($property->district)
                                        {{ trans('field.district_id') }} :
                                        <a draggable="false"
                                            href="{{ route('cms.district.detail', ['district' => $property->district]) }}"
                                            wire:navigate>
                                            {{ $property->district->name }}
                                        </a>
                                    @endif
                                    @if ($property->area)
                                        {{ trans('field.area_id') }} :
                                        <a draggable="false"
                                            href="{{ route('cms.area.detail', ['area' => $property->area]) }}"
                                            wire:navigate>
                                            {{ $property->area->name }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ Str::idr($property->monthly_price) }}</div>
                                    <div>{{ Str::idr($property->yearly_price) }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $property->owner?->name }} - {{ $property->owner?->phone }}</div>
                                    <div>{{ $property->ownerRepresentative?->name }} - {{ $property->ownerRepresentative?->phone }}</div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('property.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.property.detail', ['property' => $property]) }}"
                                                wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                {{ trans('index.detail') }}
                                            </a>
                                        @endcan

                                        @can('property.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.property.edit', ['property' => $property]) }}"
                                                wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                {{ trans('index.edit') }}
                                            </a>
                                        @endcan

                                        @can('property.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $property->id }})" wire:offline.class="disabled"
                                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $property->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    {{ trans('index.delete') }}
                                                </span>
                                                <span wire:loading wire:target="delete({{ $property->id }})"
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

            {{ $this->properties()->links('pagination') }}
        </div>
    </div>
</div>

@script
    <script>
        $("#user_id").on("change", function() {
            @this.set("user_id", $(this).val())
        })

        $("#district_id").on("change", function() {
            @this.set("district_id", $(this).val())
        })

        $("#area_id").on("change", function() {
            @this.set("area_id", $(this).val())
        })

        $("#status").on("change", function() {
            @this.set("status", $(this).val())
        })
    </script>
@endscript
