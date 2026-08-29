<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="currency">
            {{ trans('property.currency') }}
        </label>
        <div>
            @foreach (PropertyCurrency::cases() as $propertyCurrency)
                <div class="form-check form-check-inline" wire:key="living-type-{{ $propertyCurrency->value }}">
                    <input class="form-check-input" type="radio" id="currency_{{ $propertyCurrency->value }}"
                        name="currency" value="{{ $propertyCurrency->value }}"
                        {{ $propertyCurrency->value == $form->currency ? 'checked' : '' }}
                        wire:model.lazy="form.currency" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="currency_{{ $propertyCurrency->value }}">
                        {{ $propertyCurrency->name }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.currency')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
