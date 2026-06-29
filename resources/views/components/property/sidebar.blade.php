@props([
    'property' => null,
])

<div class="card card-body">
    <div class="d-grid gap-2">
        @if ($property->rental_type == PropertyRentalType::Both || $property->rental_type == PropertyRentalType::Monthly)
            <div class="d-flex justify-content-between">
                <span class="fw-medium">{{ Str::currency($property->monthly_price) }}</span>
                <span class="text-secondary">{{ trans('property.per_month') }}</span>
            </div>
        @endif
        @if ($property->rental_type == PropertyRentalType::Both || $property->rental_type == PropertyRentalType::Yearly)
            <div class="d-flex justify-content-between">
                <span class="fw-medium">{{ Str::currency($property->yearly_price) }}</span>
                <span class="text-secondary">{{ trans('property.per_year') }}</span>
            </div>
        @endif
    </div>

    <hr />

    <div class="row">
        <div class="col-6">
            <a draggable="false" class="btn btn-sm btn-success w-100 rounded-pill"
                href="https://api.whatsapp.com/send/?phone={{ Str::slug(config('constants.contact.whatsapp'), '') }}&text=Hello, i know from your website solivingbali.com from property page"
                target="_blank">
                <i class="fab fa-whatsapp fa-fw"></i>
                {{ trans('property.whatsapp') }}
            </a>
        </div>
        <div class="col-6">
            <a draggable="false" class="btn btn-sm btn-primary w-100 rounded-pill"
                href="mailto:{{ config('constants.contact.email') }}">
                <i class="fas fa-envelope fa-fw"></i>
                {{ trans('property.email') }}
            </a>
        </div>
    </div>
</div>
