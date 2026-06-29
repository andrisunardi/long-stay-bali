<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Service')] class extends Component {};
?>

@section('title', trans('page.service'))

<div>
    {{-- prettier-ignore --}}
    <x-service.overview
    :title="trans('service.title')"
    :description="trans('service.description')"
    :image-url="asset('images/service/overview.png')"
    />

    <livewire:service.our-services lazy />

    <livewire:service.our-standard lazy />

    {{-- prettier-ignore --}}
    <x-section.cta
    :image-url="asset('images/banner/service.png')"
    :button-name="trans('service.cta.button_name')"
    :button-link="'https://api.whatsapp.com/send/?phone=' .
        Str::slug(config('constants.contact.whatsapp'), '') .
        '&text=Hello, i know from your website solivingbali.com from service page'"
    />
</div>
