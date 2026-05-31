<?php

use App\Livewire\Component;
use App\Services\PropertyService;

new class extends Component {
    public bool $text = false;

    public string $search = '';

    public function changeText(): void
    {
        $this->text = !$this->text;
    }

    public function properties(): object
    {
        $statuses = [PropertyStatus::AcceptUpper->value, PropertyStatus::AcceptPremium->value];

        $service = new PropertyService();
        $properties = $service->index(statuses: $statuses, orderBy: 'code', sortBy: 'asc', paginate: false);

        return $properties->filter(function ($property) {
            return str_contains(strtolower($property->code), strtolower($this->search));
        });
    }
};
?>

<div>
    @if ($text)
        <div class="position-relative w-100">
            <div class="input-group">
                <input type="text" id="search" name="search" class="form-control form-control-sm rounded-start-5"
                    minlength="1" maxlength="50" placeholder="{{ trans('index.property_code') }}" autocomplete="off"
                    data-bs-toggle="dropdown" wire:model.live.debounce.500ms="search" wire:offline.class="disabled"
                    wire:offline.attr="disabled">

                <a draggable="false" class="input-group-text rounded-end-5 ps-2" role="button" wire:click="changeText">
                    <span class="fas fa-times fa-sm"></span>
                </a>
            </div>

            <ul class="dropdown-menu {{ $search ? 'show' : '' }} w-100 mt-2">
                @forelse ($this->properties() as $property)
                    <li wire:key="property-{{ $property->id }}">
                        <a draggable="false" href="{{ route('property.detail', ['slug' => $property->slug]) }}"
                            class="dropdown-item text-wrap icon-link" wire:click="changeArea({{ $property->id }})">
                            <span class="fas fa-caret-right fa-fw"></span>
                            {{ $property->code }}
                        </a>
                    </li>
                @empty
                    <li>
                        <h6 class="dropdown-header">
                            {{ trans('message.no_data_available') }}
                        </h6>
                    </li>
                @endforelse
            </ul>
        </div>
    @else
        <a draggable="false" role="button" wire:click="changeText">
            <span class="fa-stack">
                <i class="fa-solid fa-circle fa-stack-2x fa-inverse"></i>
                <i class="fa-solid fa-search fa-stack-1x"></i>
            </span>
        </a>
    @endif
</div>
