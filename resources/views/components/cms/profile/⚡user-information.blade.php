<?php

use App\Livewire\Component;

new class extends Component {};
?>

<div class="card">
    <div class="card-header text-bg-primary">
        <span class="fas fa-id-card fa-fw"></span>
        User Information
    </div>
    <div class="card-body">
        @auth
            <div class="row">
                <div class="col fw-bold">ID</div>
                <div class="col-auto">{{ Auth::user()->id }}</div>
            </div>

            <hr />

            <div class="row">
                <div class="col fw-bold">Name</div>
                <div class="col-auto">{{ Auth::user()->name }}</div>
            </div>

            <hr />

            <div class="row">
                <div class="col fw-bold">Email</div>
                <div class="col-auto">
                    <a draggable="false" href="mailto:{{ Auth::user()->email }}">
                        {{ Auth::user()->email }}
                    </a>
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col fw-bold">Phone</div>
                <div class="col-auto">
                    <a draggable="false" href="https://api.whatsapp.com/send?phone={{ Str::slug(Auth::user()->phone, '') }}"
                        target="_blank">
                        {{ Auth::user()->phone }}
                    </a>
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col fw-bold">Username</div>
                <div class="col-auto">{{ Auth::user()->username }}</div>
            </div>

            <hr />

            <div class="row">
                <div class="col fw-bold">Image</div>
                <div class="col-auto">
                    @if (Auth::user()->image_url)
                        <a draggable="false" href="{{ Auth::user()->image_url }}" target="_blank">
                            <img draggable="false" loading="lazy" decoding="async" class="rounded-circle" width="100"
                                src="{{ Auth::user()->image_url }}" alt="User - {{ Auth::user()->id }}"
                                onerror="asset('images/user.png')" />
                        </a>
                    @endif
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col fw-bold">Join Date</div>
                <div class="col-auto">{{ Auth::user()->created_at?->isoFormat('HH:mm - ddd, DD MMM YYYY') }}</div>
            </div>

            <hr />

            <div class="row g-3">
                <div class="col-md-auto">
                    <a draggable="false" class="btn btn-success w-100" href="{{ route('cms.profile.edit-profile') }}"
                        wire:navigate>
                        <span class="fas fa-user-edit fa-fw"></span> Edit Profile
                    </a>
                </div>

                <div class="col-md-auto">
                    <a draggable="false" class="btn btn-danger w-100" href="{{ route('cms.profile.change-password') }}"
                        wire:navigate>
                        <span class="fas fa-user-lock fa-fw"></span> Change Password
                    </a>
                </div>
            </div>
        @endauth
    </div>
</div>
