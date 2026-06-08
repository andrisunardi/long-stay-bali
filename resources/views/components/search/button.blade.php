@props([
    'districts' => [],
    'areas' => [],
    'bedrooms' => [],
    'livingStyle' => null,
    'rentalType' => null,
    'prices' => [],
])

<a draggable="false"
    href="{{ route('property.index', [
        'districts' => $districts,
        'areas' => $areas,
        'bedrooms' => $bedrooms,
        'living_style' => $livingStyle,
        'rental_type' => $rentalType,
        'prices' => $prices,
    ]) }}"
    class="btn btn-success w-100 rounded-5" wire:navigate>
    <span class="fas fa-search fa-fw"></span>
    {{ trans('home.search.button') }}
</a>
