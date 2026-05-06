<footer class="bg-body-tertiary small p-3">
    <div class="row justify-content-between align-items-center small">
        <div class="col-md text-center text-md-start">
            &copy; {{ trans('footer.copyright') }} 2025 - {{ now()->year }} &reg;
            <strong>{{ config('app.name') }}</strong>&trade;
            <br class="d-sm-none" />
            {{ trans('footer.all_rights_reserved') }}.
        </div>
        <div class="col-md-auto text-center text-md-end">
            <div class="d-flex justify-content-center gap-1">
                {{ trans('footer.created_and_designed_by') }}
                <a draggable="false" href="https://www.diw.co.id" target="_blank">
                    <img draggable="false" loading="lazy" decoding="async" src="{{ asset('images/icon-diw.co.id.png') }}"
                        alt="Icon DIW.co.id" title="{{ trans('footer.created_and_designed_by') }} DIW.co.id">
                </a>
            </div>
        </div>
    </div>
</footer>
