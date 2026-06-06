<?php

use App\Enums\Property\PropertyRentalType;
use App\Livewire\Component;
use App\Services\AreaService;
use App\Services\DistrictService;
use Livewire\Attributes\Url;

new class extends Component {
    public string $area = '';

    #[Url(except: [])]
    public array $districts = [];

    #[Url(except: [])]
    public array $areas = [];

    #[Url(except: [])]
    public array $bedrooms = [];

    #[Url(except: null)]
    public ?int $living_style = null;

    #[Url(except: null)]
    public ?int $rental_type = null;

    #[Url(except: [])]
    public array $prices = [
        'min' => null,
        'max' => null,
    ];

    public int $price_min = 0;

    public int $price_max = 0;

    public int $monthly_min = 40000000;

    public int $monthly_max = 250000000;

    public int $yearly_min = 350000000;

    public int $yearly_max = 2500000000;

    public function mount(): void
    {
        if ($this->districts || $this->areas) {
            $selectedDistricts = $this->districts()->whereIn('id', $this->districts);

            $selectedAreas = $this->districts()->pluck('areas')->flatten()->whereIn('id', $this->areas);

            $this->area = collect()->merge($selectedDistricts->pluck('name'))->merge($selectedAreas->pluck('name'))->unique()->join(', ');
        }

        if ($this->rental_type == PropertyRentalType::Monthly->value) {
            $this->prices['min'] = $this->prices['min'] ?? $this->monthly_min;
            $this->prices['max'] = $this->prices['max'] ?? $this->monthly_max;
            $this->price_min = $this->monthly_min;
            $this->price_max = $this->monthly_max;
        }

        if ($this->rental_type == PropertyRentalType::Yearly->value) {
            $this->prices['min'] = $this->prices['min'] ?? $this->yearly_min;
            $this->prices['max'] = $this->prices['max'] ?? $this->yearly_max;
            $this->price_min = $this->yearly_min;
            $this->price_max = $this->yearly_max;
        }

        if ($this->rental_type == PropertyRentalType::Both->value) {
            $this->prices['min'] = $this->monthly_min;
            $this->prices['max'] = $this->monthly_max;
            $this->price_min = $this->monthly_min;
            $this->price_max = $this->monthly_max;
        }
    }

    public function updatedDistricts(array $values = []): void
    {
        $this->dispatch('keep-area-dropdown-open');

        $selectedAreas = collect();

        $districts = $this->districts()->whereIn('id', $values);

        foreach ($districts as $district) {
            $selectedAreas = $selectedAreas->merge($district->areas->pluck('id'));
        }

        $this->areas = $selectedAreas->unique()->values()->all();

        $this->area = collect()->merge($districts->pluck('name'))->join(', ');
    }

    public function updatedAreas(array $values = []): void
    {
        $this->dispatch('keep-area-dropdown-open');

        $areas = $this->districts()->pluck('areas')->flatten()->whereIn('id', $values);

        $this->area = $areas->pluck('name')->join(', ');
    }

    public function clearAllArea(): void
    {
        $this->dispatch('keep-area-dropdown-open');

        $this->reset(['area', 'districts', 'areas']);
    }

    public function districts(): object
    {
        $service = new DistrictService();
        $districts = $service->index(isShow: [true], isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
        $districts->loadMissing(['areas' => fn($q) => $q->show()->active()]);

        return $districts;
    }

    public function changeBedrooms(?int $value = null): void
    {
        $this->dispatch('keep-bedroom-dropdown-open');

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

    public function changePropertyRentalType(?int $rentalType = null): void
    {
        $this->reset(['prices']);
        $this->rental_type = $rentalType;

        if ($rentalType == PropertyRentalType::Monthly->value) {
            $this->prices['min'] = $this->monthly_min;
            $this->prices['max'] = $this->monthly_max;
            $this->price_min = $this->monthly_min;
            $this->price_max = $this->monthly_max;
        }

        if ($rentalType == PropertyRentalType::Yearly->value) {
            $this->prices['min'] = $this->yearly_min;
            $this->prices['max'] = $this->yearly_max;
            $this->price_min = $this->yearly_min;
            $this->price_max = $this->yearly_max;
        }

        if ($rentalType == PropertyRentalType::Both->value) {
            $this->prices['min'] = $this->monthly_min;
            $this->prices['max'] = $this->monthly_max;
            $this->price_min = $this->monthly_min;
            $this->price_max = $this->monthly_max;
        }

        $this->dispatch('price-slider');
    }

    public function updatedPrices()
    {
        $this->dispatch('keep-price-dropdown-open');
    }

    public function clearAllPrice(): void
    {
        $this->reset(['rental_type', 'prices']);
    }
};
?>

<div class="card card-body">
    <h5 class="card-title mb-4">{{ trans('home.search.title') }}</h5>

    <form wire:submit.prevent="submit" role="form" autocomplete="off">
        <div class="row g-4">
            <div class="col-12">
                {{-- prettier-ignore --}}
                <x-search.area
                :area="$area"
                :districts="$districts"
                :areas="$areas"
                :list-districts="$this->districts()"
                />
            </div>

            <div class="col-6">
                <x-search.bedrooms :bedrooms="$bedrooms" />
            </div>

            <div class="col-6">
                <x-search.living-style :living-style="$living_style" />
            </div>

            <div class="col-12">
                <x-search.rental-type :rental-type="$rental_type" />
            </div>

            @if ($rental_type)
                <div class="col-12">
                    {{-- prettier-ignore --}}
                    <x-search.price
                    :rental-type="$rental_type"
                    :prices="$prices"
                    :price-min="$price_min"
                    :price-max="$price_max"
                    />
                </div>
            @endif

            <div class="col-12">
                {{-- prettier-ignore --}}
                <x-search.button
                :districts="$districts"
                :areas="$areas"
                :bedrooms="$bedrooms"
                :living-style="$living_style"
                :prices="$prices"
                />
            </div>
        </div>
    </form>
</div>
