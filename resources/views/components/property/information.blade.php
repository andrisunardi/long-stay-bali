<div>
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

</div>
