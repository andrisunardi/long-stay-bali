<section class="position-relative">
    <img draggable="false" class="w-100 object-fit-cover user-select-none pe-none" style="height: 20rem"
        src="{{ asset('images/banner/about.png') }}" alt="{{ trans('index.banner') }} - {{ config('constants.title') }}">

    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
        <div class="container-md">
            <div class="row justify-content-end">
                <div class="col-sm-8 col-md-7 col-lg-5 col-xl-4">
                    <div class="card border-0 shadow rounded-5">
                        <div class="card-body p-4 d-grid gap-4">
                            <h5 class="fw-bold">
                                {{ trans('about.cta.title') }}
                            </h5>
                            <p class="text-muted small">
                                {{ trans('about.cta.description') }}
                            </p>
                            <a draggable="false" class="btn btn-success w-100 rounded-pill"
                                href="https://api.whatsapp.com/send/?phone={{ config('constants.contact.whatsapp') }}&text=Hello, i know from your website solivingbali.com from about page"
                                target="_blank">
                                <i class="fab fa-whatsapp me-2"></i>
                                {{ trans('about.cta.button_name') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
