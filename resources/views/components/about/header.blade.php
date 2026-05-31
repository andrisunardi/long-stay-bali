<section class="py-5">
    <div class="container-md py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-9 col-xl-7">
                <h1>{{ trans('about.header.title') }}</h1>
                <p>{{ trans('about.header.description') }}</p>
            </div>
        </div>

        <img draggable="false" loading="lazy" decoding="async" class="img-fluid w-100 h-100 rounded user-select-none pe-none"
            src="{{ asset('images/banner/about.png') }}"
            alt="{{ trans('index.banner') }} - {{ trans('page.about') }} - {{ config('constants.meta.title') }}">
    </div>
</section>
