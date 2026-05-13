<section class="py-5">
    <div class="container-md">
        <div class="d-grid gap-4">
            <x-property.images :property="$property" />

            <div class="row">
                <div class="col-xl-7">
                    <x-property.information :property="$property" />

                    <hr class="my-4" />

                    <x-property.details :property="$property" />

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
                    <x-property.sidebar :property="$property" />
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
