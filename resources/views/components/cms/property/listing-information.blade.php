<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="listing_type">
            {{ trans('property.listing_type') }}
        </label>
        <div>
            @foreach (PropertyListingType::cases() as $propertyListingType)
                <div class="form-check form-check-inline" wire:key="living-type-{{ $propertyListingType->value }}">
                    <input class="form-check-input" type="radio" id="listing_type_{{ $propertyListingType->value }}"
                        name="listing_type" value="{{ $propertyListingType->value }}"
                        {{ $propertyListingType->value == $form->listing_type ? 'checked' : '' }}
                        wire:model.lazy="form.listing_type" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="listing_type_{{ $propertyListingType->value }}">
                        {{ Str::headline($propertyListingType->name) }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.listing_type')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="reference">
            {{ trans('property.reference') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-bullhorn fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="reference" name="reference" minlength="1" maxlength="100"
                placeholder="{{ trans('index.ex') }} So Living Bali" wire:model="form.reference"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 100
        </div>
        @error('form.reference')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
