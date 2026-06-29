<?php

use App\Livewire\Component;

new class extends Component {};
?>

<div class="row">
    <div class="col my-auto">
        <h5 class="fw-bold">Connection Status</h5>
        If the status is offline, switch to another Wi-Fi connection or use mobile data with hotspot /
        tethering, then re-open {{ config('app.name') }}.
    </div>

    <div class="col-auto my-auto">
        <button class="btn" wire:offline.class="d-none">
            <span class="fas fa-wifi fa-fw text-success"></span>
            <span class="text-success">Online</span>
        </button>

        <button class="btn d-none" wire:offline.class.remove="d-none">
            <span class="fas fa-wifi fa-fw text-danger"></span>
            <span class="text-danger">Offline</span>
        </button>
    </div>
</div>
