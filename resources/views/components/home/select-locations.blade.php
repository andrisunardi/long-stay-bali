<?php

use App\Livewire\Component;
use App\Services\PropertyService;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public object $properties;

    public function mount(): void
    {
        $service = new PropertyService();
        $this->properties = $service->index(statuses: [PropertyStatus::AcceptUpper->value, PropertyStatus::AcceptPremium->value], limit: 4, paginate: false);
        $this->properties->loadMissing(['area', 'district', 'image']);
    }
};
?>

@placeholder
    <section class="py-5 bg-light">
        <div class="container-md">
            <div class="d-grid gap-4">
                <div class="text-start">
                    <div class="placeholder-glow">
                        <span class="placeholder rounded col-10 col-lg-8 col-xl-6 display-6"></span>
                    </div>
                    <div class="placeholder-glow">
                        <span class="placeholder rounded col-12 col-sm-10 col-lg-7 col-xl-5 small"></span>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 justify-content-end g-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="col">
                            <div class="ratio ratio-16x9 overflow-hidden">
                                <div class="placeholder-glow w-100 h-100">
                                    <span class="placeholder w-100 h-100 rounded"></span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
@endplaceholder

<section class="py-5 bg-light">
    <div class="container-md">
        <div class="d-grid gap-4">
            <div class="text-start">
                <h1 class="display-6 fw-medium">{{ trans('home.select_locations.title') }}</h1>
                <p class="small text-muted">{{ trans('home.select_locations.description') }}</p>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 justify-content-end g-4">
                @foreach ($properties as $property)
                    <div class="col" wire:key="property-{{ $property->id }}">
                        <div class="ratio ratio-16x9 overflow-hidden">
                            <a draggable="false" href="{{ route('property.detail', ['slug' => $property['slug']]) }}"
                                wire:navigate>
                                <img draggable="false" loading="lazy" decoding="async"
                                    class="img-fluid w-100 h-100 object-fit-cover rounded user-select-none pe-none"
                                    src="{{ $property->image->image_url ?? asset('images/placeholder.png') }}"
                                    alt="{{ trans('home.select_locations.property') }} - {{ $property->name }} - {{ config('constants.meta.title') }}"
                                    onerror="this.onerror=null; this.src='/images/placeholder.png';" />

                                @if ($property->area || $property->district)
                                    <div class="position-absolute top-0 start-0 w-100 p-3">
                                        <span class="badge rounded-pill text-bg-success">
                                            {{ $property->area?->name ?? $property->district?->name }}
                                        </span>
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
