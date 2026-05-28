@props([
    'property' => null,
])

<div class="d-grid gap-3">
    <h5 class="fw-bold">{{ trans('property.location_property') }}</h5>
    <div id="map" class="w-100 rounded-5"></div>
</div>

@script
    <script>
        const map = L.map('map').setView([{{ $property->latitude }}, {{ $property->longitude }}], 15);

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
