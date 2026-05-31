@props([
    'area' => '',
    'districts' => [],
    'areas' => [],
    'districts' => collect(),
])

<div>
    <label class="form-label">
        <span class="fas fa-location-dot fa-fw"></span>
        {{ trans('home.search.area') }}
    </label>
    <div class="input-group">
        <button type="button" class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown" data-bs-auto-close="outside">
            @if ($area)
                {{ $area }}
            @else
                {{ trans('index.all') }}
            @endif
        </button>

        <div class="dropdown-menu w-100 my-2 p-3" wire:ignore.self>
            <div class="d-flex justify-content-between">
                <div>
                    <h5>{{ trans('home.search.area_title') }}</h5>
                    <p>{{ trans('home.search.area_description') }}</p>
                </div>
                <div>
                    <a draggable="false" class="text-muted text-nowrap" role="button" wire:click="clearAllArea">
                        {{ trans('home.search.clear_all') }}
                    </a>
                </div>
            </div>

            <div>
                @foreach ($listDistricts as $listDistrict)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $listDistrict->id }}"
                            id="district-{{ $listDistrict->id }}" name="districts" @checked(in_array($listDistrict->id, $districts))
                            wire:model.lazy="districts" wire:offline.class="disabled" wire:offline.attr="disabled"
                            wire:loading.class="disabled" wire:loading.attr="disabled">
                        <label class="form-check-label" for="district-{{ $listDistrict->id }}">
                            {{ $listDistrict->name }}
                        </label>
                    </div>

                    @foreach ($listDistrict->areas as $listArea)
                        <div class="form-check ms-4">
                            <input class="form-check-input" type="checkbox" value="{{ $listArea->id }}"
                                id="area-{{ $listArea->id }}" name="areas" @checked(in_array($listArea->id, $areas))
                                wire:model.lazy="areas" wire:offline.class="disabled" wire:offline.attr="disabled"
                                wire:loading.class="disabled" wire:loading.attr="disabled">
                            <label class="form-check-label" for="area-{{ $listArea->id }}">
                                {{ $listArea->name }}
                            </label>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
