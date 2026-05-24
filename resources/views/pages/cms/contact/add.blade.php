<?php

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyRentalType;
use App\Livewire\Component;
use App\Livewire\Forms\CMS\Contact\ContactAddForm;
use App\Models\Area;
use App\Services\AreaService;
use App\Services\DistrictService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

new #[Title('Add | Contact')] class extends Component {
    public ContactAddForm $form;

    public string $district_id = '';

    public function updated(): void
    {
        $this->district_id = Area::find($this->form->area_id)->district_id ?? '';
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
                'message' => trans('page.contact') . ' ' . trans('message.has_been_successfully_added'),
            ]);

            $this->redirect(route('cms.contact.index'), navigate: true);
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('index.add') . ' ' . trans('index.failed'), body: $errors);
        }
    }

    public function districts(): object
    {
        $service = new DistrictService();
        return $service->index(isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function areas(): object
    {
        $service = new AreaService();
        return $service->index(districtId: $this->district_id, isActive: [true], orderBy: 'name', sortBy: 'asc', paginate: false);
    }

    public function propertyBedrooms(): array
    {
        return PropertyBedroom::cases();
    }

    public function propertyRentalTypes(): array
    {
        return PropertyRentalType::cases();
    }
};
?>

@section('title', trans('page.contact'))

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-bg-primary">
            <span class="fas fa-plus fa-fw"></span>
            {{ trans('index.add') }} @yield('title')
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-auto">
                    <a draggable="false" class="btn btn-primary w-100" href="{{ route('cms.contact.index') }}"
                        wire:navigate>
                        <span class="fas fa-arrow-left fa-fw"></span>
                        {{ trans('index.back') }}
                    </a>
                </div>
            </div>

            <hr />

            <x-alert-error />

            <form wire:submit.prevent="submit" role="form" autocomplete="off">
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="form-label" for="code">
                            {{ trans('validation.attributes.code') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-code fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="code" name="code" minlength="20"
                                maxlength="20" placeholder="{{ trans('index.ex') . '. ABCDEFGHIJKLMNOPQRST' }}"
                                wire:model="form.code" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 20,
                            {{ trans('helper.maxlength') }} : 20,
                            {{ trans('helper.unique') }}
                        </div>
                        <div class="form-text">
                            {{ trans('helper.contact.code.add') }}
                        </div>
                        @error('form.code')
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
                                <span class="fas fa-user fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') . '. John Doe' }}" required
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
                        <label class="form-label" for="first_name">
                            {{ trans('validation.attributes.first_name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-user fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="first_name" name="first_name" minlength="1"
                                maxlength="25" placeholder="{{ trans('index.ex') . '. John Doe' }}" required
                                wire:model="form.first_name" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 25
                        </div>
                        @error('form.first_name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="last_name">
                            {{ trans('validation.attributes.last_name') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-user fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="last_name" name="last_name" minlength="1"
                                maxlength="25" placeholder="{{ trans('index.ex') . '. John Doe' }}"
                                wire:model="form.last_name" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.required') }},
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 25
                        </div>
                        @error('form.last_name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="company">
                            {{ trans('validation.attributes.company') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-building fa-fw "></span>
                            </div>
                            <input type="text" class="form-control" id="company" name="company" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') . '. PT. Bali Real Estate' }}"
                                wire:model="form.company" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 50
                        </div>
                        @error('form.company')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="email">
                            {{ trans('validation.attributes.email') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-envelope fa-fw "></span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" minlength="1"
                                maxlength="50" placeholder="{{ trans('index.ex') . '. johndoe@gmail.com' }}"
                                wire:model="form.email" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 50
                        </div>
                        @error('form.email')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="phone">
                            {{ trans('validation.attributes.phone') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-phone fa-fw "></span>
                            </div>
                            <input type="tel" class="form-control" id="phone" name="phone" minlength="1"
                                maxlength="20" placeholder="{{ trans('index.ex') . '. 6281234567890' }}"
                                wire:model="form.phone" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                        </div>
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 20
                        </div>
                        @error('form.phone')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="district_id">
                            {{ trans('validation.attributes.district_id') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-city fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="district_id" name="district_id"
                                wire:key="district_id" wire:model.lazy="district_id" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                <option value="">{{ trans('index.select') }} {{ trans('page.district') }}
                                </option>
                                @foreach ($this->districts() as $district)
                                    <option value="{{ $district->id }}"
                                        {{ $district->id == $district_id ? 'selected' : '' }}
                                        wire:key="district-{{ $district->id }}">
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('form.district_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="area_id">
                            {{ trans('validation.attributes.area_id') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-archway fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="area_id" name="area_id"
                                wire:key="form.area_id" wire:model.lazy="area_id" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                <option value="">{{ trans('index.select') }} {{ trans('page.area') }}</option>
                                @foreach ($this->areas() as $area)
                                    <option value="{{ $area->id }}"
                                        {{ $area->id == $form->area_id ? 'selected' : '' }}
                                        wire:key="area-{{ $area->id }}">
                                        {{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('form.district_id')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="bedroom">
                            {{ trans('validation.attributes.bedroom') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-bed fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="bedroom" name="bedroom" wire:key="bedroom"
                                wire:model.lazy="form.bedroom" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.select') }} {{ trans('index.bedroom') }}
                                </option>
                                @foreach ($this->propertyBedrooms() as $propertyBedroom)
                                    <option value="{{ $propertyBedroom->value }}"
                                        {{ $propertyBedroom->value == $form->bedroom ? 'selected' : '' }}
                                        wire:key="property-bedroom-{{ $propertyBedroom->value }}">
                                        {{ $propertyBedroom->description() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('form.bedroom')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="rental_type">
                            {{ trans('validation.attributes.rental_type') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-clock fa-fw "></span>
                            </div>
                            <select class="form-select select2" id="rental_type" name="rental_type"
                                wire:key="rental_type" wire:model.lazy="form.rental_type"
                                wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                                <option value="">
                                    {{ trans('index.select') }} {{ trans('index.rental_type') }}
                                </option>
                                @foreach ($this->propertyRentalTypes() as $propertyRentalType)
                                    <option value="{{ $propertyRentalType->value }}"
                                        {{ $propertyRentalType->value == $form->rental_type ? 'selected' : '' }}
                                        wire:key="property-rental-type-{{ $propertyRentalType->value }}">
                                        {{ $propertyRentalType->description() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('form.rental_type')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label" for="message">
                            {{ trans('validation.attributes.message') }}
                        </label>
                        <div class="input-group">
                            <div class="input-group-text">
                                <span class="fas fa-file-lines fa-fw "></span>
                            </div>
                            <textarea class="form-control" id="message" name="message" minlength="1" maxlength="1000"
                                placeholder="{{ trans('index.ex') . '. Others' }}" wire:model="form.message" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            </textarea>
                        </div>
                        <div class="form-text">
                            {{ trans('helper.minlength') }} : 1,
                            {{ trans('helper.maxlength') }} : 1000
                        </div>
                        @error('form.message')
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

@script
    <script>
        $("#district_id").on("change", function() {
            @this.set("district_id", $(this).val())
        })

        $("#area_id").on("change", function() {
            @this.set("form.area_id", $(this).val())
        })

        $("#bedroom").on("change", function() {
            @this.set("form.bedroom", $(this).val())
        })

        $("#rental_type").on("change", function() {
            @this.set("form.rental_type", $(this).val())
        })
    </script>
@endscript
