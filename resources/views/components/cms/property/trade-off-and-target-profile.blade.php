<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="trade_off_identified">
            {{ trans('property.trade_off_identified') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="trade_off_identified"
                name="trade_off_identified" value="1" {{ $form->trade_off_identified ? 'checked' : '' }}
                wire:model.lazy="form.trade_off_identified" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->trade_off_identified ? 'success' : 'danger' }}"
                for="trade_off_identified">
                {{ $form->trade_off_identified ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.trade_off_identified')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    @if ($form->trade_off_identified)
        <div class="col-sm-6">
            <label class="form-label" for="trade_off_description">
                {{ trans('property.if_yes_describe_briefly') }}
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <span class="fas fa-comment fa-fw "></span>
                </div>
                <input type="text" class="form-control" id="trade_off_description" name="trade_off_description"
                    minlength="1" maxlength="100" placeholder="{{ trans('index.ex') . '. Limited Parkind / No Pool' }}"
                    wire:model="form.trade_off_description" wire:offline.class="disabled" wire:offline.attr="disabled"
                    wire:loading.class="disabled" wire:loading.attr="disabled">
            </div>
            <div class="form-text">
                {{ trans('helper.minlength') }} : 1,
                {{ trans('helper.maxlength') }} : 100
            </div>
            @error('form.trade_off_description')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    @endif

    <div class="col-sm-6">
        <label class="form-label" for="target_profiles">
            {{ trans('property.target_profiles') }}
        </label>
        <div>
            @foreach ($this->propertyTargetProfiles() as $propertyTargetProfile)
                <div class="form-check form-check-inline"
                    wire:key="target-profiles-{{ $propertyTargetProfile->value }}">
                    <input class="form-check-input" type="checkbox"
                        id="target_profiles_{{ $propertyTargetProfile->value }}" name="target_profiles"
                        value="{{ $propertyTargetProfile->value }}"
                        {{ $propertyTargetProfile->value == $form->target_profiles ? 'checked' : '' }}
                        wire:model.lazy="form.target_profiles" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label class="form-check-label" for="target_profiles_{{ $propertyTargetProfile->value }}">
                        {{ $propertyTargetProfile->description() }}
                    </label>
                </div>
            @endforeach
        </div>
        @error('form.target_profiles')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
