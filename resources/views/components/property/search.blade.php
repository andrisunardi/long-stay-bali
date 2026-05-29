<?php

use App\Enums\Property\PropertyBedroom;
use App\Livewire\Component;
use App\Services\AreaService;
use Livewire\Attributes\Url;

new class extends Component {
    public ?int $areaId = null;

    public string $search_area = '';

    #[Url(except: [])]
    public array $bedrooms = [];

    #[Url(except: null)]
    public ?int $living_style = null;

    public function mount(): void
    {
        if ($this->areaId) {
            $area = $this->areas()->firstWhere('id', $this->areaId);
            $this->search_area = "{$area->name}, {$area->district?->name}";
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
};
?>

<section class="pt-5">
    <div class="container-md">
        <div class="row g-4">
            <div class="col-xl">
                {{-- prettier-ignore --}}
                <x-property.search.area
                :area-id="$areaId"
                :search-area="$search_area"
                :areas="$this->areas()"
                />
            </div>

            <div class="col-6 col-xl-2">
                <x-search.bedrooms :bedrooms="$bedrooms" />
            </div>

            <div class="col-6 col-xl-2">
                <x-search.living-style :living-style="$living_style" />
            </div>
        </div>
    </div>
</section>
