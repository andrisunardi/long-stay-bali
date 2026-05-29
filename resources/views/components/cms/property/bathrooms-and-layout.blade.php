<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="number_of_bathrooms">
            {{ trans('property.number_of_bathrooms') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-pen-ruler fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="number_of_bathrooms"
                name="number_of_bathrooms" min="1" max="255"
                placeholder="{{ trans('index.ex') . '. 2' }}" wire:model="form.number_of_bathrooms"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 255
        </div>
        @error('form.number_of_bathrooms')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="ensuite_bathrooms">
            {{ trans('property.ensuite_bathrooms') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="ensuite_bathrooms"
                name="ensuite_bathrooms" value="1" {{ $form->ensuite_bathrooms ? 'checked' : '' }}
                wire:model.lazy="form.ensuite_bathrooms" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->ensuite_bathrooms ? 'success' : 'danger' }}"
                for="ensuite_bathrooms">
                {{ $form->ensuite_bathrooms ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.ensuite_bathrooms')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="guest_toilet">
            {{ trans('property.guest_toilet') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="guest_toilet"
                name="guest_toilet" value="1" {{ $form->guest_toilet ? 'checked' : '' }}
                wire:model.lazy="form.guest_toilet" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->guest_toilet ? 'success' : 'danger' }}"
                for="guest_toilet">
                {{ $form->guest_toilet ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.guest_toilet')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="storage">
            {{ trans('property.storage_or_staff_area') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="storage" name="storage"
                value="1" {{ $form->storage ? 'checked' : '' }} wire:model.lazy="form.storage"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->storage ? 'success' : 'danger' }}"
                for="storage">
                {{ $form->storage ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.storage')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="living_style">
            {{ trans('property.living_style') }}
        </label>
        <div>
            @foreach ($this->propertyLivingStyles() as $propertyLivingStyle)
                <div class="form-check form-check-inline"
                    wire:key="living-style-{{ $propertyLivingStyle->value }}">
                    <input class="form-check-input" type="radio"
                        id="living_style_{{ $propertyLivingStyle->value }}" name="living_style"
                        value="{{ $propertyLivingStyle->value }}"
                        {{ $propertyLivingStyle->value == $form->living_style ? 'checked' : '' }}
                        wire:model.lazy="form.living_style" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                    <label class="form-check-label"
                        for="living_style_{{ $propertyLivingStyle->value }}">
                        {{ $propertyLivingStyle->name }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.living_style')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
