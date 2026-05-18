<h4 class="mb-3">{{ trans('property.property_details') }}</h4>

<div class="d-grid gap-2">
    <div class="row">
        <div class="col-4">
            {{ trans('property.availability') }}
        </div>
        <div class="col-8">
            {{ trans('property.chat_for_check_availability_on_whatsapp') }}
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

    <div class="row">
        <div class="col-4">
            {{ trans('property.minimum_rental_period') }}
        </div>
        <div class="col-8">
            {{ $property->minimum_rental_duration_months ?? 0 }}
            {{ trans('property.months') }}
        </div>
    </div>
</div>
