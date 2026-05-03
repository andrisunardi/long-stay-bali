<?php

use App\Livewire\Component;
use App\Models\Property;
use App\Services\PropertyService;
use Livewire\Attributes\Title;

new #[Title('Property Detail')] class extends Component {
    public Property $property;

    public function mount(string $slug): void
    {
        $service = new PropertyService();
        $this->property = $service->detail(slug: $slug);
        $this->property->loadMissing(['area', 'image']);
    }
};
?>

@section('title', $property->name)

<section class="py-5">
    <div class="container-md py-5 my-5">
        <div class="d-grid gap-4">
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="ratio ratio-16x9 h-100">
                        <img draggable="false"
                            class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                            src="{{ $property->image?->image_url ?? asset('images/image-not-available.png') }}"
                            alt="{{ trans('property.property') }} - {{ $property->name }} - {{ config('constants.title') }}" />
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row g-3">
                        @foreach ($property->images->take(4) as $propertyImage)
                            <div class="col-6" wire:key="property-image-{{ $propertyImage->id }}">
                                <div class="ratio ratio-16x9">
                                    <img draggable="false"
                                        class="img-fluid w-100 h-100 rounded object-fit-cover user-select-none pe-none"
                                        src="{{ $propertyImage->image_url ?? asset('images/image-not-available.png') }}"
                                        alt="{{ trans('property.property') }} - {{ trans('property.image') }} - {{ $property->name }} - {{ config('constants.title') }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
