<?php

use App\Livewire\Component;
use App\Services\StandardService;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public object $standards;

    public function mount(): void
    {
        $service = new StandardService();
        $this->standards = $service->all();
    }
};
?>

@placeholder
    <section class="py-5 bg-light">
        <div class="container-md">
            <div class="d-grid gap-4">
                <div class="row">
                    <div class="col-lg-9 col-xl-7">
                        <div class="placeholder-glow">
                            <h1 class="placeholder rounded col-7 col-sm-5"></h1>
                        </div>
                        <div class="placeholder-glow">
                            <h6 class="placeholder rounded col-12"></h6>
                        </div>
                        <div class="placeholder-glow">
                            <h6 class="placeholder rounded col-10"></h6>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="col" wire:key="standard-{{ $id }}">
                            <div class="border-top border-5 py-5">
                                <div class="placeholder-glow">
                                    <h7 class="placeholder rounded col-8"></h7>
                                    <span class="placeholder rounded col-12"></span>
                                    <span class="placeholder rounded col-10"></span>
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
            <div class="row">
                <div class="col-lg-9 col-xl-7">
                    <h1 class="display-6 fw-medium">{{ trans('service.our_standard.title') }}</h1>
                    <p class="text-muted lead">{{ trans('service.our_standard.description') }}</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                @foreach ($standards as $standard)
                    <div class="col" wire:key="standard-{{ $standard['id'] }}">
                        <div class="border-top border-5 py-5">
                            <h6>{{ $standard['name'] }}</h6>
                            <p class="small text-muted mt-4">{{ $standard['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
