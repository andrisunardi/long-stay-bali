<?php

use App\Enums\BudgetType;
use App\Enums\Property\PropertyBedroom;
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

    #[Url(except: null)]
    public ?string $start_date = null;

    #[Url(except: null)]
    public ?string $end_date = null;

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

        if (!$this->start_date) {
            $this->start_date = now()->toDateString();
        }

        if (!$this->end_date) {
            $this->end_date = now()->toDateString();
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
        $selectedAreas = collect();

        $districts = $this->districts()->whereIn('id', $values);

        foreach ($districts as $district) {
            $selectedAreas = $selectedAreas->merge($district->areas->pluck('id'));
        }

        $this->areas = $selectedAreas->unique()->values()->all();

        $this->area = collect()->merge($districts->pluck('name'))->join(', ');

        $this->dispatch('keep-area-dropdown-open');
        $this->dispatch('districts-changed', districts: $this->districts);
    }

    public function updatedAreas(array $values = []): void
    {
        $areas = $this->districts()->pluck('areas')->flatten()->whereIn('id', $values);
        $this->area = $areas->pluck('name')->join(', ');

        $this->dispatch('keep-area-dropdown-open');
        $this->dispatch('areas-changed', areas: $this->areas);
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

        if ($rentalType == PropertyRentalType::Both->value) {
            $this->prices['min'] = $this->monthly_min;
            $this->prices['max'] = $this->monthly_max;
            $this->price_min = $this->monthly_min;
            $this->price_max = $this->monthly_max;
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
                <div class="card card-body">
                    <a draggable="false" data-bs-toggle="modal" data-bs-target="#modal-search">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="fas fa-search fa-fw"></span>
                            </div>
                            <div class="col">
                                <div class="fw-bold">
                                    {{ $area }}
                                </div>
                                <div>
                                    <span class="fas fa-bed fa-fw"></span>
                                    @if ($bedrooms)
                                        {{ collect($bedrooms)->map(fn($bedroom) => PropertyBedroom::from($bedroom)->description())->join(', ') }}
                                    @else
                                        {{ trans('index.all') }}
                                    @endif
                                    <span> | </span>
                                    <span class="fas fa-couch fa-fw"></span>
                                    @if ($living_style)
                                        {{ PropertyLivingStyle::from($living_style)->translate() }}
                                    @else
                                        {{ trans('index.all') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
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
                <div wire:ignore>
                    <label class="form-label">
                        <span class="fas fa-calendar fa-fw"></span>
                        {{ trans('validation.attributes.when') }}
                    </label>
                    <input type="text" id="daterange" class="form-control" autocomplete="off" readonly>
                </div>
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
    :bedrooms="$bedrooms"
    :living-style="$living_style"
    :rental-type="$rental_type"
    :prices="$prices"
    :price-min="$price_min"
    :price-max="$price_max"
    />
</section>

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css">
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            const isMobile = window.innerWidth < 576

            new Litepicker({
                element: document.getElementById('daterange'),
                singleMode: false,
                numberOfMonths: isMobile ? 1 : 2,
                numberOfColumns: isMobile ? 1 : 2,
                minDate: new Date(),
                format: 'DD MMM YYYY',
                startDate: '{{ $start_date }}',
                endDate: '{{ $end_date }}',
                setup: (picker) => {
                    picker.on('selected', (start, end) => {
                        @this.set(
                            'start_date',
                            start ? start.format('YYYY-MM-DD') : null
                        )
                        @this.set(
                            'end_date',
                            end ? end.format('YYYY-MM-DD') : null
                        )
                    })
                }
            })
        })
    </script>
@endpush
