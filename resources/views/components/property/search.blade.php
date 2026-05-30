<?php

use App\Enums\BudgetType;
use App\Enums\Property\PropertyBedroom;
use App\Livewire\Component;
use App\Services\AreaService;
use Livewire\Attributes\Url;

new class extends Component {
    #[Url(except: null)]
    public ?int $area_id = null;

    #[Url(except: null)]
    public ?int $areaId = null;

    public string $search_area = '';

    #[Url(except: null)]
    public ?string $start_date = null;

    #[Url(except: null)]
    public ?string $end_date = null;

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
        if ($this->areaId) {
            $area = $this->areas()->firstWhere('id', $this->areaId);
            $this->search_area = "{$area->name}, {$area->district?->name}";
        }

        if (!$this->start_date) {
            $this->start_date = now()->toDateString();
        }

        if (!$this->end_date) {
            $this->end_date = now()->toDateString();
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

    public function changeArea(int $value): void
    {
        $this->reset(['search_area']);
        $area = $this->areas()->firstWhere('id', $value);
        $this->search_area = "{$area->name}, {$area->district?->name}";
        $this->areaId = $area->id;

        $this->dispatch('area-changed', id: $area->id, name: $this->search_area);
    }

    public function removeArea(): void
    {
        $this->reset(['areaId', 'search_area']);
        $this->dispatch('area-changed', id: null, name: '');
    }

    public function changeBedrooms(?int $value = null): void
    {
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
    }

    public function areas(): object
    {
        $service = new AreaService();
        $areas = $service->index(search: $this->search_area, isShow: [true], isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
        $areas->loadMissing(['district']);

        return $areas;
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

<section class="pt-5">
    <div class="container-md">
        <div class="row g-4">
            <div class="col-lg-3">
                {{-- prettier-ignore --}}
                <x-property.search.area
                :area-id="$areaId"
                :search-area="$search_area"
                :areas="$this->areas()"
                />
            </div>

            <div class="col-lg-3">
                <div wire:ignore>
                    <label class="form-label">
                        <span class="fas fa-calendar fa-fw"></span>
                        {{ trans('validation.attributes.when') }}
                    </label>
                    <input type="text" id="daterange" class="form-control" autocomplete="off" readonly>
                </div>
            </div>

            <div class="col-6 col-lg-2 col-xl-auto">
                <x-search.bedrooms :bedrooms="$bedrooms" />
            </div>

            <div class="col-6 col-lg-2 col-xl-auto">
                <x-search.living-style :living-style="$living_style" />
            </div>

            <div class="col-lg-4 col-xl-3">
                {{-- prettier-ignore --}}
                <x-search.price
                :prices="$prices"
                :monthly-min="$monthly_min"
                :monthly-max="$monthly_max"
                :yearly-min="$yearly_min"
                :yearly-max="$yearly_max"
                />
            </div>
        </div>
    </div>
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
