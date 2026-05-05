@props([
    'whatsapp' => null,
    'email' => null,
])

<div class="d-flex flex-column gap-4">
    <div>
        <h2 class="display-6 fw-bold">{{ trans('contact.info.title') }}</h2>
        <p class="mt-3">{{ trans('contact.info.description') }}</p>
    </div>

    <div class="d-flex flex-column gap-3">
        <h4 class="lead fw-medium">{{ trans('contact.info.contact') }}</h4>
        <a draggable="false" class="text-body"
            href="https://api.whatsapp.com/send/?phone={{ $whatsapp }}&text=Hello, i know from your website solivingbali.com"
            target="_blank">
            <span class="fab fa-whatsapp fa-fw text-success"></span>
            {{ $whatsapp }}
        </a>

        <a draggable="false" class="text-body" href="mailto:{{ $email }}">
            <span class="fas fa-envelope fa-fw text-success"></span>
            {{ $email }}
        </a>

        @foreach (config('social-medias') as $socialMedia)
            <a draggable="false" class="text-body" href="{{ $socialMedia['link'] }}" target="_blank"
                wire:key="social-media-{{ $socialMedia['id'] }}">
                <span class="{{ $socialMedia['icon'] }} fa-fw text-success"></span>
                {{ $socialMedia['username'] }}
            </a>
        @endforeach
    </div>
</div>
