<section class="py-5">
    <div class="container-md">
        <div class="row align-items-center g-4">
            <div class="col-sm-6 col-lg-5">
                <h1>{{ trans('service.title') }}</h1>
                <p class="mt-4 mt-xl-5">{!! trans('service.description') !!}</p>
            </div>

            <div class="col-sm-6 col-xl-5 offset-lg-1 offset-xl-2">
                <img draggable="false" loading="lazy" decoding="async"
                    class="img-fluid w-100 h-100 rounded user-select-none pe-none"
                    src="{{ asset('images/service/overview.png') }}"
                    alt="{{ trans('index.banner') }} - {{ trans('page.overview') }} - {{ config('constants.meta.title') }}">
            </div>
        </div>
    </div>
</section>
