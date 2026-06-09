<div class="row g-3">
    <div class="col-sm-6">
        <a draggable="false" role="button" data-bs-toggle="modal" data-bs-target="#property-images">
            <img draggable="false" loading="lazy" decoding="async" class="img-fluid w-100 h-100 rounded user-select-none"
                src="{{ $property->image?->image_url ?? asset('images/placeholder.png') }}"
                alt="{{ trans('property.property') }} - {{ $property->name }} - {{ config('constants.title') }}" />
        </a>
    </div>
    <div class="col-sm-6">
        <div class="row g-3">
            @php($remainingImages = $property->images->count() - 5)

            @for ($i = 1; $i <= 4; $i++)
                <div class="col-6" wire:key="property-image-{{ $i }}">
                    @isset($property->images[$i])
                        <a draggable="false" role="button" class="position-relative d-block" data-bs-toggle="modal"
                            data-bs-target="#property-images"
                            onclick="setTimeout(() => document.getElementById('property-image-{{ $i }}')?.scrollIntoView({ behavior: 'smooth' }), 300)">

                            <img draggable="false" loading="lazy" decoding="async"
                                class="img-fluid w-100 h-100 rounded user-select-none pe-none"
                                src="{{ $property->images[$i]->image_url ?? asset('images/placeholder.png') }}"
                                alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">

                            @if ($i === 4 && $remainingImages > 0)
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 rounded"></div>

                                <div
                                    class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white text-center">
                                    <div class="fw-bold">+{{ $remainingImages }}</div>
                                    <div class="small">{{ trans('property.more_images') }}</div>
                                </div>
                            @endif
                        </a>
                    @else
                        <img draggable="false" loading="lazy" decoding="async"
                            class="img-fluid w-100 h-100 rounded user-select-none pe-none"
                            src="{{ asset('images/placeholder.png') }}"
                            alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">
                    @endisset
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
                        @foreach ($property->images as $key => $propertyImage)
                            <div class="zoom">
                                <img draggable="false" loading="lazy" decoding="async" class="img-fluid w-100 h-100 rounded"
                                    id="property-image-{{ $key }}"
                                    src="{{ $propertyImage->image_url ?? asset('images/placeholder.png') }}"
                                    alt="{{ trans('property.property') }} - {{ $propertyImage->name }} - {{ config('constants.title') }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endteleport
