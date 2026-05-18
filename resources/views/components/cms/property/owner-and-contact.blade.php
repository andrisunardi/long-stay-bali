<div class="row">
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
                    <select class="form-select select2-delete" id="owner_id" name="owner_id"
                        wire:model.lazy="form.owner_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                        <option value="">
                            {{ trans('index.select') }}
                            {{ trans('validation.attributes.owner_id') }}
                        </option>
                        @foreach ($this->contacts() as $contact)
                            <option value="{{ $contact->id }}" wire:key="contact-{{ $contact->id }}">
                                {{ $contact->name }} - {{ $contact->phone }} - {{ $contact->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('form.owner_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="owner_name">
                    {{ trans('property.owner_name') }}
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-user fa-fw "></span>
                    </div>
                    <input type="text" class="form-control {{ $form->owner_id ? 'disabled' : '' }}" id="owner_name"
                        name="owner_name" minlength="1" maxlength="50" placeholder="{{ trans('index.ex') }} John Doe"
                        {{ $form->owner_id ? 'disabled' : '' }} wire:model="owner_name" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }},
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
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-phone fa-fw "></span>
                    </div>
                    <input type="tel" class="form-control {{ $form->owner_id ? 'disabled' : '' }}" id="owner_phone"
                        name="owner_phone" minlength="1" maxlength="20"
                        placeholder="{{ trans('index.ex') }} 62821234567890" {{ $form->owner_id ? 'disabled' : '' }}
                        wire:model="owner_phone" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }},
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
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-envelope fa-fw "></span>
                    </div>
                    <input type="email" class="form-control {{ $form->owner_id ? 'disabled' : '' }}" id="owner_email"
                        name="owner_email" minlength="1" maxlength="50"
                        placeholder="{{ trans('index.ex') }} solivingbali@gmail.com"
                        {{ $form->owner_id ? 'disabled' : '' }} wire:model="owner_email" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }},
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 20
                </div>
                @error('form.owner_email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            @if (!$form->owner_id)
                <button type="button" class="btn btn-primary w-100" wire:click="ownerSubmit"
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
                    <select class="form-select select2-delete" id="owner_representative_id"
                        name="owner_representative_id" wire:model.lazy="form.owner_representative_id"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                        <option value="">
                            {{ trans('index.select') }}
                            {{ trans('validation.attributes.owner_representative_id') }}
                        </option>
                        @foreach ($this->contacts() as $contact)
                            <option value="{{ $contact->id }}" wire:key="contact-{{ $contact->id }}">
                                {{ $contact->name }} - {{ $contact->phone }} - {{ $contact->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('form.owner_representative_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="owner_representative_name">
                    {{ trans('property.owner_representative_name') }}
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-user fa-fw "></span>
                    </div>
                    <input type="text" class="form-control {{ $form->owner_representative_id ? 'disabled' : '' }}"
                        id="owner_representative_name" name="owner_representative_name" minlength="1"
                        maxlength="50" placeholder="{{ trans('index.ex') }} John Doe"
                        {{ $form->owner_representative_id ? 'disabled' : '' }} wire:model="owner_representative_name"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }},
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
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-phone fa-fw "></span>
                    </div>
                    <input type="tel" class="form-control {{ $form->owner_representative_id ? 'disabled' : '' }}"
                        id="owner_representative_phone" name="owner_representative_phone" minlength="1"
                        maxlength="20" placeholder="{{ trans('index.ex') }} 62821234567890"
                        {{ $form->owner_representative_id ? 'disabled' : '' }} wire:model="owner_representative_phone"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }},
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
                    <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-envelope fa-fw "></span>
                    </div>
                    <input type="email" class="form-control {{ $form->owner_representative_id ? 'disabled' : '' }}"
                        id="owner_representative_email" name="owner_representative_email" minlength="1"
                        maxlength="50" placeholder="{{ trans('index.ex') }} solivingbali@gmail.com"
                        {{ $form->owner_representative_id ? 'disabled' : '' }} wire:model="owner_representative_email"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }},
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 20
                </div>
                @error('form.owner_representative_email')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            @if (!$form->owner_representative_id)
                <button type="button" class="btn btn-primary w-100" wire:click="ownerSubmit"
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
        </div>
    </div>
</div>
