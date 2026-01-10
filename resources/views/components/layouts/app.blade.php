<!DOCTYPE html PUBLIC "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="{{ app()->getLocale() }}" itemscope itemtype="http://schema.org/WebPage" xmlns="http://www.w3.org/1999/xhtml"
    xml:lang="{{ app()->getLocale() }}" data-bs-theme="auto">

<head>
    <x-layouts.meta />

    <title>
        @if (!Route::is('home'))
            @yield('title') |
        @endif
        {{ config('app.name') }}
    </title>

    <x-layouts.vendors />

    @stack('css')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        @if (View::getSection('code') != 503)
            @can('cms')
                @livewire('layouts.header')
            @endcan
        @endif

        <main class="flex-grow-1 @can('cms') pt-5 my-4 @endcan">
            @if (View::hasSection('code'))
                @livewire('layouts.error')
            @else
                @if (Route::is('cms.*') && !Route::is('cms.home'))
                    {{ Breadcrumbs::render() }}
                @endif

                {{ $slot }}
            @endif
        </main>

        @if (View::getSection('code') != 503)
            @livewire('layouts.footer')
        @endif
    </div>

    @if (Route::is('cms.*'))
        @livewire('modal.modal-logs')

        @livewire('modal.modal-language')

        @livewire('modal.modal-theme')

        @livewire('modal.modal-account')
    @endif

    <script src="{{ asset('js/color-modes.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('script')
</body>

</html>
