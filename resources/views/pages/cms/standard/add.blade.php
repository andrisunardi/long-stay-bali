<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\Standard\StandardAddForm;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

new #[Title('Add | Standard')] class extends Component {
    public StandardAddForm $form;

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
                'message' => trans('page.standard') . ' ' . trans('message.has_been_successfully_added'),
            ]);

            $this->redirect(route('cms.standard.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.add') . ' ' . trans('index.failed'), body: $errors);
        }
    }
};
?>

@section('title', trans('page.standard'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-plus fa-fw"></span>
            {{ trans('index.add') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.standard.index') }}" wire:navigate>
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
                        <label class="form-label" for="title">
                            {{ trans('validation.attributes.title') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-font fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="title" name="title" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') }}. Canggu" required
                                wire:model="form.title" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 50,
                            {{ trans('helper.unique') }}
                        </div>
                        @error('form.title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="title_id">
                            {{ trans('validation.attributes.title_id') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-font fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="title_id" name="title_id" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') }}. Canggu" required
                                wire:model="form.title_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 50,
                            {{ trans('helper.unique') }}
                        </div>
                        @error('form.title_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="title_zh">
                            {{ trans('validation.attributes.title_zh') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-font fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="title_zh" name="title_zh" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') }}. Canggu" required
                                wire:model="form.title_zh" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 50,
                            {{ trans('helper.unique') }}
                        </div>
                        @error('form.title_zh')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="title_fr">
                            {{ trans('validation.attributes.title_fr') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-font fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="title_fr" name="title_fr" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') }}. Canggu" required
                                wire:model="form.title_fr" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 50,
                            {{ trans('helper.unique') }}
                        </div>
                        @error('form.title_fr')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="short_description">
                            {{ trans('validation.attributes.short_description') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-text fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="short_description" name="short_description" minlength="1" maxlength="100"
                                placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.short_description"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                    </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                        </div>
                        @error('form.short_description')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="short_description_id">
                            {{ trans('validation.attributes.short_description_id') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-text fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="short_description_id" name="short_description_id" minlength="1" maxlength="100"
                                placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.short_description_id"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                    </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                        </div>
                        @error('form.short_description_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="short_description_zh">
                            {{ trans('validation.attributes.short_description_zh') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-text fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="short_description_zh" name="short_description_zh" minlength="1" maxlength="100"
                                placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.short_description_zh"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                    </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                        </div>
                        @error('form.short_description_zh')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="short_description_fr">
                            {{ trans('validation.attributes.short_description_fr') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-text fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="short_description_fr" name="short_description_fr" minlength="1" maxlength="100"
                                placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.short_description_fr"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                    </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                        </div>
                        @error('form.short_description_fr')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="description">
                            {{ trans('validation.attributes.description') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-text fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="description" name="description" minlength="1" maxlength="100"
                                placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.description"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                    </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                        </div>
                        @error('form.description')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="description_id">
                            {{ trans('validation.attributes.description_id') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-text fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="description_id" name="description_id" minlength="1" maxlength="100"
                                placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.description_id"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                    </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                        </div>
                        @error('form.description_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="description_zh">
                            {{ trans('validation.attributes.description_zh') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-text fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="description_zh" name="description_zh" minlength="1" maxlength="100"
                                placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.description_zh"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                    </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                        </div>
                        @error('form.description_zh')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="description_fr">
                            {{ trans('validation.attributes.description_fr') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-text fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="description_fr" name="description_fr" minlength="1" maxlength="100"
                                placeholder="{{ trans('index.ex') }}. Bearer" required wire:model="form.description_fr"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                    </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                        </div>
                        @error('form.description_fr')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="icon">
                            {{ trans('validation.attributes.icon') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-icons fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="icon" name="icon" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') }}. Canggu" required
                                wire:model="form.icon" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 50,
                        </div>
                        @error('form.icon')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="is_active">
                            {{ trans('validation.attributes.is_active') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="is_active_1" name="is_active"
                                    value="1" required wire:model.lazy="form.is_active"
                                    wire:offline.class="disabled" wire:offline.attr="disabled"
                                    wire:loading.class="disabled" wire:loading.attr="disabled">
                                <label class="form-check-label" for="is_active_1">
                                    {{ trans('index.yes') }}
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="is_active_0" name="is_active"
                                    value="0" required wire:model.lazy="form.is_active"
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
