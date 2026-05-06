<nav class="navbar bg-body-tertiary fixed-top border-bottom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="d-flex align-items-center text-truncate">
                <button class="btn me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar">
                    <span class="fas fa-bars fa-fw"></span>
                </button>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="navbar">
                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title">
                            {{ trans('index.navigation_menu') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">
                        <livewire:navigation />
                    </div>
                </div>

                <a draggable="false" class="navbar-brand" href="{{ route('cms.home') }}" wire:navigate>
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="d-flex gap-1">
                <button type="button" class="btn icon-link" data-bs-toggle="modal" data-bs-target="#modal-search-menu">
                    <span class="fas fa-search fa-fw"></span>
                    <span class="d-none d-sm-inline">{{ trans('index.search_menu') }}</span>
                </button>

                <livewire:network />

                <livewire:profile />
            </div>
        </div>
    </div>
</nav>
