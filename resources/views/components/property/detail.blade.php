@props([
    'property' => null,
])

<section class="py-5">
    <div class="container-md">
        <div class="d-grid gap-4">
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="ratio ratio-16x9 h-100">
                        <img draggable="false"
                            class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
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
                                <div class="ratio ratio-16x9">
                                    <img draggable="false"
                                        class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                                        src="{{ $propertyImage->image_url ?? asset('images/placeholder.png') }}"
                                        alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">
                                </div>
                            </div>
                        @endforeach

                        @for ($i = $imageCount; $i < 4; $i++)
                            <div class="col-6" wire:key="property-placeholder-{{ $i }}">
                                <div class="ratio ratio-16x9">
                                    <img draggable="false"
                                        class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                                        src="{{ asset('images/placeholder.png') }}"
                                        alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <h1>{{ $property->name }}</h1>

                    <div class="d-flex gap-3">
                        <span class="px-2 py-1 small rounded bg-sand">
                            <span class="fas fa-location-dot fa-fw fa-xs text-success"></span>
                            <span class="text-black small">Villa</span>
                        </span>

                        <span class="px-2 py-1 small rounded bg-sand">
                            <span class="fas fa-bed fa-fw fa-xs text-success"></span>
                            <span class="text-black small">2 BR</span>
                        </span>
                    </div>

                    {{-- <div class="mt-3">
                        <span class="fas fa-location-dot fa-fw"></span>
                        {{ $property->address }}
                    </div> --}}

                    <hr class="my-4" />

                    <p class="mb-0">{!! $property->translate_description !!}</p>

                    <hr class="my-4" />

                    <h4 class="mb-3">Property details</h4>

                    <div class="d-grid gap-2">
                        <div class="row">
                            <div class="col-4">
                                Availability
                            </div>
                            <div class="col-8">
                                Chat for check availability on whatsapp
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Bedrooms
                            </div>
                            <div class="col-8">
                                2
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Bathrooms
                            </div>
                            <div class="col-8">
                                1
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Type Property
                            </div>
                            <div class="col-8">
                                Apartment
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Type Furnish
                            </div>
                            <div class="col-8">
                                Full furnished
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Rental Type
                            </div>
                            <div class="col-8">
                                {{ $property->rental_type?->description() }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Minimum Rental Period
                            </div>
                            <div class="col-8">
                                {{ $property->minimum_rental_duration_months }}
                                {{ trans('property.months') }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <h4 class="mb-3">What this home offers</h4>

                    <table class="table table-borderless text-nowrap">
                        <tr>
                            <td width="30%">
                                <span class="fas fa-utensils fa-fw"></span>
                                Kitchen
                            </td>
                            <td width="30%">
                                <span class="fas fa-wifi fa-fw"></span>
                                Wifi
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="fas fa-tv fa-fw"></span>
                                TV
                            </td>
                            <td>
                                <span class="fas fa-snowflake fa-fw"></span>
                                AC
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="fas fa-square-parking fa-fw"></span>
                                Free Parking
                            </td>
                            <td>
                                <span class="fas fa-fire-burner fa-fw"></span>
                                Oven
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="fas fa-water-ladder fa-fw"></span>
                                Pool
                            </td>
                            <td>
                                <span class="fas fa-dumbbell fa-fw"></span>
                                Gym
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="offset-xl-2 col-xl-4">
                    <div class="card card-body">
                        <h4>Pricing overview</h4>
                        <p>Prices may vary depending on length of stay and availability</p>

                        <div class="card card-body">
                            <div class="d-grid gap-2">
                                <div class="d-flex justify-content-between">
                                    <span class="text-secondary">{{ trans('property.monthly_from') }}</span>
                                    <span class="fw-medium">{{ Str::idr(9000000) }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-secondary">{{ trans('property.yearly_from') }}</span>
                                    <span class="fw-medium">{{ Str::idr(9000000 * 12) }}</span>
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-4">Planned stay</h4>

                        <button class="btn btn-outline-dark">
                            <span class="fas fa-calendar"></span>
                            04 May 2026 - 28 May 2026 (1 Month)
                        </button>

                        <hr />

                        <a draggable="false" class="btn btn-success w-100 rounded-pill"
                            href="https://api.whatsapp.com/send/?phone={{ config('constants.contact.whatsapp') }}&text=Hello, i know from your website solivingbali.com from property page"
                            target="_blank">
                            <i class="fab fa-whatsapp me-2"></i>
                            {{ trans('about.cta.button_name') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- <hr />

            <div class="d-grid gap-3">
                <div>
                    <h5 class="fw-bold">{{ trans('property.location_property') }}</h5>
                    <h6>
                        <a draggable="false" class="text-secondary"
                            href="{{ config('constants.contact.google_maps') }}" target="_blank">
                            {{ $property->address }}
                        </a>
                    </h6>
                </div>

                <iframe class="w-100 rounded-5" height="300"
                    src="{{ config('constants.contact.google_maps_iframe') }}"></iframe>
            </div> --}}
        </div>
    </div>
</section>
