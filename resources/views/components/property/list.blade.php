<?php

use App\Livewire\Component;
use App\Services\PropertyService;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public object $properties;

    public function mount(): void
    {
        $service = new PropertyService();
        $this->properties = $service->index(paginate: false);
        $this->properties->loadMissing(['area', 'image']);
    }
};
?>

@placeholder
    <section class="py-5">
    </section>
@endplaceholder

<section class="py-5">
    <div class="container-md py-5">
        <div class="d-grid gap-4">
            <div>
                <p class="lead mb-0">Over <b>50</b> homes in Canggu, Bali</p>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach ($properties as $property)
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
                            {{ $property->area->name }}
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
                            <div>
                                {{ trans('property.monthly_from') }}
                                <b>{{ Str::idr(9000000) }}</b>
                            </div>
                            <div>
                                {{ trans('property.yearly_from') }}
                                <b>{{ Str::idr(9000000 * 12) }}</b>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
