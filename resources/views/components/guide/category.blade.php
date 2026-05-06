<?php

use App\Livewire\Component;
use App\Services\GuideCategoryService;
use App\Services\GuideService;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public object $guideCategories;

    public ?int $guide_category_id = null;

    public function mount(): void
    {
        $service = new GuideCategoryService();
        $this->guideCategories = $service->index(isShow: [true], isActive: [true], limit: 10, paginate: false);
    }

    public function setGuideCategoryId(?int $id = null): void
    {
        $this->guide_category_id = $id;
        $this->dispatch('guide-category-id-selected', id: $id);
    }
};
?>

@placeholder
    <div class="row g-3">
        @for ($i = 0; $i < 3; $i++)
            <div class="col-4 col-lg-3 col-xl-2 placeholder-glow" wire:key="news-category-{{ $i }}">
                <div class="btn btn-outline-success text-nowrap rounded-pill placeholder col-12 "></div>
            </div>
        @endfor
    </div>
@endplaceholder

<div class="d-flex overflow-auto flex-nowrap border-bottom gap-3 mb-3 pb-3">
    <button type="button"
        class="btn btn-outline-success text-nowrap rounded-pill {{ !$guide_category_id ? 'active' : '' }}"
        wire:click="setGuideCategoryId" wire:offline.class="disabled" wire:offline.attr="disabled"
        wire:loading.class="disabled" wire:loading.attr="disabled">
        {{ trans('home.guides.all_category') }}
    </button>

    @foreach ($guideCategories as $guideCategory)
        <button type="button"
            class="btn btn-outline-success text-nowrap rounded-pill {{ $guideCategory->id == $guide_category_id ? 'active' : '' }}"
            wire:key="guide-category-{{ $guideCategory->id }}" wire:click="setGuideCategoryId({{ $guideCategory->id }})"
            wire:offline.class="disabled" wire:offline.attr="disabled" wire:loading.class="disabled"
            wire:loading.attr="disabled">
            {{ $guideCategory->translate_name }}
        </button>
    @endforeach
</div>
