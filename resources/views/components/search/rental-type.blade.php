@props([
    'rentalType' => null,
])

<div class="row g-3">
    <div class="col">
        <button type="button"
            class="btn btn-outline-success btn-sm w-100 rounded-pill {{ !$rentalType ? 'active' : '' }}"
            wire:click="changePropertyRentalType" wire:offline.class="disabled" wire:offline.attr="disabled"
            wire:loading.class="disabled" wire:loading.attr="disabled">
            {{ trans('index.all') }}
        </button>
    </div>

    @foreach (PropertyRentalType::cases() as $propertyRentalType)
        @continue($propertyRentalType == PropertyRentalType::Both)

        <div class="col">
            <button type="button"
                class="btn btn-outline-success btn-sm w-100 rounded-pill {{ $propertyRentalType->value == $rentalType ? 'active' : '' }}"
                wire:click="changePropertyRentalType({{ $propertyRentalType->value }})" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                {{ $propertyRentalType->translate() }}
            </button>
        </div>
    @endforeach
</div>
