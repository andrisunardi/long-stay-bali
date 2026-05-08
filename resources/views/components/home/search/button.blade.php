@props([
    'id_area' => $areaId,
    'bedroom' => $bedroom,
    'min_price' => $minPrice,
    'max_price' => $maxPrice,
])

<a draggable="false"
    href="{{ route('property.index', [
        'area_id' => $areaId,
        'bedroom' => $bedroom,
        'min_price' => $minPrice,
        'max_price' => $maxPrice,
    ]) }}"
    class="btn btn-success w-100 rounded-5" wire:navigate>
    <span class="fas fa-search fa-fw"></span>
    {{ trans('home.search.button') }}
</a>
