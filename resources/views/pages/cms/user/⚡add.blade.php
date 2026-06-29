<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\User\UserAddForm;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

new #[Title('Add | User')] class extends Component {
    public UserAddForm $form;

    public function resetForm(): void
    {
        $this->form->reset();
    }

    public function generateRandomPassword(): void
    {
        $this->form->password = Str::random(10);
    }

    public function submit(): void
    {
        try {
            $this->form->submit();

            session()->flash('success', [
                'title' => trans('index.add') . ' ' . trans('index.success'),
                'message' => trans('page.user') . ' ' . trans('message.has_been_successfully_added'),
            ]);

            $this->redirect(route('cms.user.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.add') . ' ' . trans('index.failed'), body: $errors);
        }
    }

    public function roles(): object
    {
        $service = new RoleService();
        return $service->index(guardName: 'web', orderBy: 'name', sortBy: 'asc', paginate: false);
    }
};
?>

@section('title', trans('page.user'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-plus fa-fw"></span>
            {{ trans('index.add') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.user.index') }}" wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span> {{ trans('index.back') }}
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
                                <label class="form-label" for="name">
                                    {{ trans('validation.attributes.name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-user fa-fw "></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name"
                                        minlength="1" maxlength="50" placeholder="{{ trans('index.ex') }}. John Doe"
                                        required wire:model="form.name" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }}
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 50,
                                    {{ trans('helper.unique') }}
                                </div>
                                @error('form.name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="email">
                                    {{ trans('validation.attributes.email') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope fa-fw "></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email"
                                        minlength="1" maxlength="50"
                                        placeholder="{{ trans('index.ex') }}. johndoe@gmail.com" required
                                        wire:model="form.email" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }}
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 50,
                                    {{ trans('helper.unique') }}
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
                                    <div class="input-group-text">
                                        <span class="fas fa-phone fa-fw "></span>
                                    </div>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        minlength="1" maxlength="20"
                                        placeholder="{{ trans('index.ex') }}. 6281234567890" required
                                        wire:model="form.phone" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }}
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 20,
                                    {{ trans('helper.unique') }}
                                </div>
                                @error('form.phone')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="username">
                                    {{ trans('validation.attributes.username') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-id-badge fa-fw "></span>
                                    </div>
                                    <input type="text" class="form-control" id="username" name="username"
                                        minlength="1" maxlength="50" placeholder="{{ trans('index.ex') }}. 012345"
                                        required wire:model="form.username" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }}
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 50,
                                    {{ trans('helper.unique') }}
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
                                    <div class="input-group-text">
                                        <span class="fas fa-lock fa-fw "></span>
                                    </div>
                                    <input type="text" class="form-control" id="password" name="password"
                                        minlength="1" maxlength="50" placeholder="Ex. 12345678" required
                                        wire:model="form.password" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">

                                    <button type="button" class="icon-link input-group-text"
                                        wire:click="generateRandomPassword" wire:dirty.class="border border-primary"
                                        wire:offline.class="disabled" wire:offline.attr="disabled"
                                        wire:loading.class="disabled" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="generateRandomPassword">
                                            <span class="fas fa-rotate fa-fw"></span>
                                            {{ trans('index.generate') }}
                                        </span>
                                        <span wire:loading wire:target="generateRandomPassword" class="w-100">
                                            <span class="spinner-border spinner-border-sm"></span>
                                            {{ trans('index.generate') }}
                                        </span>
                                    </button>
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }}
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 50
                                </div>
                                @error('form.password')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="image">
                                    {{ trans('validation.attributes.image') }}
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
                                    {{ trans('helper.format') }} : .jpg .jpeg .png .gif .webp
                                    {{ trans('helper.size') }} : 12 MB
                                </div>
                                @error('form.image')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($form->image)
                                <div>
                                    <div class="alert alert-info w-100" role="alert" wire:loading
                                        wire:target="form.image">
                                        {{ trans('message.please_wait_until_the_uploading_finished') }}
                                    </div>

                                    <div>
                                        <img draggable="false" loading="lazy" decoding="async"
                                            class="img-fluid w-100 rounded" width="100"
                                            src="{{ $form->image->temporaryUrl() }}" alt="Image Temporary Url"
                                            onerror="asset('images/image-not-available.png')" />
                                    </div>
                                </div>
                            @endif

                            <div>
                                <label class="form-label" for="is_active">
                                    {{ trans('validation.attributes.is_active') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_active_1"
                                            name="is_active" value="1" required wire:model.lazy="form.is_active"
                                            wire:offline.class="disabled" wire:offline.attr="disabled"
                                            wire:loading.class="disabled" wire:loading.attr="disabled">
                                        <label class="form-check-label" for="is_active_1">
                                            {{ trans('index.yes') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_active_0"
                                            name="is_active" value="0" required wire:model.lazy="form.is_active"
                                            wire:offline.class="disabled" wire:offline.attr="disabled"
                                            wire:loading.class="disabled" wire:loading.attr="disabled">
                                        <label class="form-check-label" for="is_active_0">
                                            {{ trans('index.no') }}
                                        </label>
                                    </div>
                                </div>
                                @error('form.is_active')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="d-grid gap-3">
                            <div>
                                <label class="form-label" for="role_ids">
                                    {{ trans('validation.attributes.role_ids') }}
                                </label>
                                @foreach ($this->roles() as $role)
                                    <div class="form-check" wire:key="role-{{ $role->id }}">
                                        <input class="form-check-input" type="checkbox"
                                            id="role_ids_{{ $role->id }}" name="role_ids"
                                            value="{{ $role->id }}" wire:model="form.role_ids"
                                            wire:offline.class="disabled" wire:offline.attr="disabled"
                                            wire:loading.class="disabled" wire:loading.attr="disabled">

                                        <label class="form-check-label" for="role_ids_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('form.role_ids')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="col-6 col-sm-auto">
                        <button type="submit" class="btn btn-primary w-100" wire:offline.class="disabled"
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
                    <div class="col-6 col-sm-auto">
                        <button type="button" class="btn btn-warning w-100" wire:click="resetForm"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="resetForm">
                                <span class="fas fa-eraser fa-fw"></span>
                                {{ trans('index.reset') }}
                            </span>
                            <span wire:loading wire:target="resetForm" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ trans('index.reset') }}
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
