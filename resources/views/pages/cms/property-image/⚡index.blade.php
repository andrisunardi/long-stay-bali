<?php

use App\Exports\PropertyImageExport;
use App\Livewire\Component;
use App\Models\PropertyImage;
use App\Services\PropertyService;
use App\Services\PropertyImageService;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

new #[Title('Property')] class extends Component {
    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $property_id = '';

    public function updating(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->resetPage();

        $this->reset(['search', 'property_id']);
    }

    public function delete(PropertyImage $propertyImage): void
    {
        $service = new PropertyImageService();
        $service->delete(propertyImage: $propertyImage);

        $this->alertSuccess(title: trans('index.delete') . ' ' . trans('index.success'), body: trans('page.property_image') . ' ' . trans('message.has_been_successfully_deleted'));
    }

    public function properties(): object
    {
        $service = new PropertyService();
        return $service->index(orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function propertyImages(bool $paginate = true): object
    {
        $service = new PropertyImageService();
        $propertyImages = $service->index(search: $this->search, propertyId: $this->property_id, paginate: $paginate);
        $propertyImages->loadMissing(['property']);

        return $propertyImages;
    }

    public function export(): BinaryFileResponse
    {
        $this->alertSuccess(title: trans('index.export') . ' ' . trans('index.success'), body: trans('page.property_image') . ' ' . trans('message.has_been_successfully_exported'));

        $service = new PropertyImageService();
        $propertyImages = $service->index(orderBy: 'id', sortBy: 'asc', paginate: false);
        $propertyImages->loadMissing(['property', 'createdBy', 'updatedBy']);

        return Excel::download(new PropertyImageExport(propertyImages: $propertyImages), trans('page.property_image') . '.xlsx');
    }
};
?>

@section('title', trans('page.property_image'))

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
                    <div class="col">
                        <label class="form-label" for="property_id">
                            {{ trans('validation.attributes.property_id') }}
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-building fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="property_id" name="property_id"
                                wire:key="property_id" wire:model.lazy="property_id" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.all') }} {{ trans('validation.attributes.property_id') }}
                                </option>
                                @foreach ($this->properties() as $property)
                                    <option value="{{ $property->id }}"
                                        {{ $property->id == $property_id ? 'selected' : '' }}
                                        wire:key="property-{{ $property->id }}">
                                        {{ $property->name }}
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
                @can('property_image.add')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.property-image.add') }}"
                            wire:navigate>
                            <span class="fas fa-plus fa-fw"></span>
                            {{ trans('index.add') }}
                        </a>
                    </div>
                @endcan

                @can('property_image.export')
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
                <table class="table table-striped table-hover table-bordered text-nowrap table-responsive align-middle">
                    <thead>
                        <tr class="text-center align-middle table-primary">
                            <th width="1%">{{ trans('field.#') }}</th>
                            <th width="1%">{{ trans('field.id') }}</th>
                            <th width="1%">{{ trans('field.image') }}</th>
                            <th width="1%">{{ trans('field.property_id') }}</th>
                            <th>{{ trans('field.name') }}</th>
                            <th>{{ trans('field.description') }}</th>
                            <th width="1%">{{ trans('field.created_at') }}</th>
                            <th width="1%">{{ trans('field.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($this->propertyImages() as $propertyImage)
                            <tr wire:key="property-image-{{ $propertyImage->id }}">
                                <td class="text-center">
                                    {{ ($this->propertyImages()->currentPage() - 1) * $this->propertyImages()->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    <a draggable="false"
                                        href="{{ route('cms.property-image.detail', ['propertyImage' => $propertyImage]) }}"
                                        wire:navigate>
                                        {{ $propertyImage->id }}
                                    </a>
                                </td>
                                <td class="p-0">
                                    @if ($propertyImage->image_path)
                                        <a draggable="false" href="{{ $propertyImage->image }}" target="_blank">
                                            <div class="ratio ratio-1x1">
                                                <img draggable="false" loading="lazy" decoding="async"
                                                    class="img-fluid w-100 h-100 object-fit-cover"
                                                    src="{{ $propertyImage->image }}"
                                                    alt="{{ trans('page.property_image') }} - {{ $propertyImage->id }}"
                                                    onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                                            </div>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($propertyImage->property)
                                        <a draggable="false"
                                            href="{{ route('cms.property.detail', ['property' => $propertyImage->property]) }}"
                                            wire:navigate>
                                            {{ $propertyImage->property->name }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a draggable="false"
                                        href="{{ route('cms.property-image.detail', ['propertyImage' => $propertyImage]) }}"
                                        wire:navigate>
                                        {{ $propertyImage->name }}
                                    </a>
                                </td>
                                <td class="text-wrap">{{ $propertyImage->description }}</td>
                                <td>{{ $propertyImage->created_at?->isoFormat('HH:mm - ddd, DD MMM YYYY') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @can('property_image.detail')
                                            <a draggable="false" class="btn btn-info btn-sm"
                                                href="{{ route('cms.property-image.detail', ['propertyImage' => $propertyImage]) }}"
                                                wire:navigate>
                                                <span class="fas fa-list fa-fw"></span>
                                                {{ trans('index.detail') }}
                                            </a>
                                        @endcan

                                        @can('property_image.edit')
                                            <a draggable="false" class="btn btn-success btn-sm"
                                                href="{{ route('cms.property-image.edit', ['propertyImage' => $propertyImage]) }}"
                                                wire:navigate>
                                                <span class="fas fa-edit fa-fw"></span>
                                                {{ trans('index.edit') }}
                                            </a>
                                        @endcan

                                        @can('property_image.delete')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="delete({{ $propertyImage->id }})"
                                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="delete({{ $propertyImage->id }})">
                                                    <span class="fas fa-trash fa-fw"></span>
                                                    {{ trans('index.delete') }}
                                                </span>
                                                <span wire:loading wire:target="delete({{ $propertyImage->id }})"
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

            {{ $this->propertyImages()->links('pagination') }}
        </div>
    </div>
</div>

@script
    <script>
        $("#property_id").on("change", function() {
            @this.set("property_id", $(this).val())
        })
    </script>
@endscript
