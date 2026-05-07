<div class="row g-3 mb-3">
    <div class="col-sm-6">
        {{-- <div class="rounded h-100" id="map" wire:ignore></div> --}}
        <div>
            <label class="form-label" for="google_maps_url">
                {{-- {{ trans('validation.attributes.google_maps_url') }} --}}
                Google Maps URL
            </label>
            <div class="input-group">
                <div class="input-group-text">
                    <span class="fas fa-globe fa-fw "></span>
                </div>
                <textarea class="form-control" rows="5" id="google_maps_url" name="google_maps_url"
                    placeholder="{{ trans('index.ex') }} " wire:model="form.google_maps_url" wire:offline.class="disabled"
                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled"></textarea>
            </div>
            <div class="form-text">
                {{ trans('helper.required') }}
            </div>
            @error('form.google_maps_url')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-sm-6">
        <div class="d-grid gap-3">
            <div>
                <label class="form-label" for="latitude">
                    {{ trans('validation.attributes.latitude') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-globe fa-fw "></span>
                    </div>
                    <input type="text" class="form-control" id="latitude" name="latitude"
                        placeholder="{{ trans('index.ex') . '. -8.6648246' }}" wire:model="form.latitude"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }}
                </div>
                @error('form.latitude')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="longitude">
                    {{ trans('validation.attributes.longitude') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-globe fa-fw "></span>
                    </div>
                    <input type="text" class="form-control" id="longitude" name="longitude"
                        placeholder="{{ trans('index.ex') . '. -8.6648246' }}" wire:model="form.longitude"
                        wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                        wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.required') }}
                </div>
                @error('form.longitude')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="address">
                    {{ trans('property.address') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-map-location-dot fa-fw "></span>
                    </div>
                    <input type="text" class="form-control" id="address" name="address" minlength="1"
                        maxlength="100" placeholder="{{ trans('index.ex') . '. Jalan Raya Canggu I No 1' }}"
                        wire:model="form.address" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                </div>
                <div class="form-text">
                    {{ trans('helper.minlength') }} : 1,
                    {{ trans('helper.maxlength') }} : 200
                </div>
                @error('form.address')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="district_id">
                    {{ trans('validation.attributes.district_id') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-city fa-fw "></span>
                    </div>
                    <select class="form-select select2" id="district_id" name="district_id" wire:key="form.district_id"
                        wire:model.lazy="district_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                        <option value="">
                            {{ trans('index.select') }}
                            {{ trans('validation.attributes.district_id') }}
                        </option>
                        @foreach ($this->districts() as $district)
                            <option value="{{ $district->id }}" wire:key="district-{{ $district->id }}">
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('form.district_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-label" for="area_id">
                    {{ trans('validation.attributes.area_id') }}
                </label>
                <div class="input-group">
                    <div class="input-group-text">
                        <span class="fas fa-archway fa-fw "></span>
                    </div>
                    <select class="form-select select2" id="area_id" name="area_id" wire:key="form.area_id"
                        wire:model.lazy="area_id" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                        <option value="">
                            {{ trans('index.select') }} {{ trans('validation.attributes.area_id') }}
                        </option>
                        @foreach ($this->areas() as $area)
                            <option value="{{ $area->id }}" wire:key="area-{{ $area->id }}">
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('form.area_id')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
