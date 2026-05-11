@props([
    'folders' => null,
])

<nav>
    <ol class="breadcrumb text-nowrap">
        @if (!count($folders))
            <li class="breadcrumb-item active">
                <span class="fas fa-home fa-fw"></span>
                {{ trans('page.home') }}
            </li>
        @else
            <li class="breadcrumb-item">
                <a draggable="false" role="button" class="text-body" wire:click="home" wire:offline.class="disabled"
                    wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="home">
                        <span class="fas fa-home fa-fw"></span>
                        {{ trans('page.home') }}
                    </span>
                    <span wire:loading wire:target="home" class="w-100">
                        <span class="spinner-border spinner-border-sm"></span>
                        {{ trans('page.home') }}
                    </span>
                </a>
            </li>
            @foreach ($folders as $key => $folder)
                @if ($loop->last)
                    <li class="breadcrumb-item active" wire:key="folder-{{ $key }}">
                        <span class="fas fa-folder-open fa-fw"></span>
                        {{ $folder['name'] }}
                    </li>
                @else
                    <li class="breadcrumb-item" wire:key="folder-{{ $key }}">
                        <a draggable="false" role="button" class="text-body" wire:click="goTo({{ $key }})"
                            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="goTo({{ $key }})">
                                <span class="fas fa-folder fa-fw"></span>
                                {{ $folder['name'] }}
                            </span>
                            <span wire:loading wire:target="goTo({{ $key }})" class="w-100">
                                <span class="spinner-border spinner-border-sm"></span>
                                {{ $folder['name'] }}
                            </span>
                        </a>
                    </li>
                @endif
            @endforeach
        @endif
    </ol>
</nav>
