@if (!Route::is('cms.*'))
    <a draggable="false" href="https://wa.me/{{ Str::slug(config('constants.contact.whatsapp'), '') }}" target="_blank"
        class="position-fixed bottom-0 end-0 m-3 d-flex align-items-center justify-content-center z-1">
        <span class="fa-stack fa-xl">
            <i class="fas fa-circle fa-stack-2x text-success"></i>
            <i class="fab fa-whatsapp fa-stack-1x fa-inverse"></i>
        </span>
    </a>
@endif
