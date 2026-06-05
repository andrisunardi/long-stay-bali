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

                    <input type="text" class="form-control form-control-sm autonumeric" id="price_min"
                        name="price_min" min="{{ $priceMin }}" max="{{ $priceMax }}"
                        value="{{ $prices['min'] ?? 0 }}" step="1000000">
                </div>

                <div class="col-6">
                    <label class="form-label" for="price_max">
                        {{ trans('home.search.to') }}
                    </label>

                    <input type="text" class="form-control form-control-sm autonumeric" id="price_max"
                        name="price_max" min="{{ $priceMin }}" max="{{ $priceMax }}"
                        value="{{ $prices['max'] ?? 0 }}" step="1000000">
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        function autoNumericInit() {
            const $min = $("#price_min");
            const $max = $("#price_max");

            if ($min.length) {
                if ($min[0].autoNumeric) {
                    $min.autoNumeric("destroy");
                }

                $min.autoNumeric("init", {
                    aSep: ".",
                    aDec: ",",
                    mDec: "0"
                });

                $min.off("input keyup").on("input keyup", function() {
                    const raw = $(this).val().replace(/\./g, '');
                    @this.set('prices.min', parseInt(raw || 0));
                });
            }

            if ($max.length) {
                if ($max[0].autoNumeric) {
                    $max.autoNumeric("destroy");
                }

                $max.autoNumeric("init", {
                    aSep: ".",
                    aDec: ",",
                    mDec: "0"
                });

                $max.off("input keyup").on("input keyup", function() {
                    const raw = $(this).val().replace(/\./g, '');
                    @this.set('prices.max', parseInt(raw || 0));
                });
            }
        }

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
                    const min = parseInt(values[0]);
                    const max = parseInt(values[1]);

                    $wire.set('prices.min', min);
                    $wire.set('prices.max', max);

                    const priceMin = $("#price_min");
                    if (priceMin.length && priceMin.data('autoNumeric')) {
                        priceMin.autoNumeric("set", min);
                    }

                    const priceMax = $("#price_max");
                    if (priceMax.length && priceMax.data('autoNumeric')) {
                        priceMax.autoNumeric("set", max);
                    }
                });
            }
        }

        autoNumericInit();
        priceSlider();

        document.addEventListener('livewire:navigated', () => {
            queueMicrotask(() => {
                autoNumericInit();
                priceSlider();
            });
        });

        window.addEventListener('price-slider', () => {
            queueMicrotask(() => {
                autoNumericInit();
                priceSlider();
            });
        });
    </script>
@endscript
