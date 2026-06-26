<?php

use App\Enums\BudgetType;
use App\Enums\Property\PropertyBedroom;
use App\Livewire\Component;
use App\Services\AreaService;
use App\Services\DistrictService;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Url;

new class extends Component {
    public string $area = '';

    #[Url(except: [])]
    public array $districts = [];

    #[Url(except: [])]
    public array $areas = [];

    #[Url(except: null)]
    public ?string $month = null;

    public object $calendars;

    #[Url(except: null)]
    public ?string $date = null;

    public ?string $startDate = null;

    public ?string $endDate = null;

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
            $this->syncLocations();
        }

        $this->calendars();

        $this->date = $this->date ?? now()->toDateString();
        $this->startDate = $this->date;
        $this->endDate = Carbon::parse($this->date)->addMonth();

        $minimumDate = now()->addMonth()->toDateString();
        if ($this->rental_type == PropertyRentalType::Yearly->value && Carbon::parse($this->date)->lt($minimumDate)) {
            $this->date = $minimumDate;
            $this->startDate = $this->date;
            $this->endDate = Carbon::parse($this->date)->addMonth();
        }

        if ($this->rental_type == PropertyRentalType::Monthly->value) {
            $this->prices['min'] = $this->prices['min'] ?? $this->monthly_min;
            $this->prices['max'] = $this->prices['max'] ?? $this->monthly_max;

            $this->price_min = $this->monthly_min;
            $this->price_max = $this->monthly_max;

            $this->startDate = $this->date;
            $this->endDate = Carbon::parse($this->date)->addMonth();
        }

        if ($this->rental_type == PropertyRentalType::Yearly->value) {
            $this->prices['min'] = $this->prices['min'] ?? $this->yearly_min;
            $this->prices['max'] = $this->prices['max'] ?? $this->yearly_max;

            $this->price_min = $this->yearly_min;
            $this->price_max = $this->yearly_max;

            $this->startDate = $this->date;
            $this->endDate = Carbon::parse($this->date)->addYear();
        }
    }

    public function updatedDistricts(): void
    {
        $this->dispatch('keep-area-dropdown-open');

        $this->syncLocations();
    }

    public function updatedAreas(): void
    {
        $this->dispatch('keep-area-dropdown-open');

        $autoDistrictIds = collect();

        foreach ($this->districts() as $district) {
            $areaIds = $district->areas->pluck('id');

            if ($areaIds->isNotEmpty() && $areaIds->diff($this->areas)->isEmpty()) {
                $autoDistrictIds->push($district->id);
            }
        }

        $this->districts = collect($this->districts)->merge($autoDistrictIds)->unique()->values()->all();

        $this->syncAreaLabel();
    }

    protected function syncLocations(): void
    {
        $districts = $this->districts();

        $selectedDistrictIds = collect($this->districts);
        $selectedAreaIds = collect($this->areas);

        foreach ($districts->whereIn('id', $selectedDistrictIds) as $district) {
            $selectedAreaIds = $selectedAreaIds->merge($district->areas->pluck('id'));
        }

        foreach ($districts as $district) {
            $districtAreaIds = $district->areas->pluck('id');

            if ($districtAreaIds->isNotEmpty() && $districtAreaIds->diff($selectedAreaIds)->isEmpty()) {
                $selectedDistrictIds->push($district->id);
            }
        }

        $this->districts = $selectedDistrictIds->unique()->values()->all();

        $this->areas = $selectedAreaIds->unique()->values()->all();

        $this->syncAreaLabel();
    }

    protected function syncAreaLabel(): void
    {
        $names = collect();

        foreach ($this->districts() as $district) {
            if (in_array($district->id, $this->districts)) {
                $names->push($district->name);

                continue;
            }

            $names = $names->merge($district->areas->whereIn('id', $this->areas)->pluck('name'));
        }

        $this->area = $names->unique()->join(', ');
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

    public function changeRentalType(?int $rentalType = null): void
    {
        $this->rental_type = $rentalType;
        $this->dispatch('keep-when-dropdown-open');

        if ($this->rental_type == PropertyRentalType::Monthly->value) {
            $this->month = now()->format('Y-m');
            $this->date = now()->toDateString();
            $this->startDate = $this->date;
            $this->endDate = Carbon::parse($this->startDate)->addMonth();
        }

        if ($this->rental_type == PropertyRentalType::Yearly->value) {
            $this->month = now()->addMonth()->format('Y-m');
            $this->date = now()->addMonth()->toDateString();
            $this->startDate = $this->date;
            $this->endDate = Carbon::parse($this->startDate)->addYear();
        }

        $this->calendars();
    }

    public function calendars(): void
    {
        $this->month = $this->month ?? ($this->rental_type === PropertyRentalType::Yearly->value ? now()->addMonth()->format('Y-m') : now()->format('Y-m'));
        $this->calendars = collect();

        $month = Carbon::parse($this->month)->startOfMonth();
        $start = $month->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $end = $month->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        for ($date = $start; $date->lte($end); $date->addDay()) {
            $this->calendars->push($date->copy());
        }
    }

    public function previousMonth(): void
    {
        $this->month = Carbon::parse($this->month)->subMonth()->format('Y-m');
        $this->calendars();
        $this->dispatch('keep-when-dropdown-open');
    }

    public function nextMonth(): void
    {
        $this->month = Carbon::parse($this->month)->addMonth()->format('Y-m');
        $this->calendars();
        $this->dispatch('keep-when-dropdown-open');
    }

    public function selectDate(string $date): void
    {
        $this->dispatch('keep-when-dropdown-open');

        $this->date = $date;
        $this->startDate = $this->date;
        $this->endDate = Carbon::parse($this->startDate)->addMonth()->toDateString();

        if ($this->rental_type == PropertyRentalType::Yearly->value) {
            $this->endDate = Carbon::parse($this->startDate)->addYear()->toDateString();
        }
    }

    public function changeBedrooms(?int $value = null): void
    {
        $this->dispatch('keep-bedroom-dropdown-open');

        if (!$value) {
            $this->reset('bedrooms');
            $this->dispatch('bedrooms-changed', bedrooms: []);

            return;
        }

        $this->bedrooms = in_array($value, $this->bedrooms) ? array_values(array_diff($this->bedrooms, [$value])) : [...$this->bedrooms, $value];
        $this->dispatch('bedrooms-changed', bedrooms: $this->bedrooms);
    }

    public function changeLivingStyle(?int $livingStyle = null): void
    {
        $this->living_style = $livingStyle;
        $this->dispatch('living-style-changed', livingStyle: $this->living_style);
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

        $this->dispatch('price-slider');
        $this->dispatch('prices-changed', prices: $this->prices);
        $this->dispatch('rental-type-changed', rentalType: $this->rental_type);
    }

    public function clearAllPrice(): void
    {
        $this->reset(['rental_type', 'prices']);
        $this->dispatch('prices-changed', prices: $this->prices);
        $this->dispatch('rental-type-changed', rentalType: null);
    }

    public function updatedPricesMin(int $price): void
    {
        $this->prices['min'] = $price;
        $this->dispatch('prices-changed', prices: $this->prices);
    }

    public function updatedPricesMax(int $price): void
    {
        $this->prices['max'] = $price;
        $this->dispatch('prices-changed', prices: $this->prices);
    }
};
?>

