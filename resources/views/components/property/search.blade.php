<?php

use App\Livewire\Component;
use App\Services\AreaService;

new class extends Component {
    public ?int $areaId = null;

    public string $search_area = '';

    public function mount(): void
    {
        if ($this->areaId) {
            $area = $this->areas()->firstWhere('id', $this->areaId);
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
        $this->areaId = $area->id;

        $this->dispatch('area-id-changed', id: $value);
    }

    public function removeArea(): void
    {
        $this->reset(['areaId', 'search_area']);
        $this->dispatch('area-id-changed', id: null);
    }
};
?>

<section class="py-5">
    <div class="container-md">
        <div class="row">
            <div class="col-sm-6 col-xl">
                {{-- prettier-ignore --}}
                <x-property.search.area
                :area-id="$areaId"
                :search-area="$search_area"
                :areas="$this->areas()"
                />
            </div>
        </div>
    </div>
</section>
