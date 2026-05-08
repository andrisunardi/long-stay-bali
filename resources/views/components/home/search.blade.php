<?php

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyType;
use App\Livewire\Component;
use App\Services\AreaService;
use Livewire\Attributes\Url;

new class extends Component {
    // public object $areas;

    #[Url(except: null)]
    public ?int $id_area = null;

    public string $search_area = '';

    public bool $click_search_area = false;

    public string $bedroom = '';

    public string $type = '';

    // public function mount(): void
    // {
    //     $this->loadAreas();
    // }

    public function areas(): object
    {
        $service = new AreaService();
        $areas = $service->index(search: $this->search_area, isShow: [true], isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
        $areas->loadMissing(['district']);

        return $areas;
    }

    public function changeArea(int $value): void
    {
        $this->reset(['search_area']);
        $area = $this->areas()->firstWhere('id', $value);
        $this->search_area = "{$area->name}, {$area->district?->name}";
        $this->id_area = $area->id;
    }

    public function removeArea(): void
    {
        $this->reset(['id_area', 'search_area']);
    }

    public function changeBedroom(string $value = ''): void
    {
        $this->bedroom = $value;
    }

    public function changeType(string $value = ''): void
    {
        $this->type = $value;
    }

    public function propertyBedrooms(): array
    {
        return PropertyBedroom::cases();
    }

    public function propertyTypes(): array
    {
        return PropertyType::cases();
    }
};
?>

<div class="card card-body">
    <h5 class="card-title mb-4">{{ trans('home.form.title') }}</h5>

    <form wire:submit.prevent="submit" role="form" autocomplete="off">
        <div class="row g-4">
            <div class="col-12">
                {{-- prettier-ignore --}}
                <x-home.search.area
                :id-area="$id_area"
                :search-area="$search_area"
                :areas="$this->areas()"
                />
            </div>

            <div class="col-6">
                <label class="form-label">
                    <span class="fas fa-calendar fa-fw"></span>
                    {{ trans('validation.attributes.when') }}
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <input type="text" class="form-control" minlength="1" maxlength="50"
                        placeholder="{{ trans('home.form.when') }}" required wire:model="form.name"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
            </div>

            <div class="col-6">
                <label class="form-label">
                    <span class="fas fa-bed fa-fw"></span>
                    {{ trans('validation.attributes.bedroom') }}
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    {{-- <select class="form-select" id="bedrooms" name="bedrooms"
                        placeholder="{{ trans('home.form.bedrooms') }}" required wire:model="form.bedrooms"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                        <option class="">
                            {{ trans('index.all') }} {{ trans('field.type') }}
                        </option>
                        @foreach ($this->propertyTypes() as $propertyType)
                            <option value="{{ $propertyType->value }}" wire:key="property-type-{{ $propertyType }}">
                                {{ $propertyType->name }}
                            </option>
                        @endforeach
                    </select> --}}

                    <button type="button"
                        class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
                        data-bs-toggle="dropdown">
                        @if ($bedroom)
                            {{ PropertyBedroom::getDescription($bedroom) }}
                        @else
                            {{ trans('index.all') }}
                        @endif
                    </button>

                    <ul class="dropdown-menu w-100 mt-2">
                        <li wire:key="bedroom">
                            <button type="button" class="dropdown-item" wire:click="changeBedroom">
                                {{ trans('index.all') }}
                            </button>
                        </li>
                        @foreach ($this->propertyBedrooms() as $propertyBedroom)
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

            <div class="col-6">
                <label class="form-label">
                    <span class="fas fa-building fa-fw"></span>
                    {{ trans('validation.attributes.property_type') }}
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    {{-- <select class="form-select" id="property_type" name="property_type"
                        placeholder="{{ trans('home.form.property_type') }}" required wire:model="form.property_type"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                        <option class="">
                            {{ trans('index.all') }} {{ trans('field.type') }}
                        </option>
                        @foreach ($propertyTypes as $propertyType)
                            <option value="{{ $propertyType->value }}" wire:key="property-type-{{ $propertyType }}">
                                {{ $propertyType->name }}
                            </option>
                        @endforeach
                    </select> --}}

                    <div class="dropdown w-100">
                        {{-- <input type="text" class="form-control" readonly minlength="1" maxlength="50"
                            data-bs-toggle="dropdown" placeholder="{{ trans('home.form.type') }}" required
                            wire:model="type" wire:offline.class="disabled" wire:offline.attr="disabled"
                            wire:loading.class="disabled" wire:loading.attr="disabled"> --}}

                        <button type="button"
                            class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
                            data-bs-toggle="dropdown">
                            @if ($type)
                                {{ PropertyType::getDescription($type) }}
                            @else
                                {{ trans('index.all') }} {{ trans('field.type') }}
                            @endif
                        </button>

                        <ul class="dropdown-menu w-100 mt-2">
                            <li wire:key="type">
                                <button type="button" class="dropdown-item" wire:click="changeType">
                                    {{ trans('index.all') }} {{ trans('field.type') }}
                                </button>
                            </li>
                            @foreach ($this->propertyTypes() as $propertyType)
                                <li wire:key="property-type-{{ $propertyType }}">
                                    <button type="button" class="dropdown-item"
                                        wire:click="changeType({{ $propertyType->value }})">
                                        {{ $propertyType->description() }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <label class="form-label">
                    <span class="fas fa-tags fa-fw"></span>
                    {{ trans('validation.attributes.price_range') }}
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="dropdown w-100">
                        <input type="text" class="form-control" minlength="1" maxlength="50"
                            placeholder="{{ trans('home.form.price_range') }}" required wire:model="form.name"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success w-100 rounded-5">
                    <span class="fas fa-search fa-fw"></span>
                    {{ trans('home.form.button') }}
                </button>
            </div>
        </div>
    </form>
</div>
