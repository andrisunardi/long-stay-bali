<?php

use App\Livewire\Component;
use App\Models\Guide;
use App\Services\GuideService;
use Livewire\Attributes\Title;

new #[Title('Guide')] class extends Component {
    public Guide $guide;

    public function mount(): void
    {
        $service = new GuideService();
        $this->guide = $service->latest();
        $this->guide->loadMissing(['category']);
    }
};
?>

@section('title', trans('page.guide'))

<div class="py-5 mt-4">
    <x-guide.content :guide="$guide" />

    {{-- <x-guide.another /> --}}
</div>
