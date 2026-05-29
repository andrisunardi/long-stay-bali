@props([
    'prices' => [],
    'monthlyMin' => 0,
    'monthlyMax' => 0,
    'yearlyMin' => 0,
    'yearlyMax' => 0,
])

{{-- @php
    $budget_type = $prices['budget_type'] ?? null;
    $price = match ($budget_type) {
        1 => $prices['monthly'] ?? [],
        2 => $prices['yearly'] ?? [],
        default => [],
    };

    $hasPrice = filled($price['min'] ?? null) || filled($price['max'] ?? null);

    $label = match ($budget_type) {
        1 => trans('index.monthly'),
        2 => trans('index.yearly'),
        default => null,
    };
@endphp --}}

<div>
    <label class="form-label">
        <span class="fas fa-tags fa-fw"></span>
        {{ trans('home.search.price') }}
    </label>
    <div class="input-group">
        <button type="button" class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown" data-bs-auto-close="outside">
            {{-- {{ Str::abbreviate($minPrice) }} - {{ Str::abbreviate($maxPrice) }} --}}
            {{-- @if ($hasPrice)
                {{ $label }}
                {{ Str::abbreviate($price['min'] ?? 0) }}
                -
                {{ Str::abbreviate($price['max'] ?? 0) }}
            @else
                {{ trans('index.all') }}
            @endif --}}
            @if (isset($prices['budget_type']) && $prices['budget_type'] == BudgetType::Monthly->value)
                {{ trans('index.monthly') }}
                {{ isset($prices['monthly']['min']) ? Str::abbreviate($prices['monthly']['min']) : 0 }}
                -
                {{ isset($prices['monthly']['max']) ? Str::abbreviate($prices['monthly']['max']) : 0 }}
            @elseif (isset($prices['budget_type']) && $prices['budget_type'] == BudgetType::Yearly->value)
                {{ trans('index.yearly') }}
                {{ isset($prices['yearly']['min']) ? Str::abbreviate($prices['yearly']['min']) : 0 }}
                -
                {{ isset($prices['yearly']['max']) ? Str::abbreviate($prices['yearly']['max']) : 0 }}
            @else
                {{ trans('index.all') }}
            @endif
        </button>

        <div class="dropdown-menu w-100 mt-2 p-3" wire:ignore.self>
            <div class="d-flex justify-content-between">
                <div>
                    <h5>{{ trans('home.search.price_title') }}</h5>
                    <p>{{ trans('home.search.price_description') }}</p>
                </div>
                <div>
                    <a draggable="false" role="button" wire:click="clearAllPrice">
                        {{ trans('home.search.clear_all') }}
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-4 col-sm-3">
                    <button type="button"
                        class="btn btn-outline-success btn-sm w-100 rounded-pill {{ !isset($prices['budget_type']) ? 'active' : '' }}"
                        wire:click="changeBudgetType" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                        {{ trans('index.all') }}
                    </button>
                </div>

                @foreach (BudgetType::cases() as $budgetType)
                    <div class="col-4 col-sm-3">
                        <button type="button"
                            class="btn btn-outline-success btn-sm w-100 rounded-pill {{ isset($prices['budget_type']) && $budgetType->value == $prices['budget_type'] ? 'active' : '' }}"
                            wire:click="changeBudgetType({{ $budgetType->value }})" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            {{ $budgetType->translate() }}
                        </button>
                    </div>
                @endforeach
            </div>

            <hr />

            @if (isset($prices['budget_type']) && $prices['budget_type'] == BudgetType::Monthly->value)
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="min_price">
                            {{ trans('home.search.minimum_price') }}
                        </label>
                        <input type="range" class="form-range" id="min_price" name="min_price" min="0"
                            max="{{ $monthlyMin }}"
                            value="{{ isset($prices['monthly']['min']) ? Str::idr($prices['monthly']['min']) : 0 }}"
                            step="1000000" wire:model.live.debounce.500ms="prices.monthly.min">
                        <output for="min_price">
                            {{ isset($prices['monthly']['min']) ? Str::idr($prices['monthly']['min']) : 0 }}
                        </output>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="max_price">
                            {{ trans('home.search.maximum_price') }}
                        </label>
                        <input type="range" class="form-range" id="max_price" name="max_price" min="0"
                            max="{{ $monthlyMax }}"
                            value="{{ isset($prices['monthly']['max']) ? Str::idr($prices['monthly']['max']) : 0 }}"
                            step="1000000" wire:model.live.debounce.500ms="prices.monthly.max">
                        <output for="max_price">
                            {{ isset($prices['monthly']['max']) ? Str::idr($prices['monthly']['max']) : 0 }}
                        </output>
                    </div>
                </div>
            @endif

            @if (isset($prices['budget_type']) && $prices['budget_type'] == BudgetType::Yearly->value)
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="min_price">
                            {{ trans('home.search.minimum_price') }}
                        </label>
                        <input type="range" class="form-range" id="min_price" name="min_price" min="0"
                            max="{{ $yearlyMin }}"
                            value="{{ isset($prices['yearly']['min']) ? Str::idr($prices['yearly']['min']) : 0 }}"
                            step="1000000" wire:model.live.debounce.500ms="prices.yearly.min">
                        <output for="min_price">
                            {{ isset($prices['yearly']['min']) ? Str::idr($prices['yearly']['min']) : 0 }}
                        </output>
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="max_price">
                            {{ trans('home.search.maximum_price') }}
                        </label>
                        <input type="range" class="form-range" id="max_price" name="max_price" min="0"
                            max="{{ $yearlyMax }}"
                            value="{{ isset($prices['yearly']['max']) ? Str::idr($prices['yearly']['max']) : 0 }}"
                            step="1000000" wire:model.live.debounce.500ms="prices.yearly.max">
                        <output for="max_price">
                            {{ isset($prices['yearly']['max']) ? Str::idr($prices['yearly']['max']) : 0 }}
                        </output>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
