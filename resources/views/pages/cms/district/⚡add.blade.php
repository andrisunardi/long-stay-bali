<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\District\DistrictAddForm;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

new #[Title('Add | District')] class extends Component {
    public DistrictAddForm $form;

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
                'message' => trans('page.district') . ' ' . trans('message.has_been_successfully_added'),
            ]);

            $this->redirect(route('cms.district.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.add').' '.trans('index.failed'), body: $errors);
        }
    }
};
?>

@section('title', trans('page.district'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-plus fa-fw"></span>
            {{ trans('index.add') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.district.index') }}"
                        wire:navigate>
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
                        <label class="form-label" for="name">
                            {{ trans('validation.attributes.name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-city fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') }}. Canggu" required
                                wire:model="form.name" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
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

                    <div class="col-sm-6">
                        <div class="d-flex gap-3">
                            <div>
                                <label class="form-label" for="is_show">
                                    {{ trans('validation.attributes.is_show') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_show_1" name="is_show"
                                            value="1" required wire:key="is_show" wire:model.lazy="form.is_show"
                                            wire:offline.class="disabled" wire:offline.attr="disabled"
                                            wire:loading.class="disabled" wire:loading.attr="disabled">
                                        <label class="form-check-label" for="is_show_1">
                                            {{ trans('index.yes') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_show_0" name="is_show"
                                            value="0" required wire:key="is_show" wire:model.lazy="form.is_show"
                                            wire:offline.class="disabled" wire:offline.attr="disabled"
                                            wire:loading.class="disabled" wire:loading.attr="disabled">
                                        <label class="form-check-label" for="is_show_0">
                                            {{ trans('index.no') }}
                                        </label>
                                    </div>
                                </div>
                                @error('form.is_show')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="is_active">
                                    {{ trans('validation.attributes.is_active') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_active_1" name="is_active"
                                            value="1" required wire:key="is_active"
                                            wire:model.lazy="form.is_active" wire:offline.class="disabled"
                                            wire:offline.attr="disabled" wire:loading.class="disabled"
                                            wire:loading.attr="disabled">
                                        <label class="form-check-label" for="is_active_1">
                                            {{ trans('index.yes') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_active_0" name="is_active"
                                            value="0" required wire:key="is_active"
                                            wire:model.lazy="form.is_active" wire:offline.class="disabled"
                                            wire:offline.attr="disabled" wire:loading.class="disabled"
                                            wire:loading.attr="disabled">
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
