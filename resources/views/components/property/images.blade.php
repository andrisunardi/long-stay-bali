<div class="row g-3">
    <div class="col-sm-6">
        <div class="ratio ratio-16x9 h-100">
            <a draggable="false" role="button" data-bs-toggle="modal" data-bs-target="#property-images">
                <img draggable="false" class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                    src="{{ $property->image?->image_url ?? asset('images/placeholder.png') }}"
                    alt="{{ trans('property.property') }} - {{ $property->name }} - {{ config('constants.title') }}" />
            </a>
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
                            <a draggable="false" role="button" data-bs-toggle="modal" data-bs-target="#property-images"
                                onclick="setTimeout(() => document.getElementById('property-image-{{ $propertyImage->id }}')?.scrollIntoView({ behavior: 'smooth' }), 300)">
                                <img draggable="false"
                                    class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                                    src="{{ $propertyImage->image_url ?? asset('images/placeholder.png') }}"
                                    alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">
                            </a>
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

@teleport('body')
    <div class="modal fade" id="property-images" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">
                        {{ $property->code }} - {{ $property->name }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="scroll-behavior:smooth;">
                    <div class="d-grid gap-4">
                        @foreach ($property->images as $propertyImage)
                            <img draggable="false" class="img-fluid w-100 h-100 rounded user-select-none pe-none"
                                id="property-image-{{ $propertyImage->id }}"
                                src="{{ $propertyImage->image_url ?? asset('images/placeholder.png') }}"
                                alt="{{ trans('property.property') }} - {{ $propertyImage->name }} - {{ config('constants.title') }}" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endteleport

<script></script>
