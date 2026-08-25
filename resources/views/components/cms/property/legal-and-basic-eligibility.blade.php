<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="full_legal_documentation">
            {{ trans('property.full_legal_documentation_available') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="full_legal_documentation"
                name="full_legal_documentation" value="1" {{ $form->full_legal_documentation ? 'checked' : '' }}
                wire:model.lazy="form.full_legal_documentation" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->full_legal_documentation) }}"
                for="full_legal_documentation">
                {{ Str::yesNo($form->full_legal_documentation) }}
            </label>
        </div>
        @error('form.full_legal_documentation')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="signed_listing_agreement">
            {{ trans('property.signed_listing_agreement') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="signed_listing_agreement"
                name="signed_listing_agreement" value="1" {{ $form->signed_listing_agreement ? 'checked' : '' }}
                wire:model.lazy="form.signed_listing_agreement" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->signed_listing_agreement) }}"
                for="signed_listing_agreement">
                {{ Str::yesNo($form->signed_listing_agreement) }}
            </label>
        </div>
        @error('form.signed_listing_agreement')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="lease_agreement">
            {{ trans('property.lease_agreement') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="lease_agreement" name="lease_agreement"
                value="1" {{ $form->lease_agreement ? 'checked' : '' }} wire:model.lazy="form.lease_agreement"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->lease_agreement) }}"
                for="lease_agreement">
                {{ Str::yesNo($form->lease_agreement) }}
            </label>
        </div>
        @error('form.lease_agreement')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="land_certificate">
            {{ trans('property.land_certificate') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="land_certificate" name="land_certificate"
                value="1" {{ $form->land_certificate ? 'checked' : '' }} wire:model.lazy="form.land_certificate"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->land_certificate) }}"
                for="land_certificate">
                {{ Str::yesNo($form->land_certificate) }}
            </label>
        </div>
        @error('form.land_certificate')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="owners_id">
            {{ trans('property.owners_id') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="owners_id" name="owners_id"
                value="1" {{ $form->owners_id ? 'checked' : '' }} wire:model.lazy="form.owners_id"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->owners_id) }}" for="owners_id">
                {{ Str::yesNo($form->owners_id) }}
            </label>
        </div>
        @error('form.owners_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="imb">
            {{ trans('property.imb') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="imb" name="imb" value="1"
                {{ $form->imb ? 'checked' : '' }} wire:model.lazy="form.imb" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->imb) }}" for="imb">
                {{ Str::yesNo($form->imb) }}
            </label>
        </div>
        @error('form.imb')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="pbg">
            {{ trans('property.pbg') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="pbg" name="pbg"
                value="1" {{ $form->pbg ? 'checked' : '' }} wire:model.lazy="form.pbg"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->pbg) }}" for="pbg">
                {{ Str::yesNo($form->pbg) }}
            </label>
        </div>
        @error('form.pbg')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="slf">
            {{ trans('property.slf') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="slf" name="slf"
                value="1" {{ $form->slf ? 'checked' : '' }} wire:model.lazy="form.slf"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->slf) }}" for="slf">
                {{ Str::yesNo($form->slf) }}
            </label>
        </div>
        @error('form.slf')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="fully_furnished">
            {{ trans('property.fully_furnished') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="fully_furnished"
                name="fully_furnished" value="1" {{ $form->fully_furnished ? 'checked' : '' }}
                wire:model.lazy="form.fully_furnished" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->fully_furnished ? 'success' : 'danger' }}"
                for="fully_furnished">
                {{ $form->fully_furnished ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.fully_furnished')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="rental_type">
            {{ trans('property.rental_type_accepted') }}
        </label>
        <div>
            @foreach ($this->propertyRentalTypes() as $propertyRentalType)
                <div class="form-check form-check-inline" wire:key="rental-type-{{ $propertyRentalType->value }}">
                    <input class="form-check-input" type="radio" id="rental_type_{{ $propertyRentalType->value }}"
                        name="rental_type" value="{{ $propertyRentalType->value }}"
                        {{ $propertyRentalType->value == $form->rental_type ? 'checked' : '' }}
                        wire:model.lazy="form.rental_type" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="rental_type_{{ $propertyRentalType->value }}">
                        {{ $propertyRentalType->description() }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.rental_type')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="minimum_rental_duration_months">
            {{ trans('property.minimum_rental_duration') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-calendar fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="minimum_rental_duration_months"
                name="minimum_rental_duration_months" min="1" max="255"
                placeholder="{{ trans('index.ex') . '. 12' }}" wire:model="form.minimum_rental_duration_months"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 255
        </div>
        @error('form.minimum_rental_duration_months')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="owner_price_flexibility">
            {{ trans('property.owner_price_flexibility') }}
        </label>
        <div>
            @foreach ($this->propertyOwnerPriceFlexibility() as $propertyOwnerPriceFlexibility)
                <div class="form-check form-check-inline"
                    wire:key="owner-price-flexbility-{{ $propertyOwnerPriceFlexibility->value }}">
                    <input class="form-check-input" type="radio"
                        id="owner_price_flexibility_{{ $propertyOwnerPriceFlexibility->value }}"
                        name="owner_price_flexibility" value="{{ $propertyOwnerPriceFlexibility->value }}"
                        {{ $propertyOwnerPriceFlexibility->value == $form->owner_price_flexibility ? 'checked' : '' }}
                        wire:model.lazy="form.owner_price_flexibility" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label"
                        for="owner_price_flexibility_{{ $propertyOwnerPriceFlexibility->value }}">
                        {{ $propertyOwnerPriceFlexibility->description() }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.owner_price_flexibility')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="price_coherent_with_upper">
            {{ trans('property.price_coherent_with_upper_or_premium_positioning') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="price_coherent_with_upper"
                name="price_coherent_with_upper" value="1"
                {{ $form->price_coherent_with_upper ? 'checked' : '' }}
                wire:model.lazy="form.price_coherent_with_upper" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->price_coherent_with_upper ? 'success' : 'danger' }}"
                for="price_coherent_with_upper">
                {{ $form->price_coherent_with_upper ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.price_coherent_with_upper')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="land_title">
            {{ trans('property.land_title') }}
        </label>
        <div>
            @foreach (PropertyLandTitle::cases() as $propertyLandTitle)
                <div class="form-check form-check-inline"
                    wire:key="owner-price-flexbility-{{ $propertyLandTitle->value }}">
                    <input class="form-check-input" type="radio" id="land_title_{{ $propertyLandTitle->value }}"
                        name="land_title" value="{{ $propertyLandTitle->value }}"
                        {{ $propertyLandTitle->value == $form->land_title ? 'checked' : '' }}
                        wire:model.lazy="form.land_title" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="land_title_{{ $propertyLandTitle->value }}">
                        {{ $propertyLandTitle->description() }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.land_title')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="zoning">
            {{ trans('property.zoning') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-pen-ruler fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="zoning" name="zoning" minlength="1"
                maxlength="100" placeholder="{{ trans('index.ex') }} Green Zone" wire:model="form.zoning"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 100
        </div>
        @error('form.zoning')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="pbg_status">
            {{ trans('property.pbg_status') }}
        </label>
        <div>
            @foreach (PropertyPBGStatus::cases() as $propertyPBGStatus)
                <div class="form-check form-check-inline"
                    wire:key="owner-price-flexbility-{{ $propertyPBGStatus->value }}">
                    <input class="form-check-input" type="radio" id="pbg_status_{{ $propertyPBGStatus->value }}"
                        name="pbg_status" value="{{ $propertyPBGStatus->value }}"
                        {{ $propertyPBGStatus->value == $form->pbg_status ? 'checked' : '' }}
                        wire:model.lazy="form.pbg_status" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="pbg_status_{{ $propertyPBGStatus->value }}">
                        {{ Str::headline($propertyPBGStatus->name) }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.pbg_status')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="slf_status">
            {{ trans('property.slf_status') }}
        </label>
        <div>
            @foreach (PropertySLFStatus::cases() as $propertySlfStatus)
                <div class="form-check form-check-inline"
                    wire:key="owner-price-flexbility-{{ $propertySlfStatus->value }}">
                    <input class="form-check-input" type="radio" id="slf_status_{{ $propertySlfStatus->value }}"
                        name="slf_status" value="{{ $propertySlfStatus->value }}"
                        {{ $propertySlfStatus->value == $form->slf_status ? 'checked' : '' }}
                        wire:model.lazy="form.slf_status" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="slf_status_{{ $propertySlfStatus->value }}">
                        {{ Str::headline($propertySlfStatus->name) }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.slf_status')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="road_access">
            {{ trans('property.road_access') }}
        </label>
        <div>
            @foreach (PropertyRoadAccess::cases() as $propertyRoadAccess)
                <div class="form-check form-check-inline"
                    wire:key="owner-price-flexbility-{{ $propertyRoadAccess->value }}">
                    <input class="form-check-input" type="radio"
                        id="road_access_{{ $propertyRoadAccess->value }}" name="road_access"
                        value="{{ $propertyRoadAccess->value }}"
                        {{ $propertyRoadAccess->value == $form->road_access ? 'checked' : '' }}
                        wire:model.lazy="form.road_access" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="road_access_{{ $propertyRoadAccess->value }}">
                        {{ Str::headline($propertyRoadAccess->name) }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.road_access')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="road_access_width">
            {{ trans('property.road_access_width') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-pen-ruler fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="road_access_width" name="road_access_width"
                minlength="1" maxlength="100" placeholder="{{ trans('index.ex') }} 10 Meter"
                wire:model="form.road_access_width" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 100
        </div>
        @error('form.road_access_width')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="car_access">
            {{ trans('property.car_access') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="car_access" name="car_access"
                value="1" {{ $form->car_access ? 'checked' : '' }} wire:model.lazy="form.car_access"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
            <label class="form-check-label text-{{ Str::successDanger($form->car_access) }}" for="car_access">
                {{ Str::yesNo($form->car_access) }}
            </label>
        </div>
        @error('form.car_access')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
