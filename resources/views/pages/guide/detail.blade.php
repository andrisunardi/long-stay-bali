<?php

use App\Livewire\Component;
use App\Models\Guide;
use App\Services\GuideService;
use Livewire\Attributes\Title;

new #[Title('Guide')] class extends Component {
    public Guide $guide;

    public function mount(string $slug): void
    {
        $service = new GuideService();
        $this->guide = $service->detail(slug: $slug);
        $this->guide->loadMissing(['category']);
    }
};
?>

@section('title', $guide->translate_title)

<div class="py-5 mt-4">
    <x-guide.content :guide="$guide" />

    <livewire:guide.another />
</div>
