@props([
    'livingStyle' => null,
])

<div>
    <label class="form-label">
        <span class="fas fa-couch fa-fw"></span>
        {{ trans('home.search.living_style') }}
    </label>
    <div class="input-group">
        <button type="button" class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown">
            @if ($livingStyle)
                {{ PropertyLivingStyle::from($livingStyle)->translate() }}
            @else
                {{ trans('index.all') }}
            @endif
        </button>

        <ul class="dropdown-menu w-100 mt-3">
            <li wire:key="living-style">
                <button type="button" class="dropdown-item" wire:click="changeLivingStyle">
                    {{ trans('index.all') }}
                </button>
            </li>
            @foreach (PropertyLivingStyle::cases() as $propertyLivingStyle)
                <li wire:key="living-style-{{ $propertyLivingStyle }}">
                    <button type="button" class="dropdown-item d-flex justify-content-between"
                        wire:click="changeLivingStyle({{ $propertyLivingStyle->value }})">
                        {{ $propertyLivingStyle->translate() }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
