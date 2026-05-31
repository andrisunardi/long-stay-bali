<?php

use App\Enums\BudgetType;
use App\Livewire\Component;
use App\Services\AreaService;
use Livewire\Attributes\Url;

new class extends Component {
    #[Url(except: null)]
    public ?int $area_id = null;

    public string $search_area = '';

    #[Url(except: [])]
    public array $bedrooms = [];

    #[Url(except: null)]
    public ?int $living_style = null;

    #[Url(except: [])]
    public array $prices = [
        'type' => null,
        'monthly' => [
            'min' => null,
            'max' => null,
        ],
        'yearly' => [
            'min' => null,
            'max' => null,
        ],
    ];

    public int $monthly_min = 40000000;

    public int $monthly_max = 250000000;

    public int $yearly_min = 350000000;

    public int $yearly_max = 2500000000;

    public function mount(): void
    {
        if ($this->area_id) {
            $area = $this->areas()->firstWhere('id', $this->area_id);
            $this->search_area = "{$area->name}, {$area->district?->name}";
        }

        if (isset($this->prices['budget_type'])) {
            if ($this->prices['budget_type'] == BudgetType::Monthly->value) {
                $this->prices['monthly']['min'] = $this->prices['monthly']['min'] ?? $this->monthly_min;
                $this->prices['monthly']['max'] = $this->prices['monthly']['max'] ?? $this->monthly_max;
            }

            if ($this->prices['budget_type'] == BudgetType::Yearly->value) {
                $this->prices['yearly']['min'] = $this->prices['yearly']['min'] ?? $this->yearly_min;
                $this->prices['yearly']['max'] = $this->prices['yearly']['max'] ?? $this->yearly_max;
            }
        }
    }

    public function suggestedDestinations(): object
    {
        $service = new AreaService();
        $areas = $service->index(isPromoted: [true], isShow: [true], isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
        $areas->loadMissing(['district']);

        return $areas;
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

    public function changeBedrooms(?int $value = null): void
    {
        if (!$value) {
            $this->reset('bedrooms');

            return;
        }

        $this->bedrooms = in_array($value, $this->bedrooms) ? array_values(array_diff($this->bedrooms, [$value])) : [...$this->bedrooms, $value];
    }

    public function changeLivingStyle(?int $livingStyle = null): void
    {
        $this->living_style = $livingStyle;
    }

    public function clearAllPrice(): void
    {
        $this->reset(['prices']);
    }

    public function changeBudgetType(?int $value = null): void
    {
        $this->reset(['prices']);
        $this->prices['budget_type'] = $value;

        if ($value == BudgetType::Monthly->value) {
            $this->prices['monthly']['min'] = $this->monthly_min;
            $this->prices['monthly']['max'] = $this->monthly_max;
        }

        if ($value == BudgetType::Yearly->value) {
            $this->prices['yearly']['min'] = $this->yearly_min;
            $this->prices['yearly']['max'] = $this->yearly_max;
        }

        $this->dispatch('price-slider');
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
                :suggested-destinations="$this->suggestedDestinations()"
                :areas="$this->areas()"
                />
            </div>

            <div class="col-6">
                <x-search.bedrooms :bedrooms="$bedrooms" />
            </div>

            <div class="col-6">
                <x-search.living-style :living-style="$living_style" />
            </div>

            <div class="col-12">
                {{-- prettier-ignore --}}
                <x-search.price
                :prices="$prices"
                :monthly-min="$monthly_min"
                :monthly-max="$monthly_max"
                :yearly-min="$yearly_min"
                :yearly-max="$yearly_max"
                />
            </div>

            <div class="col-12">
                {{-- prettier-ignore --}}
                <x-home.search.button
                :area-id="$area_id"
                :bedrooms="$bedrooms"
                :living-style="$living_style"
                :prices="$prices"
                />
            </div>
        </div>
    </form>
</div>
