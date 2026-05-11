<div class="sticky-top bg-body" style="top: 3.5rem;">
    <div class="d-flex overflow-auto flex-nowrap gap-3 py-3 mb-3 border-bottom">
        @foreach ($this->propertyTabs() as $propertyTab)
            <button type="button"
                class="btn btn-outline-primary text-nowrap icon-link {{ $propertyTab->value == $tab ? 'active' : '' }}"
                wire:click="changeTab({{ $propertyTab->value }})" wire:offline.class="disabled"
                wire:offline.attr="disabled" wire:loading.class="disabled" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="changeTab({{ $propertyTab->value }})">
                    <span class="{{ $propertyTab->icon() }}"></span>
                    {{ $propertyTab->description() }}
                </span>
                <span wire:loading wire:target="changeTab({{ $propertyTab->value }})" class="w-100">
                    <span class="spinner-border spinner-border-sm"></span>
                    {{ $propertyTab->description() }}
                </span>
            </button>
        @endforeach
    </div>
</div>
