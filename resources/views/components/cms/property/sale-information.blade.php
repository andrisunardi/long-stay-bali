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
                <div class="form-check form-check-inline" wire:key="currency-{{ $propertyCurrency->value }}">
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

    <div class="col-sm-6">
        <label class="form-label" for="ownership_type">
            {{ trans('property.ownership_type') }}
        </label>
        <div>
            @foreach (PropertyOwnershipType::cases() as $propertyOwnershipType)
                <div class="form-check form-check-inline"
                    wire:key="ownership-type-{{ $propertyOwnershipType->value }}">
                    <input class="form-check-input" type="radio"
                        id="ownership_type_{{ $propertyOwnershipType->value }}" name="ownership_type"
                        value="{{ $propertyOwnershipType->value }}"
                        {{ $propertyOwnershipType->value == $form->ownership_type ? 'checked' : '' }}
                        wire:model.lazy="form.ownership_type" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="ownership_type_{{ $propertyOwnershipType->value }}">
                        {{ $propertyOwnershipType->name }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.ownership_type')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    @if ($form->ownership_type == PropertyOwnershipType::Leasehold->value)
        <div class="col-sm-6">
            <label class="form-label" for="lease_expiry_date">
                {{ trans('property.lease_expiry_date') }}
                <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <span class="fas fa-calendar fa-fw "></span>
                </div>
                <input type="date" class="form-control" id="lease_expiry_date" name="lease_expiry_date"
                    min="{{ $property?->lease_expiry_date?->toDateString() ?? now()->toDateString() }}"
                    max="2099-12-31" required wire:model="form.lease_expiry_date" wire:offline.class="disabled"
                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            </div>
            <div class="form-text">
                {{ trans('helper.min') }} : {{ trans('index.today') }},
                {{ trans('helper.max') }} :
                {{ Date::parse('2099-12-31')->isoFormat('DD MMMM YYYY') }}
            </div>
            @error('form.lease_expiry_date')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    @endif

    @if ($form->ownership_type == PropertyOwnershipType::Leasehold->value)
        <div class="col-sm-6">
            <label class="form-label" for="lease_extension_available">
                {{ trans('property.lease_extension_available') }}
            </label>
            <div>
                @foreach (PropertyLeaseExtensionAvailable::cases() as $propertyLeaseExtensionAvailable)
                    <div class="form-check form-check-inline"
                        wire:key="ownership-type-{{ $propertyLeaseExtensionAvailable->value }}">
                        <input class="form-check-input" type="radio"
                            id="lease_extension_available_{{ $propertyLeaseExtensionAvailable->value }}"
                            name="lease_extension_available" value="{{ $propertyLeaseExtensionAvailable->value }}"
                            {{ $propertyLeaseExtensionAvailable->value == $form->lease_extension_available ? 'checked' : '' }}
                            wire:model.lazy="form.lease_extension_available" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                        <label class="form-check-label"
                            for="lease_extension_available_{{ $propertyLeaseExtensionAvailable->value }}">
                            {{ Str::headline($propertyLeaseExtensionAvailable->name) }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('form.lease_extension_available')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    @endif

    @if ($form->ownership_type == PropertyOwnershipType::Leasehold->value)
        <div class="col-sm-6">
            <label class="form-label" for="lease_extension_terms_or_price">
                {{ trans('validation.attributes.lease_extension_terms_or_price') }}
            </label>
            <x-form.trix model="form.lease_extension_terms_or_price" />
            <div class="form-text">
                {{ trans('helper.minlength') }} : 1,
                {{ trans('helper.maxlength') }} : 65.535,
            </div>
            @error('form.lease_extension_terms_or_price')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    @endif

    <div class="col-sm-6">
        <label class="form-label" for="payment_plan_available">
            {{ trans('property.payment_plan_available') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="payment_plan_available"
                name="payment_plan_available" value="1" {{ $form->payment_plan_available ? 'checked' : '' }}
                wire:model.lazy="form.payment_plan_available" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->payment_plan_available ? 'success' : 'danger' }}"
                for="payment_plan_available">
                {{ $form->payment_plan_available ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.payment_plan_available')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    @if ($form->payment_plan_available)
        <div class="col-sm-6">
            <label class="form-label" for="payment_plan_details">
                {{ trans('validation.attributes.payment_plan_details') }}
            </label>
            <x-form.trix model="form.payment_plan_details" />
            <div class="form-text">
                {{ trans('helper.minlength') }} : 1,
                {{ trans('helper.maxlength') }} : 65.535,
            </div>
            @error('form.payment_plan_details')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    @endif

    <div class="col-sm-6">
        <label class="form-label" for="developer_name">
            {{ trans('property.developer_name') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-font fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="developer_name" name="developer_name" minlength="1"
                maxlength="100" placeholder="{{ trans('index.ex') }} Villa Bali" wire:model="form.developer_name"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 100
        </div>
        @error('form.developer_name')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
