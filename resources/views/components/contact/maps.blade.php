@props([
    'address' => null,
    'googleMaps' => null,
    'googleMapsIframe' => null,
])

<section class="py-5 bg-light">
    <div class="container-md">
        <div class="d-grid gap-3">
            <div>
                <h5 class="fw-bold">{{ trans('index.office_location') }}</h5>
                <h6>
                    <a draggable="false" class="text-secondary" href="{{ $googleMaps }}" target="_blank">
                        {{ $address }}
                    </a>
                </h6>
            </div>

            <iframe class="w-100 rounded-5" height="300" src="{{ $googleMapsIframe }}"></iframe>
        </div>
    </div>
</section>
