<?php

use App\Livewire\Component;
use App\Services\AreaService;
use Livewire\Attributes\Url;

new class extends Component {
    #[Url(except: null)]
    public ?int $area_id = null;

    public string $search_area = '';

    #[Url(except: null)]
    public ?string $start_date = null;

    #[Url(except: null)]
    public ?string $end_date = null;

    #[Url(except: [])]
    public array $bedrooms = [];

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

        if (!$this->start_date) {
            $this->start_date = now()->toDateString();
        }

        if (!$this->end_date) {
            $this->end_date = now()->toDateString();
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

            <div class="col-sm-9 col-lg-8">
                <div wire:ignore>
                    <label class="form-label">
                        <span class="fas fa-calendar fa-fw"></span>
                        {{ trans('validation.attributes.when') }}
                    </label>
                    <input type="text" id="daterange" class="form-control" autocomplete="off" readonly>
                </div>
            </div>

            <div class="col-sm-3 col-lg-4">
                <x-search.bedroom :bedrooms="$bedrooms" />
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
                :area-id="$area_id"
                :bedrooms="$bedrooms"
                :min-price="$min_price"
                :max-price="$max_price"
                />
            </div>
        </div>
    </form>
</div>

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
