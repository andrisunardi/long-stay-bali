@props([
    'minPrice' => 0,
    'maxPrice' => 0,
])

<div>
    <label class="form-label">
        <span class="fas fa-tags fa-fw"></span>
        {{ trans('home.search.price') }}
    </label>
    <div class="input-group">
        <button type="button" class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown">
            {{ Str::idr($minPrice) }} - {{ Str::idr($maxPrice) }}
        </button>

        <div class="dropdown-menu w-100 mt-2 p-4" wire:ignore.self>
            <div class="row g-3">
                <div class="col-6">
                    <label class="form-label" for="min_price">
                        {{ trans('home.search.minimum_price') }}
                    </label>
                    <input type="range" class="form-range" id="min_price" name="min_price" min="0"
                        max="100000000000" value="{{ $minPrice }}" step="1000000"
                        wire:model.live.debounce.500ms="min_price">
                    <output for="min_price">{{ Str::idr($minPrice) }}</output>
                </div>

                <div class="col-6">
                    <label class="form-label" for="max_price">
                        {{ trans('home.search.maximum_price') }}
                    </label>
                    <input type="range" class="form-range" id="max_price" name="max_price" min="0"
                        max="100000000000" value="{{ $maxPrice }}" step="1000000"
                        wire:model.live.debounce.500ms="max_price">
                    <output for="max_price">{{ Str::idr($maxPrice) }}</output>
                </div>
            </div>
        </div>
    </div>
</div>
