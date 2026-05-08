@props([
    'idArea' => null,
    'searchArea' => null,
    'areas' => collect(),
])

<div>
    <label class="form-label">
        <span class="fas fa-location-dot fa-fw"></span>
        {{ trans('home.search.area') }}
    </label>
    <div class="input-group">
        @if ($idArea)
            <div class="form-control bg-secondary-subtle">
                {{ $searchArea }}
            </div>

            <button type="button" class="btn border" wire:key="removeArea" wire:click="removeArea"
                wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="removeArea">
                    <span class="fas fa-times fa-fw"></span>
                </span>
                <span wire:loading wire:target="removeArea" class="w-100">
                    <span class="spinner-border spinner-border-sm"></span>
                </span>
            </button>
        @else
            <div class="{{ $idArea ? '' : 'position-relative w-100' }}">
                <input type="text" id="search_area" name="search_area" class="form-control" minlength="1"
                    maxlength="50" placeholder="{{ trans('home.search.area_placeholder') }}" data-bs-toggle="dropdown"
                    wire:model.live.debounce.500ms="search_area" wire:offline.class="disabled"
                    wire:offline.attr="disabled">

                <ul class="dropdown-menu {{ $searchArea ? 'show' : '' }} w-100 mt-3">
                    <li>
                        <small class="dropdown-header text-muted">
                            {{ trans('home.search.area_title') }}
                        </small>
                    </li>
                    @forelse ($areas as $area)
                        <li class="border-top border-bottom py-1" wire:key="area-{{ $area->id }}">
                            <button type="button" class="dropdown-item text-wrap icon-link"
                                wire:click="changeArea({{ $area->id }})">
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
