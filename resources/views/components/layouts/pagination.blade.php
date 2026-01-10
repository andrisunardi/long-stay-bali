@if ($paginator->hasPages())
    <div class="d-flex justify-content-between align-items-center">
        <div>
            @if ($paginator->onFirstPage())
                <button type="button" class="btn btn-primary disabled" disabled>
                    <span class="fa fa-chevron-left fa-fw"></span>
                </button>
            @else
                <button type="button" class="btn btn-primary" wire:click="previousPage">
                    <span class="fa fa-chevron-left fa-fw"></span>
                </button>
            @endif
        </div>
        <div class="text-center">
            <div>
                {{ trans('pagination.showing') }}
                <span class="fw-bold">{{ $paginator->firstItem() }}</span>
                {{ trans('pagination.to') }}
                <span class="fw-bold">{{ $paginator->lastItem() }}</span>
            </div>
            <div>
                {{ trans('pagination.total') }}
                <span class="fw-bold">{{ $paginator->total() }}</span>
                {{ trans('pagination.data') }}
            </div>
        </div>
        <div>
            @if ($paginator->hasMorePages())
                <button type="button" class="btn btn-primary" wire:click="nextPage">
                    <span class="fa fa-chevron-right fa-fw"></span>
                </button>
            @else
                <button type="button" class="btn btn-primary disabled" disabled>
                    <span class="fa fa-chevron-right fa-fw"></span>
                </button>
            @endif
        </div>
    </div>
@endif
