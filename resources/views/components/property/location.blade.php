@props([
    'property' => null,
])

@if ($property->latitude && $property->longitude)
    <div class="d-grid gap-3">
        {{-- <h5 class="fw-bold">{{ trans('property.location_property') }}</h5> --}}
        <div id="map" class="w-100 rounded-5 h-100 ratio ratio-4x3 z-0"></div>
    </div>

    @script
        <script>
            const map = L.map('map', {
                scrollWheelZoom: false,
                touchZoom: true,
                dragging: true,
                doubleClickZoom: true,
            }).setView([{{ $property->latitude }}, {{ $property->longitude }}], 15);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            L.circle([{{ $property->latitude }}, {{ $property->longitude }}], {
                color: '#198754',
                fillColor: '#198754',
                fillOpacity: 0.5,
                radius: 500
            }).addTo(map);

            map.attributionControl.remove();
        </script>
    @endscript
@else
    <img draggable="false" class="img-fluid w-100 h-100 rounded user-select-none pe-none"
        src="{{ asset('images/placeholder.png') }}"
        alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">
@endif
