<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Setting | Profile')] class extends Component {};
?>

<div class="container-fluid">
    <livewire:cms.profile.menu />

    <div class="card">
        <div class="card-body">
            <livewire:cms.profile.connection-status />

            <hr />

            <livewire:cms.profile.theme-mode />
        </div>
    </div>
</div>
