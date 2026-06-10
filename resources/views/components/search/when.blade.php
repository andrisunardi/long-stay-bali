@props([
    'rentalType' => null,
    'startDate' => null,
    'endDate' => null,
])

<div>
    <label class="form-label">
        <span class="fas fa-calendar fa-fw"></span>
        {{ trans('home.search.when') }}
    </label>
    <div class="input-group">
        <button type="button" data-when-dropdown
            class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" data-bs-display="static">
            <span>
                {{ Date::parse($startDate)->isoFormat('DD MMM YYYY') }}
                <span> - </span>
                {{ Date::parse($endDate)->isoFormat('DD MMM YYYY') }}
            </span>
        </button>

        <div class="dropdown-menu w-100 mt-3 p-3">
            <div class="row g-3">
                @foreach (collect(PropertyRentalType::cases())->reject(fn(PropertyRentalType $propertyRentalType) => $propertyRentalType == PropertyRentalType::Both) as $propertyRentalType)
                    <div class="col">
                        <button type="button"
                            class="btn btn-outline-success btn-sm w-100 rounded-pill {{ ((!$rentalType || $rentalType == PropertyRentalType::Both->value) && $propertyRentalType == PropertyRentalType::Monthly) || $propertyRentalType->value == $rentalType ? 'active' : '' }}"
                            wire:click="changeRentalType({{ $propertyRentalType->value }})"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            {{ $propertyRentalType->translate() }}
                        </button>
                    </div>
                @endforeach
            </div>

            <hr />

            <div></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('keep-when-dropdown-open', () => {
            document.querySelectorAll('[data-when-dropdown]').forEach(el => {
                const dropdown =
                    bootstrap.Dropdown.getInstance(el) ??
                    new bootstrap.Dropdown(el)
                dropdown.show()
            })
        })
    });
</script>
