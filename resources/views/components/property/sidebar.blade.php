

<div class="sticky-top" style="top: 5rem">
    <div class="card card-body">
        <div class="d-grid gap-2">
            <div class="d-flex justify-content-between">
                <span class="fw-medium">{{ Str::idr($property->monthly_price) }}</span>
                <span class="text-secondary">{{ trans('property.per_month') }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="fw-medium">{{ Str::idr($property->yearly_price) }}</span>
                <span class="text-secondary">{{ trans('property.per_year') }}</span>
            </div>
        </div>

        <hr />

        <a draggable="false" class="btn btn-success w-100 rounded-pill"
            href="https://api.whatsapp.com/send/?phone={{ config('constants.contact.whatsapp') }}&text=Hello, i know from your website solivingbali.com from property page"
            target="_blank">
            <i class="fab fa-whatsapp me-2"></i>
            {{ trans('about.cta.button_name') }}
        </a>
    </div>
</div>
