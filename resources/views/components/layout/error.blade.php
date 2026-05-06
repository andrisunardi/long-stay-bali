<main class="container d-flex justify-content-center align-items-center text-center vh-100 my-sm-5 my-md-auto">
    <div class="d-grid gap-4">
        <div class="d-flex justify-content-center">
            <img draggable="false" loading="lazy" decoding="async" width="100" src="{{ asset('images/logo.png') }}"
                alt="Logo - {{ config('app.name') }}">
        </div>

        <div>
            <h1>@yield('code')</h1>
            <h3>@yield('message')</h3>
            <p class="lead">@yield('description')</p>

            <a draggable="false" class="btn btn-primary rounded-pill"
                href="{{ url()->previous() == url()->current() ? route('home') : url()->previous() }}">
                <span class="fas fa-arrow-left fa-fw"></span>
                Back To Previous Page
            </a>
        </div>

        <div class="text-body-secondary text-center small">
            <div class="small">
                &copy; {{ trans('footer.copyright') }} {{ now()->year }} &reg;
                <strong>{{ config('app.name') }}</strong>&trade;
                {{ trans('footer.all_rights_reserved') }}.
            </div>
            <div class="small">
                {{ trans('footer.created_and_designed_by') }}
                <a draggable="false" href="https://www.diw.co.id" target="_blank">
                    <img draggable="false" loading="lazy" decoding="async"
                        src="{{ asset('images/icon-diw.co.id.png') }}" alt="Icon DIW.co.id"
                        title="{{ trans('footer.created_and_designed_by') }} DIW.co.id">
                </a>
            </div>
        </div>
    </div>
</main>
