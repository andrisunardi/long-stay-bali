<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\Login\LoginForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

new #[Title('Login')] class extends Component {
    public LoginForm $form;

    public bool $passwordVisibility = false;

    public function mount(): void
    {
        if (Auth::check()) {
            session()->flash('error', [
                'title' => trans('index.login') . ' ' . trans('index.failed'),
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
        $user = $this->form->submit();

        if ($user) {
            session()->flash('success', [
                'title' => trans('index.login') . ' ' . trans('index.success'),
                'message' => trans('message.you_have_successfully_logged_in'),
            ]);

            $this->redirectIntended(route('cms.home'), navigate: true);

            return;
        }

        $this->form->reset();

        $this->alertError(title: trans('index.login') . ' ' . trans('index.failed'), body: trans('message.username_or_password_is_invalid'));
    }
};
?>

@section('title', trans('page.login'))

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center py-sm-5 py-md-auto">
    <div>
        <h3 class="text-uppercase text-center fw-bold">
            {{ config('app.name') }}
        </h3>

        <p class="text-center">
            {{ trans('message.please_login_with_your_account_to_continue') }}
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
                    <label class="form-label" for="password">
                        {{ trans('validation.attributes.password') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text" wire:target="form.password"
                            wire:dirty.class="border border-primary">
                            <span class="fas fa-lock fa-fw "></span>
                        </div>

                        <input type="{{ $passwordVisibility ? 'text' : 'password' }}" class="form-control"
                            id="password" name="password" minlength="1" maxlength="50"
                            placeholder="{{ trans('validation.attributes.password') }}" required autocapitalize="none"
                            autocomplete="current-password" wire:model="form.password" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled"
                            wire:dirty.class="border border-primary">

                        <button type="button" class="input-group-text" wire:click="changePasswordVisibility"
                            wire:dirty.class="border border-primary" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            <span class="fas fa-{{ $passwordVisibility ? 'eye-slash' : 'eye' }} fa-fw"></span>
                        </button>
                    </div>
                    @error('form.username')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="remember_me"
                            name="remember_me" wire.key="remember_me" wire:model="form.remember"
                            wire.offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                        <label class="form-check-label" for="remember_me">
                            {{ trans('validation.attributes.remember_me') }}
                        </label>
                        @error('form.remember')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <a draggable="false" href="{{ route('cms.forgot-password') }}" wire:navigate>
                            {{ trans('page.forgot_password') }}
                        </a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary bg-gradient w-100" wire:offline.class="disabled"
                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">
                        <span class="fas fa-sign-in-alt fa-fw"></span>
                        {{ trans('index.login') }}
                    </span>
                    <span wire:loading wire:target="submit" class="w-100">
                        <span class="spinner-border spinner-border-sm"></span>
                        {{ trans('index.login') }}
                    </span>
                </button>
            </div>
        </form>

        <div class="text-body-secondary text-center small mt-4">
            <div class="small">
                &copy; {{ trans('footer.copyright') }}
                2025 - {{ now()->year }} &reg;
                <a draggable="false" href="{{ route('home') }}" target="_blank" class="text-body text-decoration-none">
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
