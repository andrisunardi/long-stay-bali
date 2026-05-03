<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Contact')] class extends Component {};
?>

@section('title', trans('page.contact'))

<section class="py-5">
    <x-contact.header />

    {{-- prettier-ignore --}}
    <x-contact.maps
    :address="config('constants.contact.address')"
    :google-maps="config('constants.contact.google_maps')"
    :google-maps-iframe="config('constants.contact.google_maps_iframe')"
    />
</section>
