<footer class="text-bg-dark py-5">
    <div class="container-md">
        <div class="d-flex flex-column text-center justify-content-center gap-4">
            <div>
                <a draggable="false" href="{{ route('home') }}" wire:navigate>
                    <img draggable="false" loading="lazy" decoding="async" class="user-select-none pe-none" width="200"
                        src="{{ asset('images/logo/white-tagline.png') }}"
                        alt="{{ trans('index.logo') }} - {{ config('app.name') }}" />
                </a>
            </div>
            <div>
                <h1 class="lead text-light px-4 px-sm-0">{{ trans('footer.description') }}</h1>
            </div>
            <div>
                <div class="d-flex justify-content-center gap-4">
                    @foreach (config('social-medias') as $socialMedia)
                        <a draggable="false" class="text-light" href="{{ $socialMedia['link'] }}" target="_blank">
                            <span class="{{ $socialMedia['icon'] }} fa-fw fa-xl"></span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="d-grid d-sm-flex justify-content-sm-center gap-sm-4">
                    <a draggable="false" class="text-light" href="{{ config('constants.contact.google_maps') }}"
                        target="_blank">
                        <span class="fas fa-map-marker-alt fa-fw"></span>
                        Bali, Indonesia
                    </a>
                    <a draggable="false" class="text-light" href="mailto:{{ config('constants.contact.email') }}">
                        <span class="fas fa-envelope fa-fw"></span>
                        {{ config('constants.contact.email') }}
                    </a>
                    <a draggable="false" class="text-light"
                        href="https://api.whatsapp.com/send/?phone={{ config('constants.contact.whatsapp') }}&text=Hello, i know from your website solivingbali.com"
                        target="_blank">
                        <span class="fab fa-whatsapp fa-fw"></span>
                        {{ config('constants.contact.whatsapp') }}
                    </a>
                </div>
            </div>
            <div class="small text-white-50">
                &copy; {{ trans('footer.copyright') }} {{ now()->year }} &reg;
                <strong>{{ config('app.name') }}</strong>&trade;
                <br class="d-sm-none" />
                {{ trans('footer.all_rights_reserved') }}.
            </div>
        </div>
    </div>
</footer>
