<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\ForgotPassword\ForgotPasswordForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

new #[Title('Forgot Password')] class extends Component {
    public ForgotPasswordForm $form;

    public bool $passwordVisibility = false;

    public function mount(): void
    {
        if (Auth::check()) {
            session()->flash('error', [
                'title' => trans('index.forgot_password') . ' ' . trans('index.failed'),
                'message' => trans('message.you_already_login'),
            ]);

            $this->redirectIntended(route('cms.home'), navigate: true);
        }
    }

    public function changePasswordVisibility(): void
    {
        $this->passwordVisibility = !$this->passwordVisibility;
    }

    public function submit(): void
    {
        $newPassword = $this->form->submit();

        if (!$newPassword) {
            $this->form->reset();
            $this->alertError(title: trans('index.forgot_password') . ' ' . trans('index.failed'), body: trans('message.username_or_email_or_phone_is_invalid'));

            return;
        }

        session()->flash('success', [
            'title' => trans('index.forgot_password') . ' ' . trans('index.success'),
            'message' => trans('field.new_password') . " : {$newPassword}",
        ]);

        $this->redirectIntended(route('cms.login'), navigate: true);
    }
};
?>

@section('title', trans('page.forgot_password'))

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center py-sm-5 py-md-auto">
    <div>
        <h3 class="text-uppercase text-center fw-bold">
            {{ config('app.name') }}
        </h3>

        <p class="text-center">
            {{ trans('message.please_enter_your_data_to_get_new_password') }}
        </p>

        <form wire:submit.prevent="submit" role="form" autocomplete="off">
            <div class="d-grid gap-3">
                <div>
                    <label class="form-label" for="username">
                        {{ trans('validation.attributes.username') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text" wire:target="form.username"
                            wire:dirty.class="border border-primary">
                            <span class="fas fa-user fa-fw "></span>
                        </div>
                        <input type="text" class="form-control" id="username" name="username" minlength="1"
                            maxlength="50" placeholder="{{ trans('validation.attributes.username') }}" required
                            autocapitalize="none" autocomplete="username" autofocus wire:model="form.username"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled" wire:dirty.class="border border-primary">
                    </div>
                    @error('form.username')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="email">
                        {{ trans('validation.attributes.email') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text" wire:target="form.email" wire:dirty.class="border border-primary">
                            <span class="fas fa-envelope fa-fw "></span>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" minlength="1"
                            maxlength="50" placeholder="{{ trans('validation.attributes.email') }}" required
                            autocapitalize="none" autocomplete="email" autofocus wire:model="form.email"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled" wire:dirty.class="border border-primary">
                    </div>
                    @error('form.email')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="phone">
                        {{ trans('validation.attributes.phone') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text" wire:target="form.phone" wire:dirty.class="border border-primary">
                            <span class="fas fa-phone fa-fw "></span>
                        </div>
                        <input type="tel" class="form-control" id="phone" name="phone" minlength="1"
                            maxlength="20" placeholder="{{ trans('validation.attributes.phone') }}" required
                            autocapitalize="none" autocomplete="phone" autofocus wire:model="form.phone"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled" wire:dirty.class="border border-primary">
                    </div>
                    @error('form.phone')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="confirm_reset"
                            name="confirm_reset" required wire:model="form.confirm_reset" wire.offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                        <label class="form-check-label" for="confirm_reset">
                            {{ trans('validation.attributes.confirm_reset') }}
                        </label>
                        @error('form.confirm_reset')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <a draggable="false" href="{{ route('cms.login') }}" wire:navigate>
                            {{ trans('index.back_to') }} {{ trans('page.login') }}
                        </a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary bg-gradient w-100" wire:offline.class="disabled"
                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">
                        <span class="fas fa-paper-plane fa-fw"></span>
                        {{ trans('index.submit') }}
                    </span>
                    <span wire:loading wire:target="submit" class="w-100">
                        <span class="spinner-border spinner-border-sm"></span>
                        {{ trans('index.submit') }}
                    </span>
                </button>
            </div>
        </form>

        <div class="text-body-secondary text-center small mt-4">
            <div class="small">
                &copy; {{ trans('footer.copyright') }}
                2025 - {{ now()->year }} &reg;
                <a draggable="false" href="{{ route('cms.home') }}" target="_blank"
                    class="text-body text-decoration-none">
                    <strong>{{ config('app.name') }}</strong>&trade;
                </a>
                <br />
                {{ trans('footer.all_rights_reserved') }}.
            </div>
            <div class="d-flex justify-content-center gap-1 small mt-2 ">
                {{ trans('footer.created_and_designed_by') }}
                <a draggable="false" href="https://www.diw.co.id" target="_blank">
                    <img draggable="false" loading="lazy" decoding="async"
                        src="{{ asset('images/icon-diw.co.id.png') }}" alt="Icon DIW.co.id"
                        title="{{ trans('footer.created_and_designed_by') }} DIW.co.id">
                </a>
            </div>
        </div>
    </div>
</div>
