<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\Guide\GuideAddForm;
use App\Services\GuideCategoryService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;

new #[Title('Add | Guide')] class extends Component {
    public GuideAddForm $form;

    #[On('imageUpdated')]
    public function setImage($image): void
    {
        $this->form->image = $image;
    }

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
                'message' => trans('page.guide') . ' ' . trans('message.has_been_successfully_added'),
            ]);

            $this->redirect(route('cms.guide.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.add') . ' ' . trans('index.failed'), body: $errors);
        }
    }

    public function guideCategories(): object
    {
        $service = new GuideCategoryService();
        return $service->index(isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }
};
?>

@section('title', trans('page.guide'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-plus fa-fw"></span>
            {{ trans('index.add') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.guide.index') }}" wire:navigate>
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
                        <label class="form-label" for="guide_category_id">
                            {{ trans('validation.attributes.guide_category_id') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-tags fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="guide_category_id" name="guide_category_id" required
                                wire:key="form.guide_category_id" wire:model.lazy="guide_category_id"
                                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                <option value="">{{ trans('index.select') }} {{ trans('page.guide_category') }}
                                </option>
                                @foreach ($this->guideCategories() as $guideCategory)
                                    <option value="{{ $guideCategory->id }}"
                                        {{ $guideCategory->id == $form->guide_category_id ? 'selected' : '' }}
                                        wire:key="guide-category-{{ $guideCategory->id }}">
                                        {{ $guideCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }}
                        </div>
                        @error('form.guide_category_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="title">
                            {{ trans('validation.attributes.title') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-newspaper fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="title" name="title" minlength="1"
                                maxlength="100" placeholder="{{ trans('index.ex') }}. Canggu" required
                                wire:model="form.title" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 100,
                            {{ trans('helper.unique') }}
                        </div>
                        @error('form.title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="title_id">
                            {{ trans('validation.attributes.title_id') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-newspaper fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="title_id" name="title_id" minlength="1"
                                maxlength="200" placeholder="{{ trans('index.ex') }}. Canggu"
                                wire:model="form.title_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 200,
                            {{ trans('helper.unique') }}
                        </div>
                        @error('form.title_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="title_zh">
                            {{ trans('validation.attributes.title_zh') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-newspaper fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="title_zh" name="title_zh" minlength="1"
                                maxlength="200" placeholder="{{ trans('index.ex') }}. Canggu"
                                wire:model="form.title_zh" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 200,
                            {{ trans('helper.unique') }}
                        </div>
                        @error('form.title_zh')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="title_fr">
                            {{ trans('validation.attributes.title_fr') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-newspaper fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="title_fr" name="title_fr"
                                minlength="1" maxlength="200" placeholder="{{ trans('index.ex') }}. Canggu"
                                wire:model="form.title_fr" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 200,
                            {{ trans('helper.unique') }}
                        </div>
                        @error('form.title_fr')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="body">
                            {{ trans('validation.attributes.body') }}
                            <span class="text-danger">*</span>
                        </label>
                        <x-form.trix model="form.body" />
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 65.535,
                        </div>
                        @error('form.body')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="body_id">
                            {{ trans('validation.attributes.body_id') }}
                        </label>
                        <x-form.trix model="form.body_id" />
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 65.535,
                        </div>
                        @error('form.body_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="body_zh">
                            {{ trans('validation.attributes.body_zh') }}
                        </label>
                        <x-form.trix model="form.body_zh" />
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 65.535,
                        </div>
                        @error('form.body_zh')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="body_fr">
                            {{ trans('validation.attributes.body_fr') }}
                        </label>
                        <x-form.trix model="form.body_fr" />
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 65.535,
                        </div>
                        @error('form.body_fr')
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
                                        <input type="radio" class="form-check-input" id="is_active_1"
                                            name="is_active" value="1" required wire:key="is_active"
                                            wire:model.lazy="form.is_active" wire:offline.class="disabled"
                                            wire:offline.attr="disabled" wire:loading.class="disabled"
                                            wire:loading.attr="disabled">
                                        <label class="form-check-label" for="is_active_1">
                                            {{ trans('index.yes') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_active_0"
                                            name="is_active" value="0" required wire:key="is_active"
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

                <livewire:cms.form.guide.image />

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

@script
    <script>
        $("#guide_category_id").on("change", function() {
            @this.set("form.guide_category_id", $(this).val())
        })
    </script>
@endscript
