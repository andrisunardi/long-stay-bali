<!DOCTYPE html PUBLIC "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{{ app()->getLocale() }}" itemscope itemtype="http://schema.org/WebPage" xmlns="http://www.w3.org/1999/xhtml"
    xml:lang="{{ app()->getLocale() }}" data-bs-theme="auto">

<head>
    <x-meta />

    <title>
        @if (!Route::is('home'))
            {{ View::getSection('title') ?? $title }} |
        @endif
        {{ config('constants.meta.title') }}
    </title>

    <x-vendors />

    @stack('css')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    @livewireStyles
</head>

<body class="d-flex flex-column min-vh-100 bg-body">
    @if (!View::hasSection('code'))
        @if (Route::is('cms.*'))
            @auth
                <livewire:layouts::cms.header />
            @endauth
        @else
            @if (request()->getHost() != 'solivingbali.com')
                <x-layout.header />
            @endif
        @endif
    @endif

    <main class="flex-grow-1 @if (Route::is('cms.*') && !Route::is(['cms.login', 'cms.forgot-password'])) pt-5 my-4 @endif">
        @if (View::hasSection('code'))
            @if (!Route::is('cms.*'))
                <livewire:layouts::cms.error />
            @else
                <livewire:layouts::error />
            @endif
        @else
            @if (Route::is('cms.*'))
                @if (!Route::is(['cms.home', 'cms.login', 'cms.forgot-password']))
                    {{ Breadcrumbs::render() }}
                @endif
            @endif

            {{ $slot }}
        @endif
    </main>

    @if (!View::hasSection('code'))
        @if (Route::is('cms.*'))
            @auth
                <x-cms.footer />
            @endauth
        @else
            @if (request()->getHost() != 'solivingbali.com')
                <x-layout.footer />
            @endif
        @endif
    @endif

    @if (!Route::is('cms.*'))
        @if (request()->getHost() != 'solivingbali.com')
            <a draggable="false" href="https://wa.me/{{ config('constants.contact.whatsapp') }}" target="_blank"
                class="position-fixed bottom-0 end-0 m-3 d-flex align-items-center justify-content-center z-1">
                <span class="fa-stack fa-xl">
                    <i class="fas fa-circle fa-stack-2x text-success"></i>
                    <i class="fab fa-whatsapp fa-stack-1x fa-inverse"></i>
                </span>
            </a>
        @endif
    @endif


    @if (Route::is('cms.*'))
        <livewire:modal.search-menu />

        <script src="{{ asset('js/color-modes.js') }}"></script>
    @endif

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('script')

    @livewireScripts
</body>

</html>
