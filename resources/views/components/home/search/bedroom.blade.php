@props([
    'bedrooms' => [],
])

<div class="bedroomss">
    <label class="form-label">
        <span class="fas fa-bed fa-fw"></span>
        {{ trans('home.search.bedroom') }}
    </label>
    <div class="input-group">
        <button type="button" class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown">
            @if ($bedrooms)
                {{ collect($bedrooms)->map(fn($bedroom) => PropertyBedroom::from($bedroom)->description())->join(', ') }}
            @else
                {{ trans('index.all') }}
            @endif
        </button>

        <ul class="dropdown-menu w-100 mt-3">
            <li wire:key="bedroom">
                <button type="button" class="dropdown-item" wire:click="changeBedrooms">
                    {{ trans('index.all') }}
                </button>
            </li>
            @foreach (PropertyBedroom::cases() as $propertyBedroom)
                <li wire:key="property-bedroom-{{ $propertyBedroom }}">
                    <button type="button" class="dropdown-item d-flex justify-content-between"
                        wire:click="changeBedrooms({{ $propertyBedroom->value }})">
                        {{ $propertyBedroom->description() }}
                        @if (in_array($propertyBedroom->value, $bedrooms))
                            <span class="fas fa-check fa-fw text-success"></span>
                        @endif
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
