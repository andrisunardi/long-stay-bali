<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Edit Profile | Profile')] class extends Component {};
?>

<div class="container-fluid">
    <livewire:cms.profile.menu />

    <livewire:cms.profile.form.edit-profile />
</div>
