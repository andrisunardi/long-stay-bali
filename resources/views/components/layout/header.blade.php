<header id="header" class="fixed-top py-3" data-use-banner="{{ Route::is('home') ? '1' : '0' }}">
    <div class="container-md">
        <div class="row justify-content-between align-items-center">
            <div class="col col-xl-3">
                <div class="d-flex align-items-center gap-3">
                    <a draggable="false" href="{{ route('home') }}" wire:navigate>
                        <img draggable="false" loading="lazy" decoding="async" class="logo user-select-none pe-none"
                            height="40" src="{{ asset('images/logo.png') }}"
                            alt="{{ trans('index.logo') }} - {{ config('app.name') }}" />
                    </a>

                    <livewire:layout.search />
                </div>
            </div>

            <div class="col-auto col-xl-5">
                <div class="d-none d-lg-flex justify-content-end align-items-center gap-lg-3 gap-xl-4">
                    @foreach (config('navigations') as $navigation)
                        <a draggable="false" href="{{ route($navigation['route']) }}"
                            class="header-color {{ Route::is($navigation['route']) ? 'fw-bold' : '' }}" wire:navigate
                            wire:key="navigation-{{ $navigation['id'] }}" wire:navigate>
                            {{ trans($navigation['name']) }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col col-xl-4 d-none d-lg-block">
                <div class="row justify-content-end align-items-center">
                    <div class="col-auto">
                        <div>
                            <div class="dropdown">
                                <a draggable="false" role="button" class="header-color dropdown-toggle icon-link"
                                    data-bs-toggle="dropdown">
                                    <span class="{{ Language::from(app()->getLocale())->flag() }}"></span>
                                    <span class="d-lg-none d-xl-block text-uppercase">
                                        {{ app()->getLocale() }}
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mt-3">
                                    @foreach (Language::cases() as $language)
                                        <li wire:key="language-{{ $language->value }}">
                                            <a draggable="false" class="dropdown-item icon-link"
                                                href="{{ route('locale', ['locale' => $language->value]) }}">
                                                <span class="{{ $language->flag() }}"></span>
                                                <span>{{ $language->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="dropdown">
                            <a draggable="false" role="button" class="header-color dropdown-toggle icon-link"
                                data-bs-toggle="dropdown">
                                {{-- <span
                                    class="{{ Currency::from(Session::get('currency') ?? Currency::IDR->value)->icon() }} fa-fw">
                                </span> --}}
                                <span class="d-lg-none d-xl-block text-uppercase">
                                    {{ Session::get('currency') ?? Currency::IDR->value }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-3">
                                @foreach (Currency::cases() as $currency)
                                    <li wire:key="currency-{{ $currency->value }}">
                                        <a draggable="false" class="dropdown-item icon-link"
                                            href="{{ route('currency', ['currency' => $currency->value]) }}">
                                            {{-- <span class="{{ $currency->icon() }} fa-fw"></span> --}}
                                            <span class="text-uppercase">{{ $currency->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-auto">
                        <livewire:modal.list-your-property />
                    </div>
                </div>
            </div>

            <div class="col-auto text-end d-lg-none">
                <a draggable="false" href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#navigation">
                    <span class="fas fa-bars header-color text-black"></span>
                </a>
            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="navigation">
                <div class="offcanvas-header">
                    <div class="offcanvas-title">
                        <a draggable="false" href="{{ route('home') }}" wire:navigate>
                            <img draggable="false" loading="lazy" decoding="async" class="user-select-none pe-none"
                                height="100" src="{{ asset('images/logo/black.png') }}"
                                alt="{{ trans('index.logo') }} - {{ config('app.name') }}" />
                        </a>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body">
                    <div class="d-grid gap-5 mt-4">
                        <ul class="list-unstyled d-grid gap-4 mb-0">
                            @foreach (config('navigations') as $navigation)
                                <li wire:key="navigation-{{ $navigation['id'] }}">
                                    <a draggable="false"
                                        class="d-flex justify-content-between align-items-center text-body {{ Route::is($navigation['route']) ? 'fw-bold' : '' }}"
                                        href="{{ route($navigation['route']) }}" wire:navigate>
                                        <span>{{ trans($navigation['name']) }}</span>
                                        <span class="fas fa-angle-right fa-fw"></span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-secondary small">{{ trans('index.language') }}</div>
                                <div class="dropdown">
                                    <a draggable="false" role="button" class="text-body dropdown-toggle icon-link"
                                        data-bs-toggle="dropdown">
                                        <span class="{{ Language::from(app()->getLocale())->flag() }}"></span>
                                        <span class="fw-bold text-uppercase">{{ app()->getLocale() }}</span>
                                    </a>
                                    <ul class="dropdown-menu mt-2">
                                        @foreach (Language::cases() as $language)
                                            <li wire:key="language-{{ $language->value }}">
                                                <a draggable="false" class="dropdown-item icon-link"
                                                    href="{{ route('locale', ['locale' => $language->value]) }}">
                                                    <span class="{{ $language->flag() }}"></span>
                                                    <span>{{ $language->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <div class="text-secondary small">{{ trans('index.currency') }}</div>
                                <div class="dropdown">
                                    <a draggable="false" role="button" class="text-body dropdown-toggle icon-link"
                                        data-bs-toggle="dropdown">
                                        {{-- <span
                                            class="{{ Currency::from(Session::get('currency') ?? Currency::IDR->value)->icon() }} fa-fw">
                                        </span> --}}
                                        <span class="fw-bold text-uppercase">
                                            {{ Session::get('currency') ?? Currency::IDR->value }}
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu mt-2">
                                        @foreach (Currency::cases() as $currency)
                                            <li wire:key="currency-{{ $currency->value }}">
                                                <a draggable="false" class="dropdown-item icon-link"
                                                    href="{{ route('currency', ['currency' => $currency->value]) }}">
                                                    {{-- <span class="{{ $currency->icon() }} fa-fw"></span> --}}
                                                    <span class="text-uppercase">{{ $currency->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <livewire:modal.list-your-property :sidebar="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@push('script')
    <script>
        function initHeader() {
            const $header = $("#header");
            const $logo = $(".logo");

            if (!$header.length) return;

            const useBanner = $header.data("use-banner") == 1;

            function handleScroll() {
                if ($(window).scrollTop() > 50) {
                    $header.addClass("bg-white text-black");
                    $header.find(".header-color")
                        .removeClass("text-white")
                        .addClass("text-black");

                    $logo.attr("src", "{{ asset('images/logo/black.png') }}");
                } else {
                    $header.removeClass("bg-white");

                    $header.find(".header-color")
                        .removeClass(useBanner ? "text-black" : "text-white")
                        .addClass(useBanner ? "text-white" : "text-black");

                    $logo.attr("src",
                        useBanner ?
                        "{{ asset('images/logo/white.png') }}" :
                        "{{ asset('images/logo/black.png') }}"
                    );
                }
            }

            handleScroll();
            $(window).off("scroll", handleScroll).on("scroll", handleScroll);
        }

        document.addEventListener("DOMContentLoaded", initHeader);
        document.addEventListener("livewire:navigated", initHeader);
    </script>
@endpush
