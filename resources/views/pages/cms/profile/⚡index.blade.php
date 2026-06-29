<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Profile')] class extends Component {};
?>

@section('title', trans('page.profile'))

<div class="container-fluid">
    <livewire:cms.profile.menu />

    <div class="row g-3">
        <div class="col-sm-7 col-xl-8">
            <livewire:cms.profile.user-information />
        </div>

        <div class="col-sm-5 col-xl-4">
            <livewire:cms.profile.roles-and-permissions />
        </div>
    </div>
</div>
