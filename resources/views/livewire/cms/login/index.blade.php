@section('title', trans('page.login'))
@section('icon', 'fas fa-sign-in-alt')

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center py-sm-5 py-md-auto">
    <div>
        <h3 class="text-uppercase text-center fw-bold">
            {{ config('app.name') }}
        </h3>
        <p class="text-center">Please Login With Your Acount To Continue</p>
        <form wire:submit.prevent="submit" role="form" autocomplete="off">
            <div class="d-grid gap-3">
                <div>
                    <label class="form-label" for="username">
                        {{ trans('field.username') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="fas fa-user fa-fw "></span>
                        </div>
                        <input type="text" class="form-control" id="username" name="username" minlength="1"
                            maxlength="50" placeholder="{{ trans('field.username') }}" required autocapitalize="none"
                            autofocus wire:key="username" wire:model.lazy="username" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    </div>
                    @error('form.username')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="password">
                        {{ trans('field.password') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="fas fa-lock fa-fw "></span>
                        </div>
                        <input type="{{ $passwordVisibility ? 'text' : 'password' }}" class="form-control"
                            id="password" name="password" minlength="1" maxlength="50"
                            placeholder="{{ trans('field.password') }}" required autocapitalize="none"
                            wire:key="password" wire:model.lazy="password" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                        <div class="input-group-text pointer">
                            <span class="fas fa-{{ $passwordVisibility ? 'eye' : 'eye-slash' }} fa-fw"
                                wire:click="changePasswordVisibility" offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            </span>
                        </div>
                    </div>
                    @error('form.username')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="remember_me"
                            name="remember_me">
                        <label class="form-check-label" for="remember_me">
                            {{ trans('field.remember_me') }}
                        </label>
                    </div>

                    <div>
                        <a draggable="false" href="{{ route('cms.login') }}" wire:navigate>
                            {{ trans('page.forgot_password') }}
                        </a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary bg-gradient w-100" wire:key="submit"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">
                        <span class="fas fa-sign-in-alt fa-fw"></span>
                        {{ trans('page.login') }}
                    </span>
                    <span wire:loading wire:target="submit" class="w-100">
                        <span class="spinner-border spinner-border-sm"></span>
                        {{ trans('page.login') }}
                    </span>
                </button>
            </div>
        </form>

        <div class="text-body-secondary text-center small mt-4">
            <div class="small">
                &copy; {{ trans('footer.copyright') }}
                2025 - {{ now()->year }} &reg;
                <a draggable="false" href="{{ route('index') }}" target="_blank"
                    class="text-body text-decoration-none">
                    <strong>{{ config('app.name') }}</strong>&trade;
                </a>
                <br />
                {{ trans('footer.all_rights_reserved') }}.
            </div>

            <div class="small mt-2">
                {{ trans('footer.created_and_designed_by') }}
                <a draggable="false" href="https://www.diw.co.id" target="_blank">
                    <img draggable="false" src="{{ asset('images/icon-diw.co.id.png') }}" alt="Icon DIW.co.id"
                        title="{{ trans('footer.created_and_designed_by') }} DIW.co.id">
                </a>
            </div>
        </div>
    </div>
</div>
