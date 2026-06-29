<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\Oauth\OauthEditForm;
use App\Models\Oauth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

new #[Title('Edit | Oauth')] class extends Component {
    public Oauth $oauth;

    public OauthEditForm $form;

    public function mount(Oauth $oauth): void
    {
        $this->oauth = $oauth;
        $this->form->set(oauth: $oauth);
    }

    public function resetForm(): void
    {
        $this->form->set(oauth: $this->oauth);
    }

    public function submit(): void
    {
        try {
            $this->form->submit(oauth: $this->oauth);

            session()->flash('success', [
                'title' => trans('index.edit') . ' ' . trans('index.success'),
                'message' => trans('page.oauth') . ' ' . trans('message.has_been_successfully_edited'),
            ]);

            $this->redirect(route('cms.oauth.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.edit') . ' ' . trans('index.failed'), body: $errors);
        }
    }
};
?>

@section('title', trans('page.oauth'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-success">
            <span class="fas fa-edit fa-fw"></span>
            {{ trans('edit') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-success w-100" href="{{ route('cms.oauth.index') }}" wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span>
                        {{ trans('index.back') }}
                    </a>
                </div>
            </div>

            <hr />

            <x-alert-error />
            <form wire:submit.prevent="submit" role="form" autocomplete="off">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-grid gap-3">
                            <div>
                                <label class="form-label" for="code">
                                    {{ trans('validation.attributes.code') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-code fa-fw "></span>
                                    </div>
                                    <input type="text" class="form-control" id="code" name="code"
                                        minlength="1" maxlength="20" placeholder="{{ trans('index.ex') }}. Canggu"
                                        required wire:model="form.code" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 20,
                                    {{ trans('helper.unique') }}
                                </div>
                                @error('form.code')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="name">
                                    {{ trans('validation.attributes.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-gears fa-fw "></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name"
                                        minlength="1" maxlength="50" placeholder="{{ trans('index.ex') }}. Canggu"
                                        required wire:model="form.name" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 50,
                                    {{ trans('helper.unique') }}
                                </div>
                                @error('form.name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="token_type">
                                    {{ trans('validation.attributes.token_type') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-tag fa-fw "></span>
                                    </div>
                                    <textarea class="form-control" id="token_type" name="token_type" minlength="1" maxlength="65535"
                                        placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.token_type" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                    </textarea>
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 65535,
                                </div>
                                @error('form.token_type')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="expires_in">
                                    {{ trans('validation.attributes.expires_in') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-hourglass fa-fw "></span>
                                    </div>
                                    <input type="number" class="form-control" id="expires_in" name="expires_in"
                                        min="0" max="1000000000" placeholder="{{ trans('index.ex') }}. 3600"
                                        required wire:model="form.expires_in" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.min') }} : 0,
                                    {{ trans('helper.max') }} : 1.000.000.000,
                                </div>
                                @error('form.expires_in')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="scope">
                                    {{ trans('validation.attributes.scope') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-list fa-fw "></span>
                                    </div>
                                    <textarea class="form-control" id="scope" name="scope" minlength="1" maxlength="65535"
                                        placeholder="{{ trans('index.ex') }}. AUTH" required wire:model="form.scope" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                    </textarea>
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 65535,
                                </div>
                                @error('form.scope')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="created">
                                    {{ trans('validation.attributes.created') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-clock fa-fw "></span>
                                    </div>
                                    <input type="number" class="form-control" id="created" name="created"
                                        min="0" max="1000000000" placeholder="{{ trans('index.ex') }}. 1000"
                                        required wire:model="form.created" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.min') }} : 0,
                                    {{ trans('helper.max') }} : 1.000.000.000,
                                </div>
                                @error('form.created')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="d-grid gap-3">
                            <div>
                                <label class="form-label" for="refresh_token">
                                    {{ trans('validation.attributes.refresh_token') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-key fa-fw "></span>
                                    </div>
                                    <textarea class="form-control" id="refresh_token" name="refresh_token" minlength="1" maxlength="65535"
                                        placeholder="{{ trans('index.ex') }}. ABC123" required wire:model="form.refresh_token"
                                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                    </textarea>
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 65535,
                                </div>
                                @error('form.refresh_token')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="access_token">
                                    {{ trans('validation.attributes.access_token') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-key fa-fw "></span>
                                    </div>
                                    <textarea class="form-control" id="access_token" name="access_token" minlength="1" maxlength="65535"
                                        placeholder="{{ trans('index.ex') }}. ABC123" required wire:model="form.access_token"
                                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                    </textarea>
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 65535,
                                </div>
                                @error('form.access_token')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
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
</div>
