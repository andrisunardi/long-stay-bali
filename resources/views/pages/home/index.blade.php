<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Home')] class extends Component {};
?>

@section('title', trans('page.home'))

<div>
    <x-home.hero :title="trans('home.hero.title')" :description="trans('home.hero.description')" :image="asset('images/hero/home.webp')" />

    <livewire:home.our-values lazy />

    <livewire:home.select-locations lazy />

    <livewire:home.our-services lazy />

    <livewire:home.guides lazy />

    {{-- prettier-ignore --}}
    <x-home.cta
    :image="asset('images/banner/home.png')"
    :button-name="trans('home.cta.button')"
    :button-link="route('contact')"
    />
</div>
