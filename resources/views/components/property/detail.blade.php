@props([
    'property' => null,
])

<section class="py-5">
    <div class="container-md">
        <div class="d-grid gap-4">
            <x-property.images :property="$property" />

            <div class="row">
                <div class="col-xl-7">
                    <h1>{{ $property->name }}</h1>

                    <div class="d-flex gap-3">
                        <span class="px-2 py-1 small rounded bg-sand">
                            <span class="fas fa-code fa-fw fa-xs text-success"></span>
                            <span class="text-black small">{{ $property->code }}</span>
                        </span>

                        <span class="px-2 py-1 small rounded bg-sand">
                            <span class="fas fa-city fa-fw fa-xs text-success"></span>
                            <span class="text-black small">{{ $property->area?->district?->name ?? 'Bali' }}</span>
                        </span>

                        <span class="px-2 py-1 small rounded bg-sand">
                            <span class="fas fa-bed fa-fw fa-xs text-success"></span>
                            <span class="text-black small">{{ $property->bedroom->value }}</span>
                        </span>
                    </div>

                    {{-- <div class="mt-3">
                        <span class="fas fa-location-dot fa-fw"></span>
                        {{ $property->address }}
                    </div> --}}

                    <hr class="my-4" />

                    <p class="mb-0">
                        @if ($property->translate_description)
                            {!! $property->translate_description !!}
                        @else
                            <span class="fst-italic text-muted">No Description About This Property</span>
                        @endif
                    </p>

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
                                {{ $property->bedroom->value }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Bathrooms
                            </div>
                            <div class="col-8">
                                {{ $property->number_of_bathrooms ?? 0 }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Type Property
                            </div>
                            <div class="col-8">
                                Villa
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                Type Furnish
                            </div>
                            <div class="col-8">
                                {{ $property->fully_furnished ? 'Full furnished' : 'Non furnished' }}
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

                <div class="offset-xl-2 col-xl-3">
                    <div class="sticky-top" style="top: 5rem">
                        <div class="card card-body">
                            <div class="d-grid gap-2">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-medium">{{ Str::idr($property->monthly_price) }}</span>
                                    <span class="text-secondary">{{ trans('property.per_month') }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-medium">{{ Str::idr($property->yearly_price) }}</span>
                                    <span class="text-secondary">{{ trans('property.per_year') }}</span>
                                </div>
                            </div>

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
