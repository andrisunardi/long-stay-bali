<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('About')] class extends Component {};
?>

@section('title', trans('page.about'))

<div>
    <x-about.header />

    <x-about.our-story />

    <livewire:about.our-values lazy />

    {{-- prettier-ignore --}}
    <x-section.cta
    :image-url="asset('images/banner/about.png')"
    :button-name="trans('about.cta.button_name')"
    :button-link="'https://api.whatsapp.com/send/?phone=' .
        Str::slug(config('constants.contact.whatsapp'), '') .
        '&text=Hello, i know from your website solivingbali.com from about page'"
    />
</div>
