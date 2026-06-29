<?php

use App\Livewire\Component;

use App\Livewire\Forms\CMS\Profile\EditProfileForm;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new class extends Component {
    public EditProfileForm $form;

    public function mount(): void
    {
        $this->form->set(user: Auth::user());
    }

    public function resetForm(): void
    {
        $this->form->set(user: Auth::user());
    }

    public function submit(): void
    {
        $this->form->submit();
        $this->form->image = null;
        $this->resetValidation();

        Auth::user()->refresh();

        $this->alertSuccess(title: 'Edit Profile Success', body: 'Your profile has been successfully edited.');
    }
};
?>

<div class="card">
    <div class="card-header text-bg-success">
        <span class="fas fa-user-edit fa-fw"></span>
        Form Edit Profile
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-auto">
                <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.profile.index') }}" wire:navigate>
                    <span class="fas fa-arrow-left fa-fw"></span> Back
                </a>
            </div>
        </div>

        <hr />

        <form wire:submit.prevent="submit" role="form" autocomplete="off">
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="d-grid gap-3">
                        <div>
                            <label class="form-label" for="name">
                                Name <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-user fa-fw "></span>
                                </div>
                                <input type="text" class="form-control" id="name" name="name" minlength="1"
                                    maxlength="50" placeholder="Ex. John Doe" required wire:model="form.name"
                                    wire:offline.class="disabled" wire:offline.attr="disabled"
                                    wire:loading.class="disabled" wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                Required, Minlength : 1, Maxlength : 50, Unique
                            </div>
                            @error('form.name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="email">
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope fa-fw "></span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" minlength="1"
                                    maxlength="50" placeholder="Ex. johndoe@gmail.com" required wire:model="form.email"
                                    wire:offline.class="disabled" wire:offline.attr="disabled"
                                    wire:loading.class="disabled" wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                Required, Minlength : 1, Maxlength : 50, Unique
                            </div>
                            @error('form.email')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="phone">
                                Phone <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-phone fa-fw "></span>
                                </div>
                                <input type="tel" class="form-control" id="phone" name="phone" minlength="1"
                                    maxlength="20" placeholder="Ex. 6281234567890" required wire:model="form.phone"
                                    wire:offline.class="disabled" wire:offline.attr="disabled"
                                    wire:loading.class="disabled" wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                Required, Minlength : 1, Maxlength : 20, Unique
                            </div>
                            @error('form.phone')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="username">
                                Username <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-id-badge fa-fw "></span>
                                </div>
                                <input type="text" class="form-control" id="username" name="username" minlength="1"
                                    maxlength="50" placeholder="Ex. 012345" required wire:model="form.username"
                                    wire:offline.class="disabled" wire:offline.attr="disabled"
                                    wire:loading.class="disabled" wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                Required, Minlength : 1, Maxlength : 50, Unique
                            </div>
                            @error('form.username')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="d-grid gap-3">
                        <div>
                            <label class="form-label" for="image">
                                Image
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-image fa-fw "></span>
                                </div>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*,capture=camera,image/jpg,image/jpeg,image/png,image/gif,image/webp"
                                    wire:model="form.image" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                Format : .jpg .jpeg .png .gif .webp | Size : 12 MB
                            </div>
                            @error('form.image')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($form->image)
                            <div>
                                <div class="alert alert-info w-100" role="alert" wire:loading
                                    wire:target="form.image">
                                    Please wait until the uploading finished.
                                </div>

                                <div>
                                    <img draggable="false" loading="lazy" decoding="async"
                                        class="img-fluid w-100 rounded" width="100"
                                        src="{{ $form->image->temporaryUrl() }}" alt="Image Temporary"
                                        onerror="asset('images/image-not-available.png')" />
                                </div>
                            </div>
                        @elseif (Auth::user()->image_url)
                            <div>
                                <a draggable="false" href="{{ Auth::user()->image_url }}" target="_blank">
                                    <img draggable="false" loading="lazy" decoding="async"
                                        class="img-fluid w-100 rounded" width="100"
                                        src="{{ Auth::user()->image_url }}" alt="User - {{ Auth::user()->id }}"
                                        onerror="asset('images/image-not-available.png')" />
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col-6 col-sm-auto">
                    <button type="submit" class="btn btn-success w-100" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submit">
                            <span class="fas fa-save fa-fw"></span> Save
                        </span>
                        <span wire:loading wire:target="submit" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span> Save
                        </span>
                    </button>
                </div>
                <div class="col-6 col-sm-auto">
                    <button type="button" class="btn btn-warning w-100" wire:click="resetForm"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="resetForm">
                            <span class="fas fa-eraser fa-fw"></span> Reset
                        </span>
                        <span wire:loading wire:target="resetForm" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span> Reset
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
