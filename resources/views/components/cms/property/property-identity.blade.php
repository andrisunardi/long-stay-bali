<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <div class="d-grid gap-3">
            <div>
                <label class="form-label" for="code">
                    {{ trans('property.internal_property_code') }}
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-code fa-fw "></span>
                    </div>
                    <input type="text" class="form-control" id="code" name="code" minlength="1"
                        maxlength="10" placeholder="{{ trans('index.ex') . '. ABCDE12345' }}" required
                        wire:model="form.code" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }},
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 10,
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
                        <span class="fas fa-building fa-fw "></span>
                    </div>
                    <input type="text" class="form-control" id="name" name="name" minlength="1"
                        maxlength="100" placeholder="{{ trans('index.ex') . '. Canggu Villa' }}" required
                        wire:model="form.name" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }},
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 100
                </div>
                @error('form.name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="user_id">
                    {{ trans('property.agent_name') }}
                </label>
                <div class="input-group" wire:ignore>
                    <div class="input-group-text">
                        <span class="fas fa-user fa-fw "></span>
                    </div>
                    @if (Auth::user()->hasRole('Admin'))
                        <select class="form-select select2-delete" id="user_id" name="user_id"
                            wire:model.lazy="form.user_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                            wire:loading.class="disabled" wire:loading.attr="disabled">
                            <option value="">
                                {{ trans('index.select') }}
                                {{ trans('validation.attributes.user_id') }}
                            </option>
                            @foreach ($this->users() as $user)
                                <option value="{{ $user->id }}" wire:key="user-{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input class="form-control" type="text" value="{{ Auth::user()->name }}" disabled>
                    @endif
                </div>
                @error('form.user_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="availability_date">
                    {{ trans('property.availability_date') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-calendar fa-fw "></span>
                    </div>
                    <input type="date" class="form-control" id="availability_date" name="availability_date"
                        min="{{ $property?->availability_date?->toDateString() ?? now()->toDateString() }}"
                        max="2099-12-31" wire:model="form.availability_date" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.min') }} : {{ trans('index.today') }},
                    {{ trans('helper.max') }} :
                    {{ Date::parse('2099-12-31')->isoFormat('DD MMMM YYYY') }}
                </div>
                @error('form.availability_date')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="visit_date">
                    {{ trans('property.date_of_visit') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-calendar fa-fw "></span>
                    </div>
                    <input type="date" class="form-control" id="visit_date" name="visit_date"
                        min="{{ $property?->visit_date?->toDateString() ?? now()->toDateString() }}" max="2099-12-31"
                        @if (!Auth::user()->hasRole('Admin')) disabled @endif wire:model="form.visit_date"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.min') }} : {{ trans('index.today') }},
                    {{ trans('helper.max') }} :
                    {{ Date::parse('2099-12-31')->isoFormat('DD MMMM YYYY') }}
                </div>
                @error('form.visit_date')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="year_built">
                    {{ trans('property.year_built') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-calendar fa-fw "></span>
                    </div>
                    <input type="number" class="form-control" id="year_built" name="year_built" min="1900"
                        max="2100" placeholder="{{ trans('index.ex') . '. 2000' }}" wire:model="form.year_built"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.min') }} : 1900,
                    {{ trans('helper.max') }} : 2100
                </div>
                @error('form.year_built')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="completion_date">
                    {{ trans('property.completion_date') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-calendar fa-fw "></span>
                    </div>
                    <input type="date" class="form-control" id="completion_date" name="completion_date"
                        min="{{ $property?->completion_date?->toDateString() ?? now()->toDateString() }}"
                        max="2099-12-31" wire:model="form.completion_date" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.min') }} : {{ trans('index.today') }},
                    {{ trans('helper.max') }} :
                    {{ Date::parse('2099-12-31')->isoFormat('DD MMMM YYYY') }}
                </div>
                @error('form.completion_date')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="bedroom">
                    {{ trans('property.bedroom') }}
                </label>
                <div>
                    @foreach ($this->propertyBedrooms() as $propertyBedroom)
                        <div class="form-check form-check-inline"
                            wire:key="rental-type-{{ $propertyBedroom->value }}">
                            <input class="form-check-input" type="radio"
                                id="bedroom_{{ $propertyBedroom->value }}" name="bedroom"
                                value="{{ $propertyBedroom->value }}"
                                {{ $propertyBedroom->value == $form->bedroom ? 'checked' : '' }}
                                wire:model.lazy="form.bedroom" wire:offline.class="disabled"
                                wire:offline.attr="disabled" wire:loading.class="disabled"
                                wire:loading.attr="disabled">
                            <label class="form-check-label" for="bedroom_{{ $propertyBedroom->value }}">
                                {{ $propertyBedroom->description() }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('form.bedroom')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="d-flex flex-column gap-3">
            <div>
                <label class="form-label" for="description">
                    {{ trans('validation.attributes.description') }}
                </label>
                <x-form.trix model="form.description" />
                <div class="form-text">
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 65.535,
                </div>
                @error('form.description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="description_id">
                    {{ trans('validation.attributes.description_id') }}
                </label>
                <x-form.trix model="form.description_id" />
                <div class="form-text">
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 65.535,
                </div>
                @error('form.description_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="description_fr">
                    {{ trans('validation.attributes.description_fr') }}
                </label>
                <x-form.trix model="form.description_fr" />
                <div class="form-text">
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 65.535,
                </div>
                @error('form.description_fr')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- <div class="col-sm-6">
        <label class="form-label" for="image">
            {{ trans('validation.attributes.image') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-image fa-fw "></span>
            </div>
            <input type="file" class="form-control" id="image" name="image"
                accept="image/*,capture=camera,image/jpg,image/jpeg,image/png,image/gif,image/webp"
                wire:model="form.image" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.format') }} : jpg .jpeg .png .gif .webp,
            {{ trans('helper.max_size') }} : 12 MB
        </div>
        @error('form.image')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
        @if ($form->image)
            <div class="mt-3">
                <img draggable="false" loading="lazy" decoding="async"
                    class="w-100 h-100 rounded user-select-none pe-none" src="{{ $form->image->temporaryUrl() }}"
                    alt="{{ trans('index.image_temporary_url') }} - {{ config('constants.name') }}"
                    onerror="asset('images/logo.png')">
            </div>
        @elseif ($property?->image_path)
            <div class="mt-3">
                <a draggable="false" href="{{ $property->image }}" target="_blank">
                    <img draggable="false" loading="lazy" decoding="async" class="img-fluid w-100 rounded"
                        width="100" src="{{ $property->image }}"
                        alt="{{ trans('page.property') }} - {{ $property->id }}"
                        onerror="asset('images/image-not-available.png')" />
                </a>
            </div>
        @endif
    </div> --}}

    <div class="col-12">
        <label class="form-label" for="type">
            {{ trans('property.type') }}
        </label>
        <div>
            @foreach (PropertyType::cases() as $propertyType)
                <div class="form-check form-check-inline" wire:key="type-{{ $propertyType->value }}">
                    <input class="form-check-input" type="radio" id="type_{{ $propertyType->value }}"
                        name="type" value="{{ $propertyType->value }}"
                        {{ $propertyType->value == $form->type ? 'checked' : '' }} wire:model.lazy="form.type"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                    <label class="form-check-label" for="type_{{ $propertyType->value }}">
                        {{ Str::headline($propertyType->name) }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.type')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label" for="status">
            {{ trans('property.status') }}
        </label>
        <div>
            @foreach ($this->propertyStatuses() as $propertyStatus)
                <div class="form-check form-check-inline" wire:key="status-{{ $propertyStatus->value }}">
                    <input class="form-check-input" type="radio" id="status_{{ $propertyStatus->value }}"
                        name="status" value="{{ $propertyStatus->value }}"
                        {{ $propertyStatus->value == $form->status ? 'checked' : '' }} wire:model.lazy="form.status"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                    <label class="form-check-label" for="status_{{ $propertyStatus->value }}">
                        {{ $propertyStatus->description() }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.status')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
