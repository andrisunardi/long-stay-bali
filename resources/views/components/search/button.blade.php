@props([
    'districts' => $districts,
    'areas' => $areas,
    'bedrooms' => $bedrooms,
    'livingStyle' => $livingStyle,
    'prices' => $prices,
])

<a draggable="false"
    href="{{ route('property.index', [
        'districts' => $districts,
        'areas' => $areas,
        'bedrooms' => $bedrooms,
        'living_style' => $livingStyle,
        'prices' => $prices,
    ]) }}"
    class="btn btn-success w-100 rounded-5" wire:navigate>
    <span class="fas fa-search fa-fw"></span>
    {{ trans('search.button') }}
</a>
