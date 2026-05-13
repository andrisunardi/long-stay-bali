<?php

use App\Livewire\Component;
use App\Models\Property;
use App\Services\PropertyService;
use Livewire\Attributes\Title;

new #[Title('Property Detail')] class extends Component {
    public ?Property $property = null;

    public function mount(string $slug): void
    {
        $service = new PropertyService();
        $this->property = $service->detail(slug: $slug);

        if (!$this->property) {
            abort(404);
        }

        $this->property->loadMissing(['area.district', 'image']);
    }
};
?>

@section('title', $property->name)

<div>
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

                        <x-property.inclusions :property="$property" />
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

                <hr />

                <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

                <div id="map" class="w-100 rounded" style="height: 300px"></div>

                <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

                <script>
                    const map = L.map('map').setView([{{ $property->latitude }}, {{ $property->longitude }}], 15);

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(map);

                    L.circle([{{ $property->latitude }}, {{ $property->longitude }}], {
                        color: '#0d6efd',
                        fillColor: '#0d6efd',
                        fillOpacity: 0.5,
                        radius: 500
                    }).addTo(map);
                </script>
            </div>
        </div>
    </section>
</div>
