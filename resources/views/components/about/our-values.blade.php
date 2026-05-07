<?php

use App\Livewire\Component;
use App\Services\ValueService;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public object $values;

    public function mount(): void
    {
        $service = new ValueService();
        $this->values = $service->index(isActive: [true], orderBy: 'id', sortBy: 'asc', paginate: false);
    }
};
?>

@placeholder
    <section class="py-5">
        <div class="container-md">
            <div class="d-grid gap-4">
                <div class="text-center">
                    <div class="placeholder-glow">
                        <span class="placeholder col-4 col-sm-2 col-xl-1"></span>
                    </div>
                    <div class="placeholder-glow">
                        <span class="placeholder col-10 col-xl-9"></span>
                    </div>
                    <div class="placeholder-glow">
                        <span class="placeholder col-12 col-lg-8 col-xl-6"></span>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-3 justify-content-end g-3">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="col">
                            <div class="card card-body h-100">
                                <div class="mb-4">
                                    <div class="placeholder-glow">
                                        <span class="placeholder rounded-circle ratio ratio-1x1 w-25"></span>
                                    </div>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-8"></span>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                    <span class="placeholder col-10"></span>
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
        <div class="d-grid gap-4">
            <div class="text-center">
                <p class="lead mb-0">{{ trans('about.our_values.sub_title') }}</p>
                <h2 class="display-6 fw-medium">{{ trans('about.our_values.title') }}</h2>
            </div>

            <div class="row row-cols-1 row-cols-sm-3 justify-content-end g-3">
                @foreach ($values as $value)
                    <div class="col" wire:key="value-{{ $value->id }}">
                        <div class="card card-body h-100">
                            <div class="mb-4">
                                <span class="fa-stack fa-xl">
                                    <i class="fas fa-circle fa-stack-2x fa-inverse text-light"></i>
                                    <i class="{{ $value->icon }} fa-stack-1x text-success"></i>
                                </span>
                            </div>
                            <h5 class="card-title">{{ $value->translate_title }}</h5>
                            <p class="card-text">{{ $value->translate_description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
