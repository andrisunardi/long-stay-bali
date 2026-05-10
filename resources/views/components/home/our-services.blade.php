<?php

use App\Livewire\Component;
use App\Services\ServiceService;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public object $services;

    public function mount(): void
    {
        $service = new ServiceService();
        $this->services = $service->all();
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
                        <h1 class="display-6 placeholder rounded col-10 col-lg-9 col-xl-7"></h1>
                    </div>
                    <div class="placeholder-glow">
                        <p class="small placeholder rounded col-12 col-sm-11 col-lg-8 col-xl-6"></p>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-3 justify-content-end g-4">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="col" wire:key="service-{{ $i }}">
                            <div class="card h-100 placeholder-glow">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="placeholder rounded-circle ratio ratio-1x1 w-25"></span>
                                    </div>
                                    <h5 class="card-title placeholder rounded col-8"></h5>
                                    <p class="card-text placeholder rounded col-12"></p>
                                    <ul>
                                        @for ($j = 0; $j < 3; $j++)
                                            <li wire:key="inclusion-{{ $j }}">
                                                <span class="placeholder rounded col-12 col-xl-10"></span>
                                            </li>
                                        @endfor
                                    </ul>
                                </div>
                                <div class="card-footer bg-white border-0 py-3">
                                    <div class="placeholder-glow">
                                        <span class="btn rounded-pill placeholder col-12"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="text-center mt-4">
                    <div class="placeholder-glow">
                        <span class="btn placeholder col-3 col-sm-2 col-xl-1"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endplaceholder

<section class="py-5">
    <div class="container-md">
        <div class="d-grid gap-4">
            <div class="text-center">
                <p class="lead mb-0">{{ trans('home.our_services.sub_title') }}</p>
                <h1 class="display-6 fw-medium">{{ trans('home.our_services.title') }}</h1>
                <p class="small text-muted">{{ trans('home.our_services.description') }}</p>
            </div>

            <div class="row row-cols-1 row-cols-sm-3 justify-content-end g-4">
                @foreach ($services as $service)
                    <div class="col" wire:key="service-{{ $service['id'] }}">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="mb-4">
                                    <img draggable="false" loading="lazy" decoding="async"
                                        class="user-select-none pe-none" height="100"
                                        src="{{ asset('images/service/' . Str::slug($service['name']) . '.png') }}"
                                        alt="{{ trans('index.service') }} - {{ $service['name'] }} - {{ config('constants.meta.title') }}">
                                    {{-- <span class="fa-stack fa-xl">
                                        <i class="fas fa-circle fa-stack-2x fa-inverse text-light"></i>
                                        <i class="{{ $service['icon'] }} fa-stack-1x text-success"></i>
                                    </span> --}}
                                </div>
                                <h5 class="card-title">{{ $service['name'] }}</h5>
                                <p class="card-text">{{ $service['description'] }}</p>
                                <ul>
                                    @foreach ($service['inclusions'] as $key => $inclusion)
                                        <li wire:key="inclusion-{{ $key }}">
                                            {{ $inclusion }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-footer bg-white border-0 py-3">
                                <a draggable="false" class="btn btn-outline-success rounded-pill w-100"
                                    href="https://api.whatsapp.com/send/?phone={{ config('constants.contact.whatsapp') }}&text=Hello, i know from your website solivingbali.com from our services on {{ $service['name'] }}"
                                    target="_blank">
                                    <span class="fab fa-whatsapp fa-fw"></span>
                                    {{ trans('home.our_services.request_a_service') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a draggable="false" class="btn btn-success" href="{{ route('service') }}" wire:navigate>
                    {{ trans('home.our_services.view_more') }}
                    <span class="fas fa-chevron-right fa-fw"></span>
                </a>
            </div>
        </div>
    </div>
</section>
