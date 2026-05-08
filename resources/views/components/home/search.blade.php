<?php

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyType;
use App\Livewire\Component;
use App\Services\AreaService;
use Livewire\Attributes\Url;

new class extends Component {
    #[Url(except: null)]
    public ?int $id_area = null;

    public string $search_area = '';

    public bool $click_search_area = false;

    #[Url(except: null)]
    public string $bedroom = '';

    #[Url(except: null)]
    public int $min_price = 0;

    #[Url(except: null)]
    public int $max_price = 100000000000;

    public string $type = '';

    public function mount(): void
    {
        if ($this->id_area) {
            $area = $this->areas()->firstWhere('id', $this->id_area);
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
    <h5 class="card-title mb-4">{{ trans('home.search.title') }}</h5>

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
                <a draggable="false"
                    href="{{ route('property.index', [
                        'area_id' => $id_area,
                        'bedroom' => $bedroom,
                        'min_price' => $min_price,
                        'max_price' => $max_price,
                    ]) }}"
                    class="btn btn-success w-100 rounded-5" wire:navigate>
                    <span class="fas fa-search fa-fw"></span>
                    {{ trans('home.search.button') }}
                </a>
            </div>
        </div>
    </form>
</div>
