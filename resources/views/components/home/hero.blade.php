@props([
    'title' => null,
    'description' => null,
    'image' => null,
])

<div class="vh-100 position-relative">
    <div class="d-none d-sm-inline d-md-none d-lg-inline">
        <img draggable="false" loading="lazy" decoding="async" class="w-100 h-100 object-fit-cover user-select-none pe-none"
            src="{{ $image }}"
            alt="{{ trans('index.banner') }} - {{ trans('page.home') }} - {{ config('constants.name') }}">
    </div>

    <div class="d-inline d-sm-none d-md-inline d-lg-none">
        <img draggable="false" loading="lazy" decoding="async"
            class="w-100 h-100 object-fit-cover user-select-none pe-none" src="{{ $image }}"
            alt="{{ trans('index.banner') }} - {{ trans('page.home') }} - {{ config('constants.name') }}">
    </div>

    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
        <div class="container-md mt-5 pt-5 pt-md-0">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="lead text-white">{{ $title }}</div>
                    <div class="display-6 fw-bold text-white">{!! $description !!}</div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <livewire:home.search />
                </div>
            </div>
        </div>
    </div>
</div>
