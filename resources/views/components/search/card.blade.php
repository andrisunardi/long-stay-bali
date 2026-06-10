@props([
    'area' => null,
    'bedrooms' => [],
    'livingStyle' => null,
])

<div class="card card-body">
    <a draggable="false" class="pointer text-body" data-bs-toggle="modal" data-bs-target="#modal-search">
        <div class="row align-items-center">
            <div class="col-auto">
                <span class="fas fa-search fa-fw"></span>
            </div>
            <div class="col">
                <div class="fw-bold">
                    {{ $area ?: trans('index.all') . ' ' . trans('index.area') }}
                </div>
                <div>
                    <span class="fas fa-bed fa-fw"></span>
                    @if ($bedrooms)
                        {{ collect($bedrooms)->map(fn($bedroom) => PropertyBedroom::from($bedroom)->description())->join(', ') }}
                    @else
                        {{ trans('index.all') }}
                    @endif
                    <span> | </span>
                    <span class="fas fa-couch fa-fw"></span>
                    @if ($livingStyle)
                        {{ PropertyLivingStyle::from($livingStyle)->translate() }}
                    @else
                        {{ trans('index.all') }}
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>
