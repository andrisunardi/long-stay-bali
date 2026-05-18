@props([
    'propertyBedrooms' => collect(),
    'bedroom' => null,
])

<div>
    <label class="form-label">
        <span class="fas fa-bed fa-fw"></span>
        {{ trans('home.search.bedroom') }}
    </label>
    <div class="input-group">
        <button type="button" class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown">
            @if ($bedroom)
                {{ PropertyBedroom::from($bedroom)->value }}
            @else
                {{ trans('index.all') }}
            @endif
        </button>

        <ul class="dropdown-menu w-100 mt-3">
            <li wire:key="bedroom">
                <button type="button" class="dropdown-item" wire:click="changeBedroom">
                    {{ trans('index.all') }}
                </button>
            </li>
            @foreach ($propertyBedrooms as $propertyBedroom)
                <li wire:key="property-bedroom-{{ $propertyBedroom }}">
                    <button type="button" class="dropdown-item"
                        wire:click="changeBedroom({{ $propertyBedroom->value }})">
                        {{ $propertyBedroom->description() }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
