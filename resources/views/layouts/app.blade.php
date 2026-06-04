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

    <x-third-party />

    @livewireStyles
</head>

<body class="d-flex flex-column min-vh-100 bg-body">
    @if (!View::hasSection('code'))
        @if (Route::is('cms.*'))
            @auth
                <x-cms.layout.header />
            @endauth
        @else
            <x-layout.header />
        @endif
    @endif

    <main class="flex-grow-1 @if (!Route::is(['home', 'cms.login', 'cms.forgot-password'])) pt-5 mt-4 @endif">
        @if (View::hasSection('code'))
            @if (!Route::is('cms.*'))
                <x-cms.layout.error />
            @else
                <x-layout.error />
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
                <x-cms.layout.footer />
            @endauth
        @else
            <x-layout.footer />
        @endif
    @endif

    {{-- <x-section.whatsapp /> --}}

    @if (Route::is('cms.*'))
        <livewire:modal.search-menu />

        <script src="{{ asset('js/color-modes.js') }}"></script>
    @endif

    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://link.msgsndr.com/js/external-tracking.js" data-tracking-id="tk_84ae764411934cd285ecfc500c5b1762">
    </script>

    <script src="https://beta.leadconnectorhq.com/loader.js"
        data-resources-url="https://beta.leadconnectorhq.com/chat-widget/loader.js"
        data-widget-id="6a21e1b58cf84918be07acb8"></script>

    @stack('script')

    @livewireScripts
</body>

</html>