<section class="pt-5">
    <div class="container-md d-block d-lg-none">
        <div class="row align-items-center">
            <div class="col-auto">
                <a draggable="false" class="text-body" href="{{ route('home') }}" wire:navigate>
                    <span class="fas fa-chevron-left fa-fw"></span>
                </a>
            </div>
            <div class="col">
                {{-- prettier-ignore --}}
                <x-search.card
                :area="$area"
                :bedrooms="$bedrooms"
                :living-style="$living_style"
                />
            </div>
        </div>
    </div>

    <div class="container-md d-none d-lg-block">
        <div class="row g-4">
            <div class="col-sm-6 col-lg-4">
                {{-- prettier-ignore --}}
                <x-search.area
                :area="$area"
                :districts="$districts"
                :areas="$areas"
                :list-districts="$this->districts()"
                />
            </div>

            <div class="col-sm-6 col-lg-4">
                {{-- prettier-ignore --}}
                <x-search.when
                :rental-type="$rental_type"
                :month="$month"
                :calendars="$calendars"
                :start-date="$startDate"
                :end-date="$endDate"
                />
            </div>

            <div class="col-6 col-lg-2">
                <x-search.bedrooms :bedrooms="$bedrooms" />
            </div>

            <div class="col-6 col-lg-2">
                <x-search.living-style :living-style="$living_style" />
            </div>

            <div class="col-sm-6 col-lg-4">
                <label class="form-label">{{ trans('property.rental_type') }}</label>
                <x-search.rental-type :rental-type="$rental_type" />
            </div>

            <div class="col-sm-6 col-lg-4">
                @if ($rental_type)
                    {{-- prettier-ignore --}}
                    <x-search.price
                    :rental-type="$rental_type"
                    :prices="$prices"
                    :price-min="$price_min"
                    :price-max="$price_max"
                    />
                @endif
            </div>

            <div class="col-sm-6 col-lg-4">
                <label class="form-label">&nbsp;</label>
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
    </div>

    {{-- prettier-ignore --}}
    <x-modal.search
    :area="$area"
    :districts="$districts"
    :areas="$areas"
    :list-districts="$this->districts()"
    :month="$month"
    :calendars="$calendars"
    :start-date="$startDate"
    :end-date="$endDate"
    :bedrooms="$bedrooms"
    :living-style="$living_style"
    :rental-type="$rental_type"
    :prices="$prices"
    :price-min="$price_min"
    :price-max="$price_max"
    />
</section>
