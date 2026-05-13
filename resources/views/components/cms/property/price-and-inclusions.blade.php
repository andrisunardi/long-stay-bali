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

<h5 class="mb-4">Price & Inclusions</h5>

<div class="mb-5">
    <h6 class="mb-3">Monthly</h6>
    <div class="row g-3">

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model.live="form.monthly_inclusions.housekeeper">

                <label class="form-check-label">
                    Housekeeper
                </label>
            </div>
        </div>

        @if ($form->monthly_inclusions['housekeeper'])
            <div class="col-md-6">
                <label class="form-label">
                    Frequency per week
                </label>

                <input type="number" class="form-control" wire:model="form.monthly_inclusions.housekeeper_frequency">
            </div>
        @endif

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.monthly_inclusions.gardener">

                <label class="form-check-label">
                    Gardener
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.monthly_inclusions.pool_guy">

                <label class="form-check-label">
                    Pool Guy
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.monthly_inclusions.internet">

                <label class="form-check-label">
                    Internet
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.monthly_inclusions.garbage">

                <label class="form-check-label">
                    Garbage
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.monthly_inclusions.banjar">

                <label class="form-check-label">
                    Banjar
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.monthly_inclusions.security">

                <label class="form-check-label">
                    Security
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.monthly_inclusions.electricity">

                <label class="form-check-label">
                    Electricity
                </label>
            </div>
        </div>

        <div class="col-12">
            <label class="form-label">
                Others
            </label>

            <input type="text" class="form-control" wire:model="form.monthly_inclusions.others">
        </div>

    </div>
</div>

<div class="mb-5">
    <h6 class="mb-3">Yearly</h6>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model.live="form.yearly_inclusions.housekeeper">

                <label class="form-check-label">
                    Housekeeper
                </label>
            </div>
        </div>

        @if ($form->yearly_inclusions['housekeeper'])
            <div class="col-md-6">
                <label class="form-label">
                    Frequency per week
                </label>

                <input type="number" class="form-control" wire:model="form.yearly_inclusions.housekeeper_frequency">
            </div>
        @endif

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.yearly_inclusions.gardener">

                <label class="form-check-label">
                    Gardener
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.yearly_inclusions.pool_guy">

                <label class="form-check-label">
                    Pool Guy
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.yearly_inclusions.internet">

                <label class="form-check-label">
                    Internet
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.yearly_inclusions.garbage">

                <label class="form-check-label">
                    Garbage
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.yearly_inclusions.banjar">

                <label class="form-check-label">
                    Banjar
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.yearly_inclusions.security">

                <label class="form-check-label">
                    Security
                </label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" wire:model="form.yearly_inclusions.electricity">

                <label class="form-check-label">
                    Electricity
                </label>
            </div>
        </div>

        <div class="col-12">
            <label class="form-label">
                Others
            </label>

            <input type="text" class="form-control" wire:model="form.yearly_inclusions.others">
        </div>

    </div>
</div>
