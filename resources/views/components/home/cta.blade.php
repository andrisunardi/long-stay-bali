@props([
    'imageUrl' => null,
    'buttonName' => null,
    'buttonLink' => null,
])

<section>
    <div class="position-relative">
        <div class="bg-light py-5"></div>
        <div class="bg-dark py-5"></div>

        <div class="container-md position-absolute top-50 start-50 translate-middle w-100 px-3">
            <div class="bg-light rounded-4 shadow p-4 p-lg-5 position-relative overflow-hidden">
                <img draggable="false" loading="lazy" decoding="async"
                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover user-select-none pe-none"
                    src="{{ $imageUrl ?? asset('images/banner/home.png') }}"
                    alt="{{ trans('index.banner') }} - {{ config('constants.meta.title') }}">

                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

                <div class="row align-items-center position-relative g-4">
                    <div class="col-sm">
                        <h2 class="fw-bold mb-1 text-white">{{ trans('home.cta.title') }}</h2>
                        <p class="mb-0 text-white">
                            {{ trans('home.cta.description') }}
                        </p>
                    </div>
                    <div class="col-sm-auto">
                        <a draggable="false" class="btn btn-success rounded-pill px-4" href="{{ $buttonLink }}"
                            wire:navigate>
                            {{ $buttonName }}
                            <span class="fas fa-arrow-right fa-fw"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
