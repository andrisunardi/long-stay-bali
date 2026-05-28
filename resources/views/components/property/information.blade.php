<div>
    <div class="row g-3">
        <div class="col-lg-8 col-xl-9">
            <h1>{{ $property->name }}</h1>

            <div class="d-flex gap-2">
                <span class="px-2 py-1 small rounded bg-sand">
                    <span class="fas fa-code fa-fw fa-xs text-success"></span>
                    <span class="text-black small">{{ $property->code }}</span>
                </span>

                <span class="px-2 py-1 small rounded bg-sand">
                    <span class="fas fa-location-dot fa-fw fa-xs text-success"></span>
                    <span class="text-black small">
                        @if ($property->area || $property->district)
                            {{ $property->area?->name ?? $property->district?->name }}
                        @endif
                    </span>
                </span>

                <span class="px-2 py-1 small rounded bg-sand">
                    <span class="fas fa-bed fa-fw fa-xs text-success"></span>
                    <span class="text-black small">{{ $property->bedroom?->description() ?? 0 }}</span>
                </span>
            </div>
        </div>
        <div class="col-lg-4 col-xl-3">
            <x-property.sidebar :property="$property" />
        </div>
    </div>

    <hr class="my-4" />

    <p class="mb-0">
        @if ($property->translate_description)
            {!! $property->translate_description !!}
        @else
            <span class="fst-italic text-muted">
                {{ trans('property.no_description_about_this_property') }}
            </span>
        @endif
    </p>
</div>
