<h4 class="mb-3">{{ trans('property.property_details') }}</h4>

<div class="d-grid gap-2">
    <div class="row">
        <div class="col-4">
            {{ trans('property.availability') }}
        </div>
        <div class="col-8">
            @if ($property->availability_date)
                @if ($property->availability_date->isToday() || $property->availability_date->isPast())
                    {{ trans('index.now') }}
                @else
                    {{ $property->availability_date->isoFormat('dddd, DD MMMM YYYY') }}
                @endif

            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.bedrooms') }}
        </div>
        <div class="col-8">
            {{ $property->bedroom?->description() ?? 0 }}
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.bathrooms') }}
        </div>
        <div class="col-8">
            {{ $property->number_of_bathrooms ?? 0 }}
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.type_furnish') }}
        </div>
        <div class="col-8">
            {{ $property->fully_furnished ? trans('property.fully_furnished') : trans('property.non_furnished') }}
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.rental_type') }}
        </div>
        <div class="col-8">
            {{ $property->rental_type?->description() ?? '-' }}
        </div>
    </div>

    @if ($property->minimum_rental_duration_months > 1)
        <div class="row">
            <div class="col-4">
                {{ trans('property.minimum_rental_period') }}
            </div>
            <div class="col-8">
                {{ $property->minimum_rental_duration_months }}
                {{ trans('property.months') }}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-4">
            {{ trans('property.land_size') }}
        </div>
        <div class="col-8">
            {{ $property->land_size }}
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.building_size') }}
        </div>
        <div class="col-8">
            {{ $property->building_size }}
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.floors') }}
        </div>
        <div class="col-8">
            {{ $property->number_of_floors }}
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.carpot') }}
        </div>
        <div class="col-8">
            0
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.eletricity') }}
        </div>
        <div class="col-8">
            {{ $property->electricity?->translate() }}
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            {{ trans('property.water_source') }}
        </div>
        <div class="col-8">
            {{ $property->water_source?->translate() }}
        </div>
    </div>
</div>
