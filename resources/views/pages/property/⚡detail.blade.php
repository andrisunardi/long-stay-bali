<?php

use App\Livewire\Component;
use App\Models\Property;
use App\Services\PropertyService;
use Livewire\Attributes\Title;

new #[Title('Property Detail')] class extends Component {
    public ?Property $property = null;

    public bool $monthlyHasInclusions = false;

    public bool $yearlyHasInclusions = false;

    public function mount(string $slug): void
    {
        $service = new PropertyService();
        $this->property = $service->detail(slug: $slug);

        if (!$this->property) {
            abort(404);
        }

        $this->property->loadMissing(['area.district', 'image']);

        $this->monthlyHasInclusions = collect($this->property->monthly_inclusions ?? [])
            ->only(['housekeeper', 'gardener', 'pool_guy', 'internet', 'garbage', 'banjar', 'security', 'electricity', 'others'])
            ->filter()
            ->isNotEmpty();

        $this->yearlyHasInclusions = collect($this->property->yearly_inclusions ?? [])
            ->only(['housekeeper', 'gardener', 'pool_guy', 'internet', 'garbage', 'banjar', 'security', 'electricity', 'others'])
            ->filter()
            ->isNotEmpty();

        $service->counter(property: $this->property);
    }
};
?>

@section('title', $property->name)

<div>
    <section class="py-5">
        <div class="container-md">
            <div class="d-grid gap-4">
                <x-property.images :property="$property" />

                <div class="row">
                    <div class="col-12">
                        <x-property.information :property="$property" />

                        <hr class="my-4" />

                        <div class="row g-4">
                            <div class="col-lg-6">
                                <x-property.details :property="$property" />
                            </div>
                            <div class="col-lg-6">
                                {{-- prettier-ignore --}}
                                <x-property.inclusions
                                :property="$property"
                                :monthly-has-inclusions="$monthlyHasInclusions"
                                :yearly-has-inclusions="$yearlyHasInclusions"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
