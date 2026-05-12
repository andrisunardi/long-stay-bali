<div class="row g-3 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="design_driven_property">
            {{ trans('property.design_driven_property') }}
        </label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="design_driven_property"
                name="design_driven_property" value="1" {{ $form->design_driven_property ? 'checked' : '' }}
                wire:model.lazy="form.design_driven_property" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
            <label class="form-check-label text-{{ $form->design_driven_property ? 'success' : 'danger' }}"
                for="design_driven_property">
                {{ $form->design_driven_property ? trans('index.yes') : trans('index.no') }}
            </label>
        </div>
        @error('form.design_driven_property')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-6">
        <label class="form-label" for="usability_limitations">
            {{ trans('property.usability_limitations_identified') }}
        </label>
        <div class="input-group">
            <div class="input-group-text">
                <span class="fas fa-comment fa-fw "></span>
            </div>
            <input type="text" class="form-control" id="usability_limitations" name="usability_limitations"
                minlength="1" maxlength="100"
                placeholder="{{ trans('index.ex') . '. Construction Noise / Road Noise' }}"
                wire:model="form.usability_limitations" wire:offline.class="disabled" wire:offline.attr="disabled"
                wire:loading.class="disabled" wire:loading.attr="disabled">
        </div>
        <div class="form-text">
            {{ trans('helper.minlength') }} : 1,
            {{ trans('helper.maxlength') }} : 100
        </div>
        @error('form.usability_limitations')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
