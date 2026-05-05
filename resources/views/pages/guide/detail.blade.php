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

@section('title', trans('page.guide'))

<div>
    {{-- <x-guide.content :content="$content" /> --}}
</div>
