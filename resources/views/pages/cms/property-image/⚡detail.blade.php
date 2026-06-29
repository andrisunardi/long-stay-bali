<?php

use App\Livewire\Component;
use App\Models\PropertyImage;
use App\Services\PropertyImageService;
use Livewire\Attributes\Title;

new #[Title('Detail | Property Image')] class extends Component {
    public PropertyImage $propertyImage;

    public function mount(PropertyImage $propertyImage): void
    {
        $this->propertyImage = $propertyImage;
    }

    public function delete(): void
    {
        $service = new PropertyImageService();
        $service->delete(propertyImage: $this->propertyImage);

        session()->flash('success', [
            'title' => trans('index.delete') . ' ' . trans('index.success'),
            'message' => trans('page.property_image') . ' ' . trans('message.has_been_successfully_deleted'),
        ]);

        $this->redirect(route('cms.property-image.index'), navigate: true);
    }
};
?>

@section('title', trans('page.property_image'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-info">
            <span class="fas fa-list fa-fw"></span>
            {{ trans('index.detail') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-info w-100" href="{{ route('cms.property-image.index') }}"
                        wire:navigate>
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
                        {{ $propertyImage->id }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.property_id') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($propertyImage->property)
                            <a draggable="false"
                                href="{{ route('cms.property.detail', ['property' => $propertyImage->property]) }}"
                                wire:navigate>
                                {{ $propertyImage->property->name }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.name') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $propertyImage->name }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.description') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $propertyImage->description }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">Image</div>
                    </div>
                    <div class="col-sm-7 col-md-6 col-lg-5 col-xl-4">
                        @if ($propertyImage->image_path)
                            <a draggable="false" href="{{ $propertyImage->image }}" target="_blank">
                                <img draggable="false" loading="lazy" decoding="async"
                                    class="img-fluid w-100 h-100 rounded mt-2" src="{{ $propertyImage->image }}"
                                    alt="{{ trans('page.property_image') }} - {{ $propertyImage->id }}"
                                    onerror="this.src='{{ asset('images/image-not-available.png') }}'" />
                            </a>
                        @endif
                    </div>
                </div>

                <br />

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $propertyImage->createdBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_by') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        {{ $propertyImage->updatedBy?->name ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.created_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($propertyImage->created_at)
                            {{ $propertyImage->created_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $propertyImage->created_at->diffForHumans() }})
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
                        <div class="fw-bold">{{ trans('field.updated_at') }}</div>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
                        @if ($propertyImage->updated_at)
                            {{ $propertyImage->updated_at->isoFormat('LLLL') }}
                            <br class="d-lg-none">
                            ({{ $propertyImage->updated_at->diffForHumans() }})
                        @endif
                    </div>
                </div>
            </div>

            <hr />

            <div class="row g-3">
                @can('propertyImage.edit')
                    <div class="col-auto">
                        <a draggable="false" class="btn btn-success w-100"
                            href="{{ route('cms.property-image.edit', ['propertyImage' => $propertyImage]) }}"
                            wire:navigate>
                            <span class="fas fa-edit fa-fw"></span>
                            {{ trans('index.edit') }}
                        </a>
                    </div>
                @endcan

                @can('propertyImage.delete')
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

    <livewire:activity-log :model="$propertyImage" />
</div>
