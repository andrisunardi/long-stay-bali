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
                        {{ $propertyListingType->name }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.listing_type')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
