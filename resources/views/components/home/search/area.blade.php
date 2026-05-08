@props([
    'idArea' => null,
    'searchArea' => null,
    'areas' => collect(),
])

<div>
    <label class="form-label">
        <span class="fas fa-location-dot fa-fw"></span>
        {{ trans('validation.attributes.area') }}
        <span class="text-danger">*</span>
    </label>
    <div class="input-group">
        @if ($idArea)
            <input type="text" id="search_area" name="search_area" class="form-control disabled"
                value="{{ $searchArea }}" disabled>

            <button type="button" class="btn border" wire:key="removeArea" wire:click="removeArea"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
                <span class="fas fa-times fa-fw"></span>
            </button>
        @else
            <div class="{{ $idArea ? '' : 'position-relative w-100' }}">
                <input type="search" id="search_area" name="search_area" class="form-control" minlength="1"
                    maxlength="50" placeholder="{{ trans('home.form.area') }}" required
                    wire:model.live.debounce.500ms="search_area" data-bs-toggle="dropdown">

                <ul class="dropdown-menu {{ $searchArea ? 'show' : '' }} w-100 mt-2">
                    <li>
                        <h6 class="dropdown-header">
                            {{ trans('home.form.area') }}
                        </h6>
                    </li>
                    @forelse ($areas as $area)
                        <li wire:key="area-{{ $area->id }}">
                            <button type="button" class="dropdown-item" wire:click="changeArea({{ $area->id }})">
                                <span class="fas fa-location-dot fa-fw"></span>
                                {{ $area->name }}, {{ $area->district?->name ?? '-' }}
                            </button>
                        </li>
                    @empty
                        <li>
                            <h6 class="dropdown-header">
                                {{ trans('message.no_data_available') }}
                            </h6>
                        </li>
                    @endforelse
                </ul>
            </div>
        @endif
    </div>
</div>
