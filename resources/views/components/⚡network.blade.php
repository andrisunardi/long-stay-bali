<?php

use App\Livewire\Component;

new class extends Component {};
?>

<button class="btn d-sm-flex align-items-sm-center gap-sm-1">
    <span class="fas fa-wifi fa-fw text-success" wire:offline.class="text-danger"
        wire:offline.class.remove="text-success"></span>
    <span class="d-none d-sm-inline">Online</span>
</button>
