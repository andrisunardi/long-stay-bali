<div class="row g-3">
    <div class="col-sm-6">
        <div class="d-grid gap-3">
            <div>
                <label class="form-label" for="owner_id">
                    {{ trans('validation.attributes.owner_id') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-address-book fa-fw "></span>
                    </div>
                    <input type="search" class="form-control" id="search_owner" name="search_owner" minlength="1"
                        maxlength="50"
                        placeholder="{{ trans('index.ex') }} {{ trans('page.contact') }} / {{ trans('page.property') }}"
                        wire:keydown.enter.prevent="owners" wire:model="search_owner" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">

                    <button type="button" class="btn btn-primary" wire:click.prevent="owners"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="owners">
                            <span class="fas fa-search fa-fw"></span>
                            <span class="d-none d-sm-inline">{{ trans('index.search') }}</span>
                        </span>
                        <span wire:loading wire:target="owners" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span>
                            <span class="d-none d-sm-inline">{{ trans('index.search') }}</span>
                        </span>
                    </button>
                </div>
                <div class="form-text">
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 50,
                </div>
                <div class="form-text">
                    {{ trans('field.name') }},
                    {{ trans('field.phone') }},
                    {{ trans('field.email') }},
                    {{ trans('page.property') }} {{ trans('field.code') }},
                    {{ trans('page.property') }} {{ trans('field.name') }},
                </div>
                @error('form.owner_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror

                @if ($this->search_owner)
                    <div class="d-grid gap-3 mt-3">
                        @forelse ($this->owners() as $owner)
                            <div class="card card-body pointer" wire:click="selectOwner({{ $owner->id }})">
                                <div class="row g-2">
                                    <div class="col-lg-7">
                                        <span class="fas fa-user fa-fw"></span>
                                        <span>{{ $owner->name }}</span>
                                    </div>
                                    <div class="col-lg-5">
                                        <span class="fas fa-phone fa-fw"></span>
                                        <span>{{ $owner->phone ?: '-' }}</span>
                                    </div>
                                    <div class="col-lg-7">
                                        <span class="fas fa-envelope fa-fw"></span>
                                        <span>{{ $owner->email ?: '-' }}</span>
                                    </div>
                                    <div class="col-lg-5">
                                        <span class="fas fa-building fa-fw"></span>
                                        {{ $owner->properties->pluck('code')->join(', ') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-danger">
                                {{ trans('message.no_data_available') }}
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            @if (!$this->search_owner)
                <div>
                    <label class="form-label" for="owner_name">
                        {{ trans('property.owner_name') }}
                    </label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="fas fa-user fa-fw "></span>
                        </div>
                        <input type="text" class="form-control {{ $form->owner_id ? 'disabled' : '' }}"
                            id="owner_name" name="owner_name" minlength="1" maxlength="50"
                            placeholder="{{ trans('index.ex') }} John Doe" {{ $form->owner_id ? 'disabled' : '' }}
                            wire:model="owner_name" wire:offline.class="disabled" wire:offline.attr="disabled"
                            wire:loading.class="disabled" wire:loading.attr="disabled">
                    </div>
                    <div class="form-text">
                        {{ trans('helper.minlength') }} : 1,
                        {{ trans('helper.maxlength') }} : 50
                    </div>
                    @error('form.owner_name')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="owner_phone">
                        {{ trans('property.owner_phone') }}
                        @if (!$this->owner_email)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="fas fa-phone fa-fw "></span>
                        </div>
                        <input type="tel" class="form-control {{ $form->owner_id ? 'disabled' : '' }}"
                            id="owner_phone" name="owner_phone" minlength="1" maxlength="20"
                            placeholder="{{ trans('index.ex') }} 62821234567890"
                            {{ $form->owner_id ? 'disabled' : '' }} wire:model.lazy="owner_phone"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                    </div>
                    <div class="form-text">
                        {{ trans('helper.minlength') }} : 1,
                        {{ trans('helper.maxlength') }} : 20
                    </div>
                    @error('form.owner_phone')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="owner_email">
                        {{ trans('property.owner_email') }}
                        @if (!$this->owner_phone)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="fas fa-envelope fa-fw "></span>
                        </div>
                        <input type="email" class="form-control {{ $form->owner_id ? 'disabled' : '' }}"
                            id="owner_email" name="owner_email" minlength="1" maxlength="50"
                            placeholder="{{ trans('index.ex') }} info@solivingbali.com"
                            {{ $form->owner_id ? 'disabled' : '' }} wire:model.lazy="owner_email"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                    </div>
                    <div class="form-text">
                        {{ trans('helper.minlength') }} : 1,
                        {{ trans('helper.maxlength') }} : 50
                    </div>
                    @error('form.owner_email')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                @if (!$form->owner_id)
                    <button type="button" class="btn btn-primary w-100" wire:click.prevent="ownerSubmit"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="ownerSubmit">
                            <span class="fas fa-save fa-fw"></span>
                            {{ trans('index.save') }}
                        </span>
                        <span wire:loading wire:target="ownerSubmit" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span>
                            {{ trans('index.save') }}
                        </span>
                    </button>
                @endif
            @endif
        </div>
    </div>

    <div class="col-sm-6">
        <div class="d-grid gap-3">
            <div>
                <label class="form-label" for="owner_representative_id">
                    {{ trans('validation.attributes.owner_representative_id') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-address-book fa-fw "></span>
                    </div>
                    <input type="search" class="form-control" id="search_owner_representative"
                        name="search_owner_representative" minlength="1" maxlength="50"
                        placeholder="{{ trans('index.ex') }} {{ trans('page.contact') }} / {{ trans('page.property') }}"
                        wire:keydown.enter.prevent="ownerRepresentatives" wire:model="search_owner_representative"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">

                    <button type="button" class="btn btn-primary" wire:click.prevent="ownerRepresentatives"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="ownerRepresentatives">
                            <span class="fas fa-search fa-fw"></span>
                            <span class="d-none d-sm-inline">{{ trans('index.search') }}</span>
                        </span>
                        <span wire:loading wire:target="ownerRepresentatives" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span>
                            <span class="d-none d-sm-inline">{{ trans('index.search') }}</span>
                        </span>
                    </button>
                </div>
                <div class="form-text">
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 50,
                </div>
                <div class="form-text">
                    {{ trans('field.name') }},
                    {{ trans('field.phone') }},
                    {{ trans('field.email') }},
                    {{ trans('page.property') }} {{ trans('field.code') }},
                    {{ trans('page.property') }} {{ trans('field.name') }},
                </div>
                @error('form.owner_representative_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror

                @if ($this->search_owner_representative)
                    <div class="d-grid gap-3 mt-3">
                        @forelse ($this->ownerRepresentatives() as $ownerRepresentative)
                            <div class="card card-body pointer"
                                wire:click="selectOwnerRepresentative({{ $ownerRepresentative->id }})">
                                <div class="row g-2">
                                    <div class="col-lg-7">
                                        <span class="fas fa-user fa-fw"></span>
                                        <span>{{ $ownerRepresentative->name }}</span>
                                    </div>
                                    <div class="col-lg-5">
                                        <span class="fas fa-phone fa-fw"></span>
                                        <span>{{ $ownerRepresentative->phone ?: '-' }}</span>
                                    </div>
                                    <div class="col-lg-7">
                                        <span class="fas fa-envelope fa-fw"></span>
                                        <span>{{ $ownerRepresentative->email ?: '-' }}</span>
                                    </div>
                                    <div class="col-lg-5">
                                        <span class="fas fa-building fa-fw"></span>
                                        {{ $ownerRepresentative->properties->pluck('code')->join(', ') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-danger">
                                {{ trans('message.no_data_available') }}
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            @if (!$this->search_owner_representative)
                <div>
                    <label class="form-label" for="owner_representative_name">
                        {{ trans('property.owner_representative_name') }}
                        <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="fas fa-user fa-fw "></span>
                        </div>
                        <input type="text"
                            class="form-control {{ $form->owner_representative_id ? 'disabled' : '' }}"
                            id="owner_representative_name" name="owner_representative_name" minlength="1"
                            maxlength="50" placeholder="{{ trans('index.ex') }} John Doe"
                            {{ $form->owner_representative_id ? 'disabled' : '' }}
                            wire:model="owner_representative_name" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    </div>
                    <div class="form-text">
                        {{ trans('helper.minlength') }} : 1,
                        {{ trans('helper.maxlength') }} : 50
                    </div>
                    @error('form.owner_representative_name')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="owner_representative_phone">
                        {{ trans('property.owner_representative_phone') }}
                        @if (!$this->owner_representative_email)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="fas fa-phone fa-fw "></span>
                        </div>
                        <input type="tel"
                            class="form-control {{ $form->owner_representative_id ? 'disabled' : '' }}"
                            id="owner_representative_phone" name="owner_representative_phone" minlength="1"
                            maxlength="20" placeholder="{{ trans('index.ex') }} 62821234567890"
                            {{ $form->owner_representative_id ? 'disabled' : '' }}
                            wire:model.lazy="owner_representative_phone" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    </div>
                    <div class="form-text">
                        {{ trans('helper.minlength') }} : 1,
                        {{ trans('helper.maxlength') }} : 20
                    </div>
                    @error('form.owner_representative_phone')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="owner_representative_email">
                        {{ trans('property.owner_representative_email') }}
                        @if (!$this->owner_representative_phone)
                            <span class="text-danger">*</span>
                        @endif
                    </label>
                    <div class="input-group">
                        <div class="input-group-text">
                            <span class="fas fa-envelope fa-fw "></span>
                        </div>
                        <input type="email"
                            class="form-control {{ $form->owner_representative_id ? 'disabled' : '' }}"
                            id="owner_representative_email" name="owner_representative_email" minlength="1"
                            maxlength="50" placeholder="{{ trans('index.ex') }} info@solivingbali.com"
                            {{ $form->owner_representative_id ? 'disabled' : '' }}
                            wire:model.lazy="owner_representative_email" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    </div>
                    <div class="form-text">
                        {{ trans('helper.minlength') }} : 1,
                        {{ trans('helper.maxlength') }} : 50
                    </div>
                    @error('form.owner_representative_email')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                @if (!$form->owner_representative_id)
                    <button type="button" class="btn btn-primary w-100"
                        wire:click.prevent="ownerRepresentativeSubmit" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="ownerRepresentativeSubmit">
                            <span class="fas fa-save fa-fw"></span>
                            {{ trans('index.save') }}
                        </span>
                        <span wire:loading wire:target="ownerRepresentativeSubmit" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span>
                            {{ trans('index.save') }}
                        </span>
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>
