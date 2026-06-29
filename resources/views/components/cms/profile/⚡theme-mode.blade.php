<?php

use App\Livewire\Component;

new class extends Component {};
?>

<div class="row">
    <div class="col my-auto">
        <h5 class="fw-bold">Theme Mode</h5>
        Switch view appearance preferences text and background with dark mode or light mode.
    </div>

    <div class="col-auto my-auto">
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <span class="fas fa-repeat fa-fw"></span> Choose
            </button>
            <ul class="dropdown-menu">
                <li>
                    <button type="button" class="dropdown-item" data-bs-theme-value="light">
                        <span class="fas fa-sun fa-fw"></span> Light
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item" data-bs-theme-value="dark">
                        <span class="fas fa-moon fa-fw"></span> Dark
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item" data-bs-theme-value="auto">
                        <span class="fas fa-circle-half-stroke fa-fw"></span> Auto
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
