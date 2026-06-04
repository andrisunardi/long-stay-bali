@props([
    'prices' => [],
    'min' => 0,
    'max' => 0,
])

<div>
    <label class="form-label">
        <span class="fas fa-tags fa-fw"></span>
        {{ trans('home.search.price') }}
    </label>
    <div class="input-group">
        <button type="button" class="btn d-flex justify-content-between align-items-center border w-100 dropdown-toggle"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" data-bs-display="static">
            {{ isset($prices['min']) ? Str::thousand($prices['min']) : 0 }}
            -
            {{ isset($prices['max']) ? Str::thousand($prices['max']) : 0 }}
        </button>

        <div class="dropdown-menu w-100 mt-3 p-3" wire:ignore.self>
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

            <div wire:ignore class="px-2">
                <div id="price-slider"></div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-6">
                    <label class="form-label" for="price_min">
                        {{ trans('home.search.from') }}
                    </label>

                    <input type="number" class="form-control form-control-sm" id="price_min" name="price_min"
                        min="{{ $priceMin }}" max="{{ $priceMax }}" value="{{ $prices['min'] ?? 0 }}"
                        step="1000000" wire:model.live.debounce.5s="prices.min">
                </div>

                <div class="col-6">
                    <label class="form-label" for="price_max">
                        {{ trans('home.search.to') }}
                    </label>

                    <input type="number" class="form-control form-control-sm" id="price_max" name="price_max"
                        min="{{ $priceMin }}" max="{{ $priceMax }}" value="{{ $prices['max'] ?? 0 }}"
                        step="1000000" wire:model.live.debounce.5s="prices.max">
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        function priceSlider() {
            const priceSlider = document.getElementById('price-slider');

            if (priceSlider) {
                if (priceSlider.noUiSlider) {
                    priceSlider.noUiSlider.destroy();
                }

                noUiSlider.create(priceSlider, {
                    start: [
                        @js($prices['min'] ?? $priceMin),
                        @js($prices['max'] ?? $priceMax),
                    ],
                    connect: true,
                    step: 1000000,
                    range: {
                        min: {{ $priceMin }},
                        max: {{ $priceMax }},
                    },
                    tooltips: [false, false],
                });

                priceSlider.noUiSlider.on('change', (values) => {
                    $wire.set('prices.min', parseInt(values[0]));
                    $wire.set('prices.max', parseInt(values[1]));
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
