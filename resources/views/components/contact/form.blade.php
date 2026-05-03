<?php

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyRentalType;
use App\Livewire\Component;
use App\Livewire\Forms\Contact\ContactSubmitForm;
use App\Services\AreaService;
use App\Services\DistrictService;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Exception;

new class extends Component {
    public ContactSubmitForm $form;

    public string $district_id = '';

    public function resetForm(): void
    {
        $this->form->reset();
        $this->reset(['district_id']);
    }

    public function submit(): void
    {
        try {
            $this->form->submit();

            $this->alertSuccess(title: trans('contact.form.success.title'), body: trans('contact.form.success.body'));

            $this->form->reset();
        } catch (Exception $e) {
            $this->alertError(title: trans('contact.form.failed.title'), body: 'Something went wrong');
        } catch (ValidationException $e) {
            $errors = collect($e->validator->errors()->all())->implode('<br>');

            $this->alertError(title: trans('contact.form.failed.title'), body: $errors);
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

<div class="card card-body rounded-3 p-lg-4 p-xl-5">

    <x-alert-error />

    <form wire:submit.prevent="submit" role="form" autocomplete="off">
        <div class="row g-4">
            <div class="col-sm-6">
                <label class="form-label" for="first_name">
                    {{ trans('contact.form.label.first_name') }}
                    <span class="text-danger">*</span>
                </label>

                <input type="text" class="form-control rounded-3" id="first_name" name="first_name" minlength="1"
                    maxlength="50" placeholder="{{ trans('contact.form.placeholder.first_name') }}" required
                    wire:model="form.first_name" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled">

                @error('form.first_name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label" for="last_name">
                    {{ trans('contact.form.label.last_name') }}
                    <span class="text-danger">*</span>
                </label>

                <input type="text" class="form-control rounded-3" id="last_name" name="last_name" minlength="1"
                    maxlength="50" placeholder="{{ trans('contact.form.placeholder.last_name') }}" required
                    wire:model="form.last_name" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled">

                @error('form.last_name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label" for="email">
                    {{ trans('contact.form.label.email') }}
                    <span class="text-danger">*</span>
                </label>

                <input type="text" class="form-control rounded-3" id="email" name="email" minlength="1"
                    maxlength="50" placeholder="{{ trans('contact.form.placeholder.email') }}" required
                    wire:model="form.email" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled">

                @error('form.email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label" for="phone">
                    {{ trans('contact.form.label.phone') }}
                    <span class="text-danger">*</span>
                </label>

                <input type="tel" class="form-control rounded-3" id="phone" name="phone" minlength="1"
                    maxlength="50" placeholder="{{ trans('contact.form.placeholder.phone') }}" required
                    wire:model="form.phone" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled">

                @error('form.phone')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label" for="district_id">
                    {{ trans('contact.form.label.district') }}
                    <span class="text-danger">*</span>
                </label>

                <select class="form-select rounded-3" id="district_id" name="district_id"
                    placeholder="{{ trans('contact.form.placeholder.district') }}" required
                    wire:model.lazy="district_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled">
                    <option class="">{{ trans('index.district') }}</option>
                    @foreach ($this->districts() as $district)
                        <option value="{{ $district->id }}" wire:key="district-{{ $district->id }}">
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>

                @error('form.district_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label" for="area_id">
                    {{ trans('contact.form.label.area') }}
                    <span class="text-danger">*</span>
                </label>

                <select class="form-select rounded-3" id="area_id" name="area_id"
                    placeholder="{{ trans('contact.form.placeholder.area') }}" required wire:model="form.area_id"
                    wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                    wire:loading.attr="disabled">
                    <option class="">{{ trans('index.area') }}</option>
                    @foreach ($this->areas() as $area)
                        <option value="{{ $area->id }}" wire:key="area-{{ $area->id }}">
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>

                @error('form.area_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label" for="bedroom">
                    {{ trans('contact.form.label.bedroom') }}
                    <span class="text-danger">*</span>
                </label>

                <select class="form-select rounded-3" id="bedroom" name="bedroom" required
                    wire:model="form.bedroom" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled">
                    <option class="">{{ trans('contact.form.label.bedroom') }}</option>
                    @foreach ($this->propertyBedrooms() as $propertyBedroom)
                        <option value="{{ $propertyBedroom->value }}"
                            wire:key="property-bedroom-{{ $propertyBedroom->value }}">
                            {{ $propertyBedroom->description() }}
                        </option>
                    @endforeach
                </select>

                @error('form.bedroom')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6">
                <label class="form-label rounded-3" for="rental_type">
                    {{ trans('contact.form.label.rental_type') }}
                    <span class="text-danger">*</span>
                </label>

                <select class="form-select rounded-3" id="rental_type" name="rental_type" required
                    wire:model="form.rental_type" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled">
                    <option class="">{{ trans('contact.form.placeholder.rental_type') }}</option>
                    @foreach ($this->propertyRentalTypes() as $propertyRentalType)
                        <option value="{{ $propertyRentalType->value }}"
                            wire:key="property-rental_type-{{ $propertyRentalType->value }}">
                            {{ $propertyRentalType->name }}
                        </option>
                    @endforeach
                </select>

                @error('form.rental_type')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label" for="message">
                    {{ trans('contact.form.label.message') }}
                    <span class="text-danger">*</span>
                </label>

                <textarea type="text" class="form-control rounded-3" id="message" name="message" minlength="1"
                    maxlength="1000" rows="5" placeholder="{{ trans('contact.form.placeholder.message') }}" required
                    wire:model="form.message" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled"></textarea>

                @error('form.message')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success rounded-pill w-100" wire:offline.class="disabled"
                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">
                        <span class="fas fa-paper-plane fa-fw"></span>
                        {{ trans('contact.form.submit') }}
                    </span>
                    <span wire:loading wire:target="submit" class="w-100">
                        <span class="spinner-border spinner-border-sm"></span>
                        {{ trans('contact.form.submit') }}
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
