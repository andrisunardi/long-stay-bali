<?php

use App\Livewire\Component;

new class extends Component {};
?>

<ul class="navbar-nav">
    <li class="nav-item">
        <a draggable="false" class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}"
            wire:navigate>
            <span class="fas fa-home fa-fw"></span>
            <span>{{ trans('page.home') }}</span>
        </a>
    </li>

    @foreach ($this->menus() as $menu)
        @canany(collect($menu['pages'])->pluck('permission')->toArray())
            <li wire:key="menu-{{ $menu['id'] }}">
                <h6 class="fw-bold text-uppercase border-bottom pb-2 mt-3">
                    <span>{{ $menu['name'] }}</span>
                </h6>
            </li>
        @endcanany

        @foreach ($menu['pages'] as $page)
            @can($page['permission'])
                <li class="nav-item" wire:key="page-{{ $page['id'] }}">
                    <a draggable="false"
                        class="nav-link {{ Route::is(Str::replace('.index', '.*', $page['route'])) ? 'active' : '' }}"
                        href="{{ route($page['route']) }}" wire:navigate>
                        <span class="{{ $page['icon'] }} fa-fw"></span>
                        <span>{{ $page['name'] }}</span>
                    </a>
                </li>
            @endcan
        @endforeach
    @endforeach
</ul>
