<div class="row g-3">
    <div class="col-sm-6">
        <div class="ratio ratio-16x9 h-100">
            <img draggable="false" class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                src="{{ $property->image?->image_url ?? asset('images/placeholder.png') }}"
                alt="{{ trans('property.property') }} - {{ $property->name }} - {{ config('constants.title') }}" />
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row g-3">
            @php
                $propertyImages = $property->images->take(4);
                $imageCount = $propertyImages->count();
            @endphp

            @foreach ($propertyImages as $propertyImage)
                <div class="col-6" wire:key="property-image-{{ $propertyImage->id }}">
                    @if ($loop->last)
                        <div class="position-relative rounded overflow-hidden">
                            <img draggable="false"
                                class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                                src="{{ $propertyImage->image_url ?? asset('images/placeholder.png') }}"
                                alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">

                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50">
                            </div>

                            <button
                                class="btn btn-light btn-sm rounded-pill position-absolute bottom-0 end-0 mb-3 me-3">
                                View all photos
                            </button>
                        </div>
                    @else
                        <div class="ratio ratio-16x9">
                            <img draggable="false"
                                class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                                src="{{ $propertyImage->image_url ?? asset('images/placeholder.png') }}"
                                alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">
                        </div>
                    @endif
                </div>
            @endforeach

            @for ($i = $imageCount; $i < 4; $i++)
                <div class="col-6" wire:key="property-placeholder-{{ $i }}">
                    @if ($i === 3)
                        <div class="position-relative rounded overflow-hidden">
                            <img draggable="false"
                                class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                                src="{{ asset('images/placeholder.png') }}"
                                alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">

                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50">
                            </div>

                            <button
                                class="btn btn-light btn-sm rounded-pill position-absolute bottom-0 end-0 mb-3 me-3 small">
                                View all photos
                            </button>
                        </div>
                    @else
                        <div class="ratio ratio-16x9">
                            <img draggable="false"
                                class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                                src="{{ asset('images/placeholder.png') }}"
                                alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">
                        </div>
                    @endif
                </div>
            @endfor
        </div>
    </div>
</div>
