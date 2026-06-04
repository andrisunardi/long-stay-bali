<footer>
    <div class="text-bg-dark py-5">
        <div class="container-md">
            <div class="row g-4">
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <a draggable="false" href="{{ route('home') }}" wire:navigate>
                        <img draggable="false" loading="lazy" decoding="async" class="user-select-none pe-none"
                            height="100" src="{{ asset('images/logo/white-tagline.png') }}"
                            alt="{{ trans('index.logo') }} - {{ config('app.name') }}" />
                    </a>

                    <p class="text-light mt-4">{{ trans('footer.description') }}</p>
                </div>

                <div class="col-3 col-sm-6 col-lg-2 offset-xl-2">
                    <div class="d-grid gap-3">
                        @foreach (collect(config('navigations'))->reject(fn($item) => $item['route'] === 'contact')->values() as $navigation)
                            <div wire:key="navigation-{{ $navigation['id'] }}">
                                <a draggable="false" class="text-light" href="{{ route($navigation['route']) }}"
                                    wire:navigate>
                                    {{ trans($navigation['name']) }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-9 col-sm-6 col-lg-4 col-xl-3">
                    <div class="d-grid gap-3">
                        <h6>{{ trans('footer.contact_us') }}</h6>
                        <div>
                            <a draggable="false" class="text-light" href="{{ config('constants.contact.google_maps') }}"
                                target="_blank">
                                <span class="fas fa-map-marker-alt fa-fw"></span>
                                Bali, Indonesia
                            </a>
                        </div>
                        <div>
                            <a draggable="false" class="text-light"
                                href="mailto:{{ config('constants.contact.email') }}">
                                <span class="fas fa-envelope fa-fw"></span>
                                {{ config('constants.contact.email') }}
                            </a>
                        </div>
                        <div>
                            <a draggable="false" class="text-light"
                                href="https://api.whatsapp.com/send/?phone={{ Str::slug(config('constants.contact.whatsapp'), '') }}&text=Hello, i know from your website solivingbali.com"
                                target="_blank">
                                <span class="fab fa-whatsapp fa-fw"></span>
                                {{ config('constants.contact.whatsapp') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-2">
                    <div class="d-grid gap-3">
                        <h6>{{ trans('footer.our_social_media') }}</h6>
                        <div class="d-flex gap-3">
                            @foreach (config('social-medias') as $socialMedia)
                                <a draggable="false" class="text-light" href="{{ $socialMedia['link'] }}"
                                    target="_blank">
                                    <span class="{{ $socialMedia['icon'] }} fa-fw fa-xl"></span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-black text-white py-3">
        <div class="container-md">
            <div class="row justify-content-between align-items-center small">
                <div class="col-md text-center text-md-start">
                    &copy; {{ trans('footer.copyright') }} {{ now()->year }} &reg;
                    <strong>{{ config('app.name') }}</strong>&trade;
                    <br class="d-sm-none" />
                    {{ trans('footer.all_rights_reserved') }}.
                </div>
                <div class="col-md-auto text-center text-md-end">
                    <div class="d-flex justify-content-center gap-1">
                        {{ trans('footer.created_and_designed_by') }}
                        <a draggable="false" href="https://www.diw.co.id" target="_blank">
                            <img draggable="false" loading="lazy" decoding="async"
                                src="{{ asset('images/icon-diw.co.id.png') }}" alt="Icon DIW.co.id"
                                title="{{ trans('footer.created_and_designed_by') }} DIW.co.id">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
