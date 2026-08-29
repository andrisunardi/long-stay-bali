<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="sale_price">
            {{ trans('property.sale_price') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-rupiah-sign fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="sale_price" name="sale_price" min="0" max="100000000000"
                placeholder="{{ trans('index.ex') }}" required wire:model="form.sale_price"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.required') }},
            {{ trans('helper.min') }} : 0,
            {{ trans('helper.max') }} : 100.000.000.000
        </div>
        @error('form.sale_price')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

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
