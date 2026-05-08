<?php

use App\Enums\Property\PropertyBedroom;
use App\Livewire\Component;
use App\Services\AreaService;
use Livewire\Attributes\Url;

new class extends Component {
    #[Url(except: null)]
    public ?int $area_id = null;

    public string $search_area = '';

    #[Url(except: null)]
    public ?int $bedroom = null;

    #[Url(except: null)]
    public int $min_price = 0;

    #[Url(except: null)]
    public int $max_price = 100000000000;

    public function mount(): void
    {
        if ($this->area_id) {
            $area = $this->areas()->firstWhere('id', $this->area_id);
            $this->search_area = "{$area->name}, {$area->district?->name}";
        }
    }

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
        $this->area_id = $area->id;
    }

    public function removeArea(): void
    {
        $this->reset(['area_id', 'search_area']);
    }

    public function changeBedroom(?int $value = null): void
    {
        $this->bedroom = $value;
    }

    public function propertyBedrooms(): array
    {
        return PropertyBedroom::cases();
    }
};
?>

<div class="card card-body">
    <h5 class="card-title mb-4">{{ trans('home.search.title') }}</h5>

    <form wire:submit.prevent="submit" role="form" autocomplete="off">
        <div class="row g-4">
            <div class="col-12">
                {{-- prettier-ignore --}}
                <x-home.search.area
                :area-id="$area_id"
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
                        placeholder="{{ trans('home.search.when') }}" required wire:model="form.name"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
            </div>

            <div class="col-6">
                {{-- prettier-ignore --}}
                <x-home.search.bedroom
                :bedroom="$bedroom"
                :property-bedrooms="$this->propertyBedrooms()"
                />
            </div>

            <div class="col-12">
                {{-- prettier-ignore --}}
                <x-home.search.price
                :min-price="$min_price"
                :max-price="$max_price"
                />
            </div>

            <div class="col-12">
                {{-- prettier-ignore --}}
                <x-home.search.button
                :area-id="$min_price"
                :bedroom="$max_price"
                :min-price="$min_price"
                :max-price="$max_price"
                />
            </div>
        </div>
    </form>
</div>
