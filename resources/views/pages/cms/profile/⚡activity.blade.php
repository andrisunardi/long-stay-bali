<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Activity | Profile')] class extends Component {};
?>

<div class="container-fluid">
    <livewire:cms.profile.menu />

    <livewire:cms.profile.activity-log />
</div>
