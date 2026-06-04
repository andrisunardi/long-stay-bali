<?php

use App\Livewire\Component;
use App\Livewire\Forms\CMS\Area\AreaEditForm;
use App\Models\Area;
use App\Services\DistrictService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

new #[Title('Edit | Area')] class extends Component {
    public Area $area;

    public AreaEditForm $form;

    public function mount(Area $area): void
    {
        $this->area = $area;
        $this->form->set(area: $area);
    }

    public function resetForm(): void
    {
        $this->form->set(area: $this->area);
    }

    public function submit(): void
    {
        try {
            $this->form->submit(area: $this->area);

            session()->flash('success', [
                'title' => trans('index.edit') . ' ' . trans('index.success'),
                'message' => trans('page.area') . ' ' . trans('message.has_been_successfully_edited'),
            ]);

            $this->redirect(route('cms.area.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.edit') . ' ' . trans('index.failed'), body: $errors);
        }
    }

    public function districts(): object
    {
        $service = new DistrictService();
        return $service->index(isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }
};
?>

@section('title', trans('page.area'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-success">
            <span class="fas fa-edit fa-fw"></span>
            {{ trans('edit') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-success w-100" href="{{ route('cms.area.index') }}" wire:navigate>
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
                        <label class="form-label" for="district_id">
                            {{ trans('validation.attributes.district_id') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group" wire:ignore>
                            <div class="input-group-text">
                                <span class="fas fa-city fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="district_id" name="district_id" required
                                wire:key="form.district_id" wire:model.lazy="district_id" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">{{ trans('index.select') }} {{ trans('page.district') }}</option>
                                @foreach ($this->districts() as $district)
                                    <option value="{{ $district->id }}"
                                        {{ $district->id == $form->district_id ? 'selected' : '' }}
                                        wire:key="district-{{ $district->id }}">
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }}
                        </div>
                        @error('form.district_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

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
                            {{ trans('helper.maxlength') }} : 50
                        </div>
                        @error('form.name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <div class="d-flex gap-3">
                            <div>
                                <label class="form-label" for="is_promoted">
                                    {{ trans('validation.attributes.is_promoted') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_promoted_1"
                                            name="is_promoted" value="1" required wire:key="is_promoted"
                                            wire:model.lazy="form.is_promoted" wire:offline.class="disabled"
                                            wire:offline.attr="disabled" wire:loading.class="disabled"
                                            wire:loading.attr="disabled">
                                        <label class="form-check-label" for="is_promoted_1">
                                            {{ trans('index.yes') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="is_promoted_0"
                                            name="is_promoted" value="0" required wire:key="is_promoted"
                                            wire:model.lazy="form.is_promoted" wire:offline.class="disabled"
                                            wire:offline.attr="disabled" wire:loading.class="disabled"
                                            wire:loading.attr="disabled">
                                        <label class="form-check-label" for="is_promoted_0">
                                            {{ trans('index.no') }}
                                        </label>
                                    </div>
                                </div>
                                @error('form.is_promoted')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

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

@script
    <script>
        $("#district_id").on("change", function() {
            @this.set("form.district_id", $(this).val())
        })
    </script>
@endscript
