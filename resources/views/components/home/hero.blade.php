@props([
    'title' => null,
    'description' => null,
    'image' => null,
])

<div class="position-relative">
    <img draggable="false" loading="lazy" decoding="async"
        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover user-select-none pe-none"
        src="{{ $image }}"
        alt="{{ trans('index.banner') }} - {{ trans('page.home') }} - {{ config('constants.name') }}">

    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

    <div class="position-relative">
        <div class="container-md pt-5">
            <div class="row align-items-center min-vh-100 g-4 py-5">
                <div class="col-lg-6 text-white">
                    <div class="lead mb-3">
                        {{ $title }}
                    </div>
                    <div class="display-5 fw-bold">
                        {!! $description !!}
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5 offset-xl-1">
                    <livewire:home.search />
                </div>
            </div>
        </div>
    </div>
</div>
