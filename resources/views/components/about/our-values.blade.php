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
        <div class="container-fluid">
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

                <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-3 justify-content-end g-4">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="col" wire:key="value-{{ $i }}">
                            <div class="card card-body h-100">
                                <div class="mb-4">
                                    <div class="placeholder-glow">
                                        <span class="placeholder rounded-circle ratio ratio-1x1 w-25"></span>
                                    </div>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-8"></span>
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
    <div class="container-fluid">
        <div class="d-grid gap-4">
            <div class="text-center">
                <p class="lead mb-0">{{ trans('home.our_values.sub_title') }}</p>
                <h2 class="display-6 fw-medium">{{ trans('home.our_values.title') }}</h2>
                <p class="small px-sm-5">{{ trans('home.our_values.description') }}</p>
            </div>

            <div class="row row-cols-1 row-cols-xl-3 justify-content-end g-4">
                @foreach ($values as $value)
                    <div class="col" wire:key="value-{{ $value->id }}">
                        <div class="card card-body border-0 h-100 p-0">
                            <div class="row align-items-center">
                                <div class="col-sm-8 col-lg-9 col-xl-6">
                                    <div class="row align-items-center g-3">
                                        <div class="col-auto col-xl-12">
                                            <div
                                                class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center p-3">
                                                <img draggable="false" loading="lazy" decoding="async"
                                                    class="user-select-none pe-none img-fluid" width="50"
                                                    height="50"
                                                    src="{{ asset('images/value/icon/' . Str::slug($value->title) . '.png') }}"
                                                    alt="{{ trans('index.value') }} - {{ $value->translate_title }} - {{ config('constants.meta.title') }}">
                                            </div>
                                        </div>
                                        <div class="col col-xl-12">
                                            <h5 class="card-title">{{ $value->translate_title }}</h5>
                                            <hr class="w-25" />
                                            <p class="card-text small">{{ $value->translate_description }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-lg-3 col-xl-6">
                                    <div class="ratio ratio-4x3">
                                        <img draggable="false" loading="lazy" decoding="async"
                                            class="user-select-none pe-none w-100 h-100 object-fit-cover rounded"
                                            src="{{ asset('images/value/' . Str::slug($value->title) . '.png') }}"
                                            alt="{{ trans('index.value') }} - {{ $value->translate_title }} - {{ config('constants.meta.title') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
