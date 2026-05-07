<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="monthly_price">
            {{ trans('property.monthly_price') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-rupiah-sign fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="monthly_price" name="monthly_price" min="1"
                max="100000000000" placeholder="{{ trans('index.ex') }}" required wire:model="form.monthly_price"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.required') }},
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 100.000.000.000
        </div>
        @error('form.monthly_price')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="yearly_price">
            {{ trans('property.yearly_price') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-rupiah-sign fa-fw "></span>
            </div>
            <input type="number" class="form-control" id="yearly_price" name="yearly_price" min="1"
                max="100000000000" placeholder="{{ trans('index.ex') }}" required wire:model="form.yearly_price"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.required') }},
            {{ trans('helper.min') }} : 1,
            {{ trans('helper.max') }} : 100.000.000.000
        </div>
        @error('form.yearly_price')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
