<div>
    @if ($form->rental_type)
        <div class="row g-3">
            @if (in_array($form->rental_type, [PropertyRentalType::Monthly->value, PropertyRentalType::Both->value]))
                <div class="col-sm-6">
                    <div class="d-grid gap-3">
                        <div>
                            <label class="form-label" for="monthly_price">
                                {{ trans('property.monthly_price') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-rupiah-sign fa-fw "></span>
                                </div>
                                <input type="number" class="form-control" id="monthly_price" name="monthly_price"
                                    min="0" max="100000000000" placeholder="{{ trans('index.ex') }}" required
                                    wire:model="form.monthly_price" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                {{ trans('helper.required') }},
                                {{ trans('helper.min') }} : 0,
                                {{ trans('helper.max') }} : 100.000.000.000
                            </div>
                            @error('form.monthly_price')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-auto">
                                <label class="form-label" for="monthly_inclusions_housekeeper">
                                    {{ trans('property.housekeeper') }}
                                </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="monthly_inclusions_housekeeper" name="monthly_inclusions_housekeeper"
                                        value="1" {{ $form->monthly_inclusions['housekeeper'] ? 'checked' : '' }}
                                        wire:model.lazy="form.monthly_inclusions.housekeeper"
                                        wire:offline.class="disabled" wire:offline.attr="disabled"
                                        wire:loading.class="disabled" wire:loading.attr="disabled">
                                    <label
                                        class="form-check-label text-{{ $form->monthly_inclusions['housekeeper'] ? 'success' : 'danger' }}"
                                        for="monthly_inclusions_housekeeper">
                                        {{ Str::yesNo($form->monthly_inclusions['housekeeper']) }}
                                    </label>
                                </div>
                                @error('form.monthly_inclusions.housekeeper')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($form->monthly_inclusions['housekeeper'])
                                <div class="col">
                                    <label class="form-label" for="monthly_inclusions_housekeeper_frequency_per_week">
                                        {{ trans('property.frequency_per_week') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <span class="fas fa-calendar-week fa-fw "></span>
                                        </div>
                                        <input type="number" class="form-control"
                                            id="monthly_inclusions_housekeeper_frequency_per_week"
                                            name="monthly_inclusions_housekeeper_frequency_per_week" min="1"
                                            max="255" placeholder="{{ trans('index.ex') }} 4" required
                                            wire:model="form.monthly_inclusions.housekeeper_frequency_per_week"
                                            wire:offline.class="disabled" wire:offline.attr="disabled"
                                            wire:loading.class="disabled" wire:loading.attr="disabled">
                                    </div>
                                    <div class="form-text">
                                        {{ trans('helper.required') }},
                                        {{ trans('helper.min') }} : 1,
                                        {{ trans('helper.max') }} : 255
                                    </div>
                                    @error('form.monthly_inclusions.housekeeper_frequency_per_week')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="form-label" for="monthly_inclusions_gardener">
                                {{ trans('property.gardener') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="monthly_inclusions_gardener" name="monthly_inclusions_gardener" value="1"
                                    {{ $form->monthly_inclusions['gardener'] ? 'checked' : '' }}
                                    wire:model.lazy="form.monthly_inclusions.gardener" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->monthly_inclusions['gardener'] ? 'success' : 'danger' }}"
                                    for="monthly_inclusions_gardener">
                                    {{ Str::yesNo($form->monthly_inclusions['gardener']) }}
                                </label>
                            </div>
                            @error('form.monthly_inclusions.gardener')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="monthly_inclusions_pool_guy">
                                {{ trans('property.pool_guy') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="monthly_inclusions_pool_guy" name="monthly_inclusions_pool_guy" value="1"
                                    {{ $form->monthly_inclusions['pool_guy'] ? 'checked' : '' }}
                                    wire:model.lazy="form.monthly_inclusions.pool_guy" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->monthly_inclusions['pool_guy'] ? 'success' : 'danger' }}"
                                    for="monthly_inclusions_pool_guy">
                                    {{ Str::yesNo($form->monthly_inclusions['pool_guy']) }}
                                </label>
                            </div>
                            @error('form.monthly_inclusions.pool_guy')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="monthly_inclusions_internet">
                                {{ trans('property.internet') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="monthly_inclusions_internet" name="monthly_inclusions_internet"
                                    value="1" {{ $form->monthly_inclusions['internet'] ? 'checked' : '' }}
                                    wire:model.lazy="form.monthly_inclusions.internet" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->monthly_inclusions['internet'] ? 'success' : 'danger' }}"
                                    for="monthly_inclusions_internet">
                                    {{ Str::yesNo($form->monthly_inclusions['internet']) }}
                                </label>
                            </div>
                            @error('form.monthly_inclusions.internet')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="monthly_inclusions_garbage">
                                {{ trans('property.garbage') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="monthly_inclusions_garbage" name="monthly_inclusions_garbage" value="1"
                                    {{ $form->monthly_inclusions['garbage'] ? 'checked' : '' }}
                                    wire:model.lazy="form.monthly_inclusions.garbage" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->monthly_inclusions['garbage'] ? 'success' : 'danger' }}"
                                    for="monthly_inclusions_garbage">
                                    {{ Str::yesNo($form->monthly_inclusions['garbage']) }}
                                </label>
                            </div>
                            @error('form.monthly_inclusions.garbage')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="monthly_inclusions_banjar">
                                {{ trans('property.banjar') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="monthly_inclusions_banjar" name="monthly_inclusions_banjar" value="1"
                                    {{ $form->monthly_inclusions['banjar'] ? 'checked' : '' }}
                                    wire:model.lazy="form.monthly_inclusions.banjar" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->monthly_inclusions['banjar'] ? 'success' : 'danger' }}"
                                    for="monthly_inclusions_banjar">
                                    {{ Str::yesNo($form->monthly_inclusions['banjar']) }}
                                </label>
                            </div>
                            @error('form.monthly_inclusions.banjar')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="monthly_inclusions_security">
                                {{ trans('property.security') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="monthly_inclusions_security" name="monthly_inclusions_security"
                                    value="1" {{ $form->monthly_inclusions['security'] ? 'checked' : '' }}
                                    wire:model.lazy="form.monthly_inclusions.security" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->monthly_inclusions['security'] ? 'success' : 'danger' }}"
                                    for="monthly_inclusions_security">
                                    {{ Str::yesNo($form->monthly_inclusions['security']) }}
                                </label>
                            </div>
                            @error('form.monthly_inclusions.security')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="monthly_inclusions_electricity">
                                {{ trans('property.electricity') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="monthly_inclusions_electricity" name="monthly_inclusions_electricity"
                                    value="1" {{ $form->monthly_inclusions['electricity'] ? 'checked' : '' }}
                                    wire:model.lazy="form.monthly_inclusions.electricity"
                                    wire:offline.class="disabled" wire:offline.attr="disabled"
                                    wire:loading.class="disabled" wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->monthly_inclusions['electricity'] ? 'success' : 'danger' }}"
                                    for="monthly_inclusions_electricity">
                                    {{ Str::yesNo($form->monthly_inclusions['electricity']) }}
                                </label>
                            </div>
                            @error('form.monthly_inclusions.electricity')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="form.monthly_inclusions_others">
                                {{ trans('property.others') }}
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-file-lines fa-fw "></span>
                                </div>
                                <input type="text" class="form-control" id="form.monthly_inclusions_others"
                                    name="form.monthly_inclusions_others" minlength="1" maxlength="100"
                                    wire:model="form.monthly_inclusions.others" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                {{ trans('helper.minlength') }} : 1,
                                {{ trans('helper.maxlength') }} : 100
                            </div>
                            @error('form.monthly_inclusions.others')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            @if (in_array($form->rental_type, [PropertyRentalType::Yearly->value, PropertyRentalType::Both->value]))
                <div class="col-sm-6">
                    <div class="d-grid gap-3">
                        <div>
                            <label class="form-label" for="yearly_price">
                                {{ trans('property.yearly_price') }}
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-rupiah-sign fa-fw "></span>
                                </div>
                                <input type="number" class="form-control" id="yearly_price" name="yearly_price"
                                    min="0" max="100000000000" placeholder="{{ trans('index.ex') }}" required
                                    wire:model="form.yearly_price" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                {{ trans('helper.required') }},
                                {{ trans('helper.min') }} : 0,
                                {{ trans('helper.max') }} : 100.000.000.000
                            </div>
                            @error('form.yearly_price')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="row">
                            <div class="col-auto">
                                <label class="form-label" for="yearly_inclusions_housekeeper">
                                    {{ trans('property.housekeeper') }}
                                </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="yearly_inclusions_housekeeper" name="yearly_inclusions_housekeeper"
                                        value="1" {{ $form->yearly_inclusions['housekeeper'] ? 'checked' : '' }}
                                        wire:model.lazy="form.yearly_inclusions.housekeeper"
                                        wire:offline.class="disabled" wire:offline.attr="disabled"
                                        wire:loading.class="disabled" wire:loading.attr="disabled">
                                    <label
                                        class="form-check-label text-{{ $form->yearly_inclusions['housekeeper'] ? 'success' : 'danger' }}"
                                        for="yearly_inclusions_housekeeper">
                                        {{ Str::yesNo($form->yearly_inclusions['housekeeper']) }}
                                    </label>
                                </div>
                                @error('form.yearly_inclusions.housekeeper')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($form->yearly_inclusions['housekeeper'])
                                <div class="col">
                                    <label class="form-label" for="yearly_inclusions_housekeeper_frequency_per_week">
                                        {{ trans('property.frequency_per_week') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <span class="fas fa-calendar-week fa-fw "></span>
                                        </div>
                                        <input type="number" class="form-control"
                                            id="yearly_inclusions_housekeeper_frequency_per_week"
                                            name="yearly_inclusions_housekeeper_frequency_per_week" min="1"
                                            max="255" placeholder="{{ trans('index.ex') }} 4" required
                                            wire:model="form.yearly_inclusions.housekeeper_frequency_per_week"
                                            wire:offline.class="disabled" wire:offline.attr="disabled"
                                            wire:loading.class="disabled" wire:loading.attr="disabled">
                                    </div>
                                    <div class="form-text">
                                        {{ trans('helper.required') }},
                                        {{ trans('helper.min') }} : 1,
                                        {{ trans('helper.max') }} : 255
                                    </div>
                                    @error('form.yearly_inclusions.housekeeper_frequency_per_week')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="form-label" for="yearly_inclusions_gardener">
                                {{ trans('property.gardener') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="yearly_inclusions_gardener" name="yearly_inclusions_gardener" value="1"
                                    {{ $form->yearly_inclusions['gardener'] ? 'checked' : '' }}
                                    wire:model.lazy="form.yearly_inclusions.gardener" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->yearly_inclusions['gardener'] ? 'success' : 'danger' }}"
                                    for="yearly_inclusions_gardener">
                                    {{ Str::yesNo($form->yearly_inclusions['gardener']) }}
                                </label>
                            </div>
                            @error('form.yearly_inclusions.gardener')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="yearly_inclusions_pool_guy">
                                {{ trans('property.pool_guy') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="yearly_inclusions_pool_guy" name="yearly_inclusions_pool_guy" value="1"
                                    {{ $form->yearly_inclusions['pool_guy'] ? 'checked' : '' }}
                                    wire:model.lazy="form.yearly_inclusions.pool_guy" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->yearly_inclusions['pool_guy'] ? 'success' : 'danger' }}"
                                    for="yearly_inclusions_pool_guy">
                                    {{ Str::yesNo($form->yearly_inclusions['pool_guy']) }}
                                </label>
                            </div>
                            @error('form.yearly_inclusions.pool_guy')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="yearly_inclusions_internet">
                                {{ trans('property.internet') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="yearly_inclusions_internet" name="yearly_inclusions_internet" value="1"
                                    {{ $form->yearly_inclusions['internet'] ? 'checked' : '' }}
                                    wire:model.lazy="form.yearly_inclusions.internet" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->yearly_inclusions['internet'] ? 'success' : 'danger' }}"
                                    for="yearly_inclusions_internet">
                                    {{ Str::yesNo($form->yearly_inclusions['internet']) }}
                                </label>
                            </div>
                            @error('form.yearly_inclusions.internet')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="yearly_inclusions_garbage">
                                {{ trans('property.garbage') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="yearly_inclusions_garbage" name="yearly_inclusions_garbage" value="1"
                                    {{ $form->yearly_inclusions['garbage'] ? 'checked' : '' }}
                                    wire:model.lazy="form.yearly_inclusions.garbage" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->yearly_inclusions['garbage'] ? 'success' : 'danger' }}"
                                    for="yearly_inclusions_garbage">
                                    {{ Str::yesNo($form->yearly_inclusions['garbage']) }}
                                </label>
                            </div>
                            @error('form.yearly_inclusions.garbage')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="yearly_inclusions_banjar">
                                {{ trans('property.banjar') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="yearly_inclusions_banjar" name="yearly_inclusions_banjar" value="1"
                                    {{ $form->yearly_inclusions['banjar'] ? 'checked' : '' }}
                                    wire:model.lazy="form.yearly_inclusions.banjar" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->yearly_inclusions['banjar'] ? 'success' : 'danger' }}"
                                    for="yearly_inclusions_banjar">
                                    {{ Str::yesNo($form->yearly_inclusions['banjar']) }}
                                </label>
                            </div>
                            @error('form.yearly_inclusions.banjar')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="yearly_inclusions_security">
                                {{ trans('property.security') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="yearly_inclusions_security" name="yearly_inclusions_security" value="1"
                                    {{ $form->yearly_inclusions['security'] ? 'checked' : '' }}
                                    wire:model.lazy="form.yearly_inclusions.security" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->yearly_inclusions['security'] ? 'success' : 'danger' }}"
                                    for="yearly_inclusions_security">
                                    {{ Str::yesNo($form->yearly_inclusions['security']) }}
                                </label>
                            </div>
                            @error('form.yearly_inclusions.security')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="yearly_inclusions_electricity">
                                {{ trans('property.electricity') }}
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="yearly_inclusions_electricity" name="yearly_inclusions_electricity"
                                    value="1" {{ $form->yearly_inclusions['electricity'] ? 'checked' : '' }}
                                    wire:model.lazy="form.yearly_inclusions.electricity" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                                <label
                                    class="form-check-label text-{{ $form->yearly_inclusions['electricity'] ? 'success' : 'danger' }}"
                                    for="yearly_inclusions_electricity">
                                    {{ Str::yesNo($form->yearly_inclusions['electricity']) }}
                                </label>
                            </div>
                            @error('form.yearly_inclusions.electricity')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label" for="form.yearly_inclusions_others">
                                {{ trans('property.others') }}
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span class="fas fa-file-lines fa-fw "></span>
                                </div>
                                <input type="text" class="form-control" id="form.yearly_inclusions_others"
                                    name="form.yearly_inclusions_others" minlength="1" maxlength="100"
                                    wire:model="form.yearly_inclusions.others" wire:offline.class="disabled"
                                    wire:offline.attr="disabled" wire:loading.class="disabled"
                                    wire:loading.attr="disabled">
                            </div>
                            <div class="form-text">
                                {{ trans('helper.minlength') }} : 1,
                                {{ trans('helper.maxlength') }} : 100
                            </div>
                            @error('form.yearly_inclusions.others')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-danger">
            Please Input Rental Type First
        </div>
    @endif
</div>
