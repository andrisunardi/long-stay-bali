<x-alert-error />

<form wire:submit.prevent="submit" role="form" autocomplete="off">
    <div class="d-grid gap-3">
        <div>
            <label class="form-label" for="name">
                {{ trans('validation.attributes.name') }}
                <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <span class="fas fa-building fa-fw "></span>
                </div>
                <input type="text" class="form-control" id="name" name="name" minlength="1" maxlength="50"
                    placeholder="{{ trans('index.ex') }} John Doe" required wire:model="form.name"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled">
            </div>
            <div class="form-text">
                {{ trans('helper.required') }},
                {{ trans('helper.minlength') }} : 1,
                {{ trans('helper.maxlength') }} : 50
            </div>
            @error('form.name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="form-label" for="email">
                {{ trans('validation.attributes.email') }}
                <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <span class="fas fa-envelope fa-fw "></span>
                </div>
                <input type="email" class="form-control" id="email" name="email" minlength="1" maxlength="50"
                    placeholder="{{ trans('index.ex') }} johndoe@gmail.com" required wire:model="form.email"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled">
            </div>
            <div class="form-text">
                {{ trans('helper.required') }},
                {{ trans('helper.minlength') }} : 1,
                {{ trans('helper.maxlength') }} : 50
            </div>
            @error('form.email')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="form-label" for="phone">
                {{ trans('validation.attributes.phone') }}
                <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <span class="fas fa-phone fa-fw "></span>
                </div>
                <input type="tel" class="form-control" id="phone" name="phone" minlength="1" maxlength="20"
                    placeholder="{{ trans('index.ex') }} 6281234567890" required wire:model="form.phone"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled">
            </div>
            <div class="form-text">
                {{ trans('helper.required') }},
                {{ trans('helper.minlength') }} : 1,
                {{ trans('helper.maxlength') }} : 20
            </div>
            @error('form.phone')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="form-label" for="rental_type">
                {{ trans('property.rental_type_accepted') }}
                <span class="text-danger">*</span>
            </label>
            <div>
                @foreach ($this->propertyRentalTypes() as $propertyRentalType)
                    <div class="form-check form-check-inline" wire:key="rental-type-{{ $propertyRentalType->value }}">
                        <input class="form-check-input" type="radio"
                            id="rental_type_{{ $propertyRentalType->value }}" name="rental_type"
                            value="{{ $propertyRentalType->value }}"
                            {{ $propertyRentalType->value == $form->rental_type ? 'checked' : '' }} required
                            wire:model="form.rental_type" wire:offline.class="disabled" wire:offline.attr="disabled"
                            wire:loading.class="disabled" wire:loading.attr="disabled">
                        <label class="form-check-label" for="rental_type_{{ $propertyRentalType->value }}">
                            {{ $propertyRentalType->description() }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="form-text">
                {{ trans('helper.required') }}
            </div>
            @error('form.rental_type')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="form-label" for="description">
                {{ trans('property.description') }}
                <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <span class="fas fa-pencil fa-fw "></span>
                </div>
                <textarea class="form-control" rows="3" id="description" name="description"
                    placeholder="{{ trans('index.ex') }} 3 Bedroom" required wire:model="form.description"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled"></textarea>
            </div>
            <div class="form-text">
                {{ trans('helper.required') }}
                {{ trans('helper.minlength') }} : 1,
                {{ trans('helper.maxlength') }} : 65.535
            </div>
            @error('form.description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="form-label" for="google_maps_url">
                {{ trans('property.google_maps_url') }}
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <span class="fas fa-globe fa-fw "></span>
                </div>
                <textarea class="form-control" rows="3" id="google_maps_url" name="google_maps_url"
                    placeholder="{{ trans('index.ex') }} https://maps.app.goo.gl/ABCDEF" wire:model="form.google_maps_url"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled"></textarea>
            </div>
            <div class="form-text">
                {{ trans('helper.minlength') }} : 1,
                {{ trans('helper.maxlength') }} : 65.535
            </div>
            @error('form.google_maps_url')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" wire:offline.class="disabled"
            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submit">
                <span class="fas fa-paper-plane fa-fw"></span>
                {{ trans('index.submit') }}
            </span>
            <span wire:loading wire:target="submit" class="w-100">
                <span class="spinner-border spinner-border-sm"></span>
                {{ trans('index.submit') }}
            </span>
        </button>
    </div>
</form>
