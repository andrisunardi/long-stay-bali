@props([
    'prices' => [],
    'monthlyMin' => 0,
    'monthlyMax' => 0,
    'yearlyMin' => 0,
    'yearlyMax' => 0,
])

<div>
    <label class="form-label">
        <span class="fas fa-tags fa-fw"></span>
        {{ trans('home.search.price') }}
    </label>
    <div class="input-group">
        <button type="button" class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown" data-bs-auto-close="outside">
            @isset($prices['budget_type'])
                @if ($prices['budget_type'] == BudgetType::Monthly->value)
                    {{ trans('index.monthly') }} :
                    {{ isset($prices['monthly']['min']) ? Str::abbreviate($prices['monthly']['min']) : 0 }}
                    -
                    {{ isset($prices['monthly']['max']) ? Str::abbreviate($prices['monthly']['max']) : 0 }}
                @elseif ($prices['budget_type'] == BudgetType::Yearly->value)
                    {{ trans('index.yearly') }} :
                    {{ isset($prices['yearly']['min']) ? Str::abbreviate($prices['yearly']['min']) : 0 }}
                    -
                    {{ isset($prices['yearly']['max']) ? Str::abbreviate($prices['yearly']['max']) : 0 }}
                @endif
            @else
                {{ trans('index.all') }}
            @endisset
        </button>

        <div class="dropdown-menu w-100 my-2 p-3" wire:ignore.self>
            <div class="d-flex justify-content-between">
                <div>
                    <h5>{{ trans('home.search.price_title') }}</h5>
                    <p>{{ trans('home.search.price_description') }}</p>
                </div>
                <div>
                    <a draggable="false" class="text-muted text-nowrap" role="button" wire:click="clearAllPrice">
                        {{ trans('home.search.clear_all') }}
                    </a>
                </div>
            </div>

            @if (isset($prices['budget_type']) && $prices['budget_type'] == BudgetType::Monthly->value)
                <div wire:ignore class="px-2">
                    <div id="monthly-slider"></div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <label class="form-label" for="monthly_min">
                            {{ trans('home.search.from') }}
                        </label>

                        <input type="number" class="form-control form-control-sm" id="monthly_min" name="monthly_min"
                            min="{{ $monthlyMin }}" max="{{ $monthlyMax }}"
                            value="{{ $prices['monthly']['min'] ?? 0 }}" step="1000000"
                            wire:model.live.debounce.5s="prices.monthly.min">
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="monthly_max">
                            {{ trans('home.search.to') }}
                        </label>

                        <input type="number" class="form-control form-control-sm" id="monthly_max" name="monthly_max"
                            min="{{ $monthlyMin }}" max="{{ $monthlyMax }}"
                            value="{{ $prices['monthly']['max'] ?? 0 }}" step="1000000"
                            wire:model.live.debounce.5s="prices.monthly.max">
                    </div>
                </div>
            @endif

            @if (isset($prices['budget_type']) && $prices['budget_type'] == BudgetType::Yearly->value)
                <div wire:ignore class="px-2 mt-4">
                    <div id="yearly-slider"></div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <label class="form-label" for="yearly_min">
                            {{ trans('home.search.from') }}
                        </label>

                        <input type="number" class="form-control form-control-sm" id="yearly_min" name="yearly_min"
                            min="{{ $yearlyMin }}" max="{{ $yearlyMax }}"
                            value="{{ $prices['yearly']['min'] ?? 0 }}" step="1000000"
                            wire:model.live.debounce.5s="prices.yearly.min">
                    </div>

                    <div class="col-6">
                        <label class="form-label" for="yearly_max">
                            {{ trans('home.search.to') }}
                        </label>

                        <input type="number" class="form-control form-control-sm" id="yearly_max" name="yearly_max"
                            min="{{ $yearlyMin }}" max="{{ $yearlyMax }}"
                            value="{{ $prices['yearly']['max'] ?? 0 }}" step="1000000"
                            wire:model.live.debounce.5s="prices.yearly.max">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@script
    <script>
        function priceSlider() {
            const monthlySlider = document.getElementById('monthly-slider');

            if (monthlySlider) {
                if (monthlySlider.noUiSlider) {
                    monthlySlider.noUiSlider.destroy();
                }

                noUiSlider.create(monthlySlider, {
                    start: [
                        @js($prices['monthly']['min'] ?? $monthlyMin),
                        @js($prices['monthly']['max'] ?? $monthlyMax),
                    ],
                    connect: true,
                    step: 1000000,
                    range: {
                        min: {{ $monthlyMin }},
                        max: {{ $monthlyMax }},
                    },
                    tooltips: [false, false],
                });

                monthlySlider.noUiSlider.on('change', (values) => {
                    $wire.set('prices.monthly.min', parseInt(values[0]));
                    $wire.set('prices.monthly.max', parseInt(values[1]));
                });
            }

            const yearlySlider = document.getElementById('yearly-slider');

            if (yearlySlider) {
                if (yearlySlider.noUiSlider) {
                    yearlySlider.noUiSlider.destroy();
                }

                noUiSlider.create(yearlySlider, {
                    start: [
                        @js($prices['yearly']['min'] ?? $yearlyMin),
                        @js($prices['yearly']['max'] ?? $yearlyMax),
                    ],
                    connect: true,
                    step: 1000000,
                    range: {
                        min: {{ $yearlyMin }},
                        max: {{ $yearlyMax }},
                    },
                    tooltips: [false, false],
                });

                yearlySlider.noUiSlider.on('change', (values) => {
                    $wire.set('prices.yearly.min', parseInt(values[0]));
                    $wire.set('prices.yearly.max', parseInt(values[1]));
                });
            }
        }

        priceSlider();

        document.addEventListener('livewire:navigated', () => {
            queueMicrotask(() => {
                priceSlider();
            });
        });

        window.addEventListener('price-slider', () => {
            queueMicrotask(() => {
                priceSlider();
            });
        });
    </script>
@endscript
