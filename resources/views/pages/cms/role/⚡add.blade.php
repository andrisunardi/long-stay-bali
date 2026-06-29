<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\Role\RoleAddForm;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

new #[Title('Add | Role')] class extends Component {
    public RoleAddForm $form;

    public function resetForm(): void
    {
        $this->form->reset();
    }

    public function submit(): void
    {
        try {
            $this->form->submit();

            session()->flash('success', [
                'title' => trans('index.add') . ' ' . trans('index.success'),
                'message' => trans('page.role') . ' ' . trans('message.has_been_successfully_added'),
            ]);

            $this->redirect(route('cms.role.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.add') . ' ' . trans('index.failed'), body: $errors);
        }
    }

    public function permissions(): object
    {
        $service = new PermissionService();
        return $service->index(guardName: 'web', orderBy: 'name', sortBy: 'asc', paginate: false);
    }
};
?>

@section('title', trans('page.role'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-plus fa-fw"></span>
            {{ trans('index.add') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.role.index') }}" wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span>
                        {{ trans('index.back') }}
                    </a>
                </div>
            </div>

            <hr />

            <x-alert-error />

            <form wire:submit.prevent="submit" permission="form" autocomplete="off">
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
                                        <span class="fas fa-key fa-fw "></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name"
                                        minlength="1" maxlength="255" placeholder="{{ trans('index.ex') }}. Admin"
                                        required wire:model="form.name" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 255,
                                    {{ trans('helper.unique') }}
                                </div>
                                @error('form.name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="guard_name">
                                    {{ trans('validation.attributes.guard_name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <span class="fas fa-shield fa-fw "></span>
                                    </div>
                                    <input type="text" class="form-control" id="guard_name" name="guard_name"
                                        minlength="1" maxlength="255" placeholder="{{ trans('index.ex') }}. web"
                                        required wire:model="form.guard_name" wire:offline.class="disabled"
                                        wire:offline.attr="disabled" wire:loading.class="disabled"
                                        wire:loading.attr="disabled">
                                </div>
                                <div class="form-text">
                                    {{ trans('helper.required') }},
                                    {{ trans('helper.minlength') }} : 1,
                                    {{ trans('helper.maxlength') }} : 255,
                                    {{ trans('helper.default') }} : web
                                </div>
                                @error('form.guard_name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="d-grid gap-3">
                            <div>
                                <label class="form-label" for="permission_ids">
                                    {{ trans('validation.attributes.permission_ids') }}
                                </label>
                                @foreach ($this->permissions() as $permission)
                                    <div class="form-check" wire:key="permission-{{ $permission->id }}">
                                        <input class="form-check-input" type="checkbox"
                                            id="permission_ids_{{ $permission->id }}" name="permission_ids"
                                            value="{{ $permission->id }}" wire:model="form.permission_ids"
                                            wire:offline.class="disabled" wire:offline.attr="disabled"
                                            wire:loading.class="disabled" wire:loading.attr="disabled">

                                        <label class="form-check-label" for="permission_ids_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('form.permission_ids')
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
