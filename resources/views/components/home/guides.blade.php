<?php

use App\Livewire\Component;
use App\Services\GuideService;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public object $guides;

    public function mount(): void
    {
        $service = new GuideService();
        $this->guides = $service->index(isShow: [true], isActive: [true], limit: 4, paginate: false);
        $this->guides->loadMissing(['category']);
    }
};
?>

@placeholder
    <section class="py-5 bg-light">
        <div class="container-md py-5">
            <div class="d-flex flex-column gap-4">
                <div class="text-start">
                    <div class="placeholder-glow">
                        <span class="placeholder col-3 mb-2"></span>
                        <span class="placeholder col-6 placeholder-lg mb-2"></span>
                        <span class="placeholder col-4"></span>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="col">
                            <div class="ratio ratio-21x9 overflow-hidden">
                                <div class="placeholder-glow w-100 h-100">
                                    <span class="placeholder w-100 h-100 rounded"></span>
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

                            <div class="mt-2">
                                <div class="placeholder-glow">
                                    <span class="placeholder col-12 mb-1"></span>
                                    <span class="placeholder col-10 mb-1"></span>
                                    <span class="placeholder col-6"></span>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div class="placeholder-glow">
                                    <span class="placeholder col-3"></span>
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
    <div class="container-md py-5">
        <div class="d-flex flex-column gap-4">
            <div class="text-start">
                <p class="lead mb-0">{{ trans('home.guides.sub_title') }}</p>
                <h1 class="display-6 fw-medium">{{ trans('home.guides.title') }}</h1>
                <p class="small text-muted">{{ trans('home.guides.description') }}</p>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                @foreach ($guides as $guide)
                    <div class="col" wire:key="guide-{{ $guide['id'] }}">
                        <div class="ratio ratio-21x9 overflow-hidden">
                            <a draggable="false" href="{{ route('guide.detail', ['slug' => $guide['slug']]) }}"
                                wire:navigate>
                                <img draggable="false" loading="lazy" decoding="async"
                                    class="img-fluid w-100 h-100 object-fit-cover rounded user-select-none pe-none"
                                    src="{{ $guide->image_url ?? asset('images/placeholder.png') }}"
                                    alt="{{ trans('home.guides.guide') }} - {{ $guide->translate_title }} - {{ config('constants.meta.title') }}"
                                    onerror="this.onerror=null; this.src='/images/placeholder.png';" />
                            </a>
                        </div>

                        <div class="mt-3">
                            {{ $guide->category->translate_name }}
                        </div>

                        <h1 class="h6 text-truncate mt-3">
                            <a draggable="false" class="text-body"
                                href="{{ route('guide.detail', ['slug' => $guide->slug]) }}" wire:navigate>
                                {{ $guide->translate_title }}
                            </a>
                        </h1>

                        <p class="small">
                            {{ Str::limit(strip_tags($guide->translate_body), 100) }}
                        </p>

                        <a draggable="false" href="{{ route('guide.detail', ['slug' => $guide->slug]) }}"
                            wire:navigate>
                            {{ trans('home.guides.read_more') }}
                            <span class="fas fa-chevron-right fa-fw fa-xs"></span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
