<?php

use App\Enums\Property\PropertyStatus;
use App\Livewire\Component;
use App\Services\PropertyService;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;

new #[Lazy] class extends Component {
    #[Reactive]
    public ?int $areaId = null;

    public string $textArea = '';

    public ?int $bedroom = null;

    public int $minPrice = 0;

    public int $maxPrice = 100000000000;

    public function properties(): object
    {
        $service = new PropertyService();
        $properties = $service->index(areaId: $this->areaId, statuses: [PropertyStatus::AcceptUpper->value, PropertyStatus::AcceptPremium->value], paginate: false);
        $properties->loadMissing(['area', 'image']);

        return $properties;
    }
};
?>

@placeholder
    <section class="py-5">
        <div class="container-md">
            <div class="d-flex flex-column gap-4">
                <div>
                    <div class="placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="col">
                            <div class="ratio ratio-16x9 overflow-hidden">
                                <div class="placeholder-glow">
                                    <div class="placeholder w-100 h-100 rounded"></div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="placeholder-glow">
                                    <span class="placeholder col-4"></span>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="placeholder-glow">
                                    <span class="placeholder col-8"></span>
                                </div>
                            </div>

                            <div class="d-flex gap-3 mt-3">
                                <div class="placeholder-glow">
                                    <span class="placeholder col-3 rounded"></span>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-3 rounded"></span>
                                </div>
                            </div>

                            <div class="mt-3 d-grid gap-2">
                                <div class="placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>
@endplaceholder

<section class="py-5">
    <div class="container-md">
        <div class="d-flex flex-column gap-4">
            {{-- <div>
                <p class="lead mb-0">
                    {!! trans('property.property_count', [
                        'count' => $properties->count(),
                        'area' => $text_area ?? 'all areas',
                    ]) !!}
                </p>
            </div> --}}

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach ($this->properties() as $property)
                    <div class="col" wire:key="property-{{ $property['id'] }}">
                        <div class="ratio ratio-16x9 overflow-hidden">
                            <a draggable="false" href="{{ route('property.detail', ['slug' => $property['slug']]) }}"
                                wire:navigate>
                                <img draggable="false" loading="lazy" decoding="async"
                                    class="img-fluid w-100 h-100 object-fit-cover rounded user-select-none pe-none"
                                    src="{{ $property->image->image_url ?? asset('images/placeholder.png') }}"
                                    alt="{{ trans('property.property') }} - {{ $property->name }} - {{ config('constants.meta.title') }}"
                                    onerror="this.onerror=null; this.src='/images/placeholder.png';" />

                                <div class="position-absolute top-0 start-0 w-100">
                                    <span class="bg-sand px-2 rounded-top-start rounded-bottom-end">
                                        <small>{{ trans('property.inquiry_availability') }}</small>
                                    </span>
                                </div>
                            </a>
                        </div>

                        <div class="mt-3">
                            <span class="fas fa-location-dot fa-fw"></span>
                            {{ $property->area->name ?? 'Bali' }}
                        </div>

                        <h1 class="h6 text-truncate mt-3">
                            <a draggable="false" class="text-body"
                                href="{{ route('property.detail', ['slug' => $property->slug]) }}" wire:navigate>
                                {{ $property->name }}
                            </a>
                        </h1>

                        <div class="d-flex gap-3">
                            <span class="px-2 py-1 small rounded bg-sand">
                                <span class="fas fa-location-dot fa-fw fa-xs text-success"></span>
                                <span class="text-black small">Villa</span>
                            </span>

                            <span class="px-2 py-1 small rounded bg-sand">
                                <span class="fas fa-bed fa-fw fa-xs text-success"></span>
                                <span class="text-black small">2 BR</span>
                            </span>
                        </div>

                        <div class="mt-3 d-grid gap-2">
                            <div class="d-flex justify-content-between">
                                <span class="fw-medium">{{ Str::idr($property->monthly_price) }}</span>
                                <span class="text-secondary">{{ trans('property.per_month') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="fw-medium">{{ Str::idr($property->yearly_price) }}</span>
                                <span class="text-secondary">{{ trans('property.per_year') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
