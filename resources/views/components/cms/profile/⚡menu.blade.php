<?php

use App\Livewire\Component;

new class extends Component {};
?>

<div class="d-flex overflow-auto flex-nowrap gap-3 mb-3 pb-3">
    <a draggable="false"
        class="btn btn-outline-primary text-nowrap icon-link {{ Route::is('cms.profile.index') ? 'active' : '' }}"
        href="{{ route('cms.profile.index') }}">
        <span class="fas fa-user fa-fw"></span> Profile
    </a>

    <a draggable="false"
        class="btn btn-outline-primary text-nowrap icon-link {{ Route::is('cms.profile.edit-profile') ? 'active' : '' }}"
        href="{{ route('cms.profile.edit-profile') }}">
        <span class="fas fa-user-edit fa-fw"></span> Edit Profile
    </a>

    <a draggable="false"
        class="btn btn-outline-primary text-nowrap icon-link {{ Route::is('cms.profile.change-password') ? 'active' : '' }}"
        href="{{ route('cms.profile.change-password') }}">
        <span class="fas fa-user-lock fa-fw"></span> Change Password
    </a>

    <a draggable="false"
        class="btn btn-outline-primary text-nowrap icon-link {{ Route::is('cms.profile.setting') ? 'active' : '' }}"
        href="{{ route('cms.profile.setting') }}">
        <span class="fas fa-user-gear fa-fw"></span> Setting
    </a>

    <a draggable="false"
        class="btn btn-outline-primary text-nowrap icon-link {{ Route::is('cms.profile.activity') ? 'active' : '' }}"
        href="{{ route('cms.profile.activity') }}">
        <span class="fas fa-user-clock fa-fw"></span> Activity
    </a>

    <a draggable="false" class="btn btn-outline-primary text-nowrap icon-link" href="{{ route('cms.logout') }}">
        <span class="fas fa-sign-out-alt fa-fw"></span> Logout
    </a>
</div>
