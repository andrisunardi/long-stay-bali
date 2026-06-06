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
        <button type="button" data-area-dropdown
            class="btn d-flex justify-content-between align-items-center border w-100 text-truncate dropdown-toggle"
            data-bs-toggle="dropdown" data-bs-auto-close="outside" data-bs-display="static">
            @if ($area)
                {{ $area }}
            @else
                {{ trans('index.all') }}
            @endif
        </button>

        <div class="dropdown-menu w-100 mt-3 p-3">
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
                    @php
                        $areaIds = $listDistrict->areas->pluck('id')->all();
                        $selectedCount = count(array_intersect($areaIds, $areas));
                        $isChecked = in_array($listDistrict->id, $districts);
                        $isIndeterminate = !$isChecked && $selectedCount > 0 && $selectedCount < count($areaIds);
                    @endphp

                    <div class="form-check">
                        <input class="form-check-input district-checkbox" type="checkbox"
                            value="{{ $listDistrict->id }}" id="district-{{ $listDistrict->id }}" name="districts"
                            @checked($isChecked)
                            @if ($isIndeterminate) data-indeterminate="true" @endif
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

<script>
    function applyIndeterminateCheckboxes() {
        document
            .querySelectorAll('.district-checkbox')
            .forEach((el) => {
                el.indeterminate = false
            })

        document
            .querySelectorAll('[data-indeterminate="true"]')
            .forEach((el) => {
                el.indeterminate = true
            })
    }

    document.addEventListener('livewire:init', () => {
        applyIndeterminateCheckboxes()
        Livewire.hook('morph.updated', () => {
            applyIndeterminateCheckboxes()
        })
    })
</script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('keep-area-dropdown-open', () => {
            document.querySelectorAll('[data-area-dropdown]').forEach(el => {
                const dropdown =
                    bootstrap.Dropdown.getInstance(el) ??
                    new bootstrap.Dropdown(el)
                dropdown.show()
            })
        })
    });
</script>
