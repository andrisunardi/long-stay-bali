<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="land_size">
            {{ trans('property.land_size') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-pen-ruler fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="land_size" name="land_size" min="1" max="999999999"
                placeholder="{{ trans('index.ex') . '. 100' }}" wire:model="form.land_size"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 999999999
        </div>
        @error('form.land_size')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="building_size">
            {{ trans('property.building_size') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-pen-ruler fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="building_size" name="building_size" min="1"
                max="999999999" placeholder="{{ trans('index.ex') . '. 100' }}" wire:model="form.building_size"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 999999999
        </div>
        @error('form.building_size')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="number_of_floors">
            {{ trans('property.number_of_floors') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-layer-group fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="number_of_floors" name="number_of_floors" min="1"
                max="255" placeholder="{{ trans('index.ex') . '. 2' }}" wire:model="form.number_of_floors"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 255
        </div>
        @error('form.number_of_floors')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="outdoor_area_size">
            {{ trans('property.outdoor_area_size') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-pen-ruler fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="outdoor_area_size" name="outdoor_area_size" min="1"
                max="999999999" placeholder="{{ trans('index.ex') . '. 100' }}" wire:model="form.outdoor_area_size"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 999999999
        </div>
        @error('form.outdoor_area_size')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="pool_size">
            {{ trans('property.pool_size') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-water-ladder fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="pool_size" name="pool_size" minlength="1" maxlength="50"
                placeholder="{{ trans('index.ex') . '. 10 x 20' }}" wire:model="form.pool_size"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 50
        </div>
        @error('form.pool_size')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="price_per_are">
            {{ trans('property.price_per_are') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-rupiah-sign fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="price_per_are" name="price_per_are" min="1"
                max="999999999" placeholder="{{ trans('index.ex') . '. 1000000000' }}"
                wire:model="form.price_per_are" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 999999999
        </div>
        @error('form.price_per_are')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="land_size_in_ares">
            {{ trans('property.land_size_in_ares') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-pen-ruler fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="land_size_in_ares" name="land_size_in_ares"
                minlength="1" maxlength="100" placeholder="{{ trans('index.ex') }} 100 m2"
                wire:model="form.land_size_in_ares" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 100
        </div>
        @error('form.land_size_in_ares')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="road_frontage">
            {{ trans('property.road_frontage') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-road fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="road_frontage" name="road_frontage" minlength="1"
                maxlength="100" placeholder="{{ trans('index.ex') }} 100 m2" wire:model="form.road_frontage"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 100
        </div>
        @error('form.road_frontage')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="land_contour">
            {{ trans('property.land_contour') }}
        </label>
        <div>
            @foreach (PropertyLandContour::cases() as $propertyLandContour)
                <div class="form-check form-check-inline" wire:key="living-style-{{ $propertyLandContour->value }}">
                    <input class="form-check-input" type="radio"
                        id="land_contour_{{ $propertyLandContour->value }}" name="land_contour"
                        value="{{ $propertyLandContour->value }}"
                        {{ $propertyLandContour->value == $form->land_contour ? 'checked' : '' }}
                        wire:model.lazy="form.land_contour" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="land_contour_{{ $propertyLandContour->value }}">
                        {{ $propertyLandContour->name }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.land_contour')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="subdivision_possible">
            {{ trans('property.subdivision_possible') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="subdivision_possible"
                name="subdivision_possible" value="1" {{ $form->subdivision_possible ? 'checked' : '' }}
                wire:model.lazy="form.subdivision_possible" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->subdivision_possible ? 'success' : 'danger' }}"
                for="subdivision_possible">
                {{ $form->subdivision_possible ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.subdivision_possible')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="minimum_purchase_size">
            {{ trans('property.minimum_purchase_size') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-cart-shopping fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="minimum_purchase_size" name="minimum_purchase_size"
                minlength="1" maxlength="100" placeholder="{{ trans('index.ex') }} 500 sqm"
                wire:model="form.minimum_purchase_size" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 100
        </div>
        @error('form.minimum_purchase_size')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
