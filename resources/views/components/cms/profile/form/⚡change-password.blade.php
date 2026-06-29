<?php

use App\Livewire\Component;

use App\Livewire\Forms\CMS\Profile\ChangePasswordForm;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new class extends Component {
    public ChangePasswordForm $form;

    public bool $currentPasswordVisibility = false;

    public bool $newPasswordVisibility = false;

    public bool $confirmationPasswordVisibility = false;

    public function changeCurrentPasswordVisibility(): void
    {
        $this->currentPasswordVisibility = !$this->currentPasswordVisibility;
    }

    public function changeNewPasswordVisibility(): void
    {
        $this->newPasswordVisibility = !$this->newPasswordVisibility;
        $text = $this->newPasswordVisibility ? 'Activated' : 'Deactivated';
    }

    public function changeconfirmationPasswordVisibility(): void
    {
        $this->confirmationPasswordVisibility = !$this->confirmationPasswordVisibility;
        $text = $this->confirmationPasswordVisibility ? 'Activated' : 'Deactivated';
    }

    public function resetFields(): void
    {
        $this->form->reset();
    }

    public function submit(): void
    {
        $data = $this->form->validate();

        if (!Hash::check($data['current_password'], Auth::user()->password)) {
            $this->alertError(title: 'Change Password Failed', body: 'Current Password is invalid.');

            return;
        }

        if ($data['new_password'] != $data['confirmation_password']) {
            $this->alertError(title: 'Change Password Failed', body: 'New Password and Confirmation Password not match.');

            return;
        }

        $service = new UserService();
        $service->changePassword(user: Auth::user(), data: $data);

        $this->form->reset();
        $this->resetValidation();

        $this->alertSuccess(title: 'Change Password Success', body: 'Your Password has been successfully changed.');
    }
};
?>

<div class="card">
    <div class="card-header text-bg-danger">
        <span class="fas fa-user-lock fa-fw"></span>
        Form Change Password
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
            <div class="d-grid gap-3">
                <div>
                    <label class="form-label" for="current_password">
                        Current Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text" wire:target="form.current_password"
                            wire:dirty.class="border border-primary">
                            <span class="fas fa-lock fa-fw "></span>
                        </div>

                        <input type="{{ $currentPasswordVisibility ? 'text' : 'password' }}" class="form-control"
                            id="current_password" name="current_password" minlength="1" maxlength="50"
                            placeholder="Current Password" required autocapitalize="none"
                            autocomplete="current-password" wire:model="form.current_password"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled" wire:dirty.class="border border-primary">

                        <button type="button" class="input-group-text" wire:click="changeCurrentPasswordVisibility"
                            wire:dirty.class="border border-primary" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            <span class="fas fa-{{ $currentPasswordVisibility ? 'eye-slash' : 'eye' }} fa-fw"></span>
                        </button>
                    </div>
                    @error('form.current_password')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="new_password">
                        New Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text" wire:target="form.new_password"
                            wire:dirty.class="border border-primary">
                            <span class="fas fa-lock fa-fw "></span>
                        </div>

                        <input type="{{ $newPasswordVisibility ? 'text' : 'password' }}" class="form-control"
                            id="new_password" name="new_password" minlength="1" maxlength="50"
                            placeholder="New Password" required autocapitalize="none" autocomplete="current-password"
                            wire:model="form.new_password" wire:offline.class="disabled" wire:offline.attr="disabled"
                            wire:loading.class="disabled" wire:loading.attr="disabled"
                            wire:dirty.class="border border-primary">

                        <button type="button" class="input-group-text" wire:click="changeNewPasswordVisibility"
                            wire:dirty.class="border border-primary" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            <span class="fas fa-{{ $newPasswordVisibility ? 'eye-slash' : 'eye' }} fa-fw"></span>
                        </button>
                    </div>
                    @error('form.new_password')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="confirmation_password">
                        Confirmation Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text" wire:target="form.confirmation_password"
                            wire:dirty.class="border border-primary">
                            <span class="fas fa-lock fa-fw "></span>
                        </div>

                        <input type="{{ $confirmationPasswordVisibility ? 'text' : 'password' }}" class="form-control"
                            id="confirmation_password" name="confirmation_password" minlength="1" maxlength="50"
                            placeholder="Confirmation Password" required autocapitalize="none"
                            autocomplete="current-password" wire:model="form.confirmation_password"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled" wire:dirty.class="border border-primary">

                        <button type="button" class="input-group-text"
                            wire:click="changeconfirmationPasswordVisibility" wire:dirty.class="border border-primary"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span
                                class="fas fa-{{ $confirmationPasswordVisibility ? 'eye-slash' : 'eye' }} fa-fw"></span>
                        </button>
                    </div>
                    @error('form.confirmation_password')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
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
