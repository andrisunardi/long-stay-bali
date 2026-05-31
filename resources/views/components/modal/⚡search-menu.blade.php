<?php

use App\Livewire\Component;

new class extends Component {
    public string $search = '';

    public ?int $menu_id = null;

    public function mount(): void
    {
        $route = request()->route()?->getName();
        $page = collect($this->menus())->pluck('pages')->flatten(1)->firstWhere('route', $route);

        if ($page) {
            $this->menu_id = $page['menu_id'] ?? null;
        }
    }

    public function changeMenuCategoryId(?int $id = null): void
    {
        $this->menu_id = $id;
    }

    public function updatedSearch(): void
    {
        $this->menu_id = null;
    }
};
?>

<div class="modal fade" id="modal-search-menu" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">
                    <span class="fas fa-search fa-fw"></span>
                    Search Menu
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">
                <div class="form-floating">
                    <input type="search" class="form-control border-0 no-border-focus" id="search" name="search"
                        minlength="1" maxlength="50" autofocus wire:model.lazy="search" wire:offline.class="disabled"
                        wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    <label for="search" class="form-label">
                        Enter To Search Menu / Category
                    </label>
                </div>

                <div class="d-flex overflow-auto flex-nowrap border-top border-bottom gap-3 p-3">
                    <button type="button"
                        class="btn btn-outline-primary btn-md w-auto text-nowrap {{ !$menu_id ? 'active' : '' }}"
                        wire:click="changeMenuCategoryId" wire:offline.class="disabled" wire:offline.attr="disabled"
                        wire:loading.class="disabled" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="changeMenuCategoryId">
                            <span class="fas fa-list fa-fw"></span> All Menu Category
                        </span>
                        <span wire:loading wire:target="changeMenuCategoryId" class="w-100">
                            <span class="spinner-border spinner-border-sm"></span> All Menu Category
                        </span>
                    </button>

                    @foreach ($this->menus() as $menu)
                        <button type="button"
                            class="btn btn-outline-primary btn-md w-auto text-nowrap {{ $menu['id'] == $menu_id ? 'active' : '' }}"
                            wire:key="menu-category-{{ $menu['id'] }}"
                            wire:click="changeMenuCategoryId({{ $menu['id'] }})" wire:offline.class="disabled"
                            wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="changeMenuCategoryId({{ $menu['id'] }})">
                                <span class="{{ $menu['icon'] }} fa-fw"></span> {{ $menu['name'] }}
                            </span>
                            <span wire:loading wire:target="changeMenuCategoryId({{ $menu['id'] }})" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span> {{ $menu['name'] }}
                            </span>
                        </button>
                    @endforeach
                </div>

                <div class="list-group list-group-flush">
                    @foreach ($this->menus() as $menu)
                        @foreach (collect($menu['pages'])->when($this->menu_id, fn($menu) => $menu->where('menu_id', $this->menu_id)) as $page)
                            @can($page['permission'])
                                <a draggable="false" href="{{ route($page['route']) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ Route::is($page['route']) ? 'active' : '' }}"
                                    wire:key="menu-{{ $menu['id'] }}-page-{{ $page['id'] }}" wire:navigate>
                                    <span>
                                        <span class="{{ $page['icon'] }} fa-fw"></span>
                                        <span>{{ $page['name'] }}</span>
                                    </span>
                                    <span
                                        class="badge {{ Route::is($page['route']) ? 'bg-light text-primary' : 'bg-primary' }} rounded-pill">
                                        {{ $menu['name'] }}
                                    </span>
                                </a>
                            @endcan
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
