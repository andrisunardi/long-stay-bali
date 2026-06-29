<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Change Password | Profile')] class extends Component {};
?>

<div class="container-fluid">
    <livewire:cms.profile.menu />

    <livewire:cms.profile.form.change-password />
</div>
