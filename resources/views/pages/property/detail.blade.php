<?php

use App\Livewire\Component;
use App\Models\Property;
use App\Services\PropertyService;
use Livewire\Attributes\Title;

new #[Title('Property Detail')] class extends Component {
    public ?Property $property = null;

    public function mount(string $slug): void
    {
        $service = new PropertyService();
        $this->property = $service->detail(slug: $slug);

        if (!$this->property) {
            abort(404);
        }

        $this->property->loadMissing(['area', 'image']);
    }
};
?>

@section('title', $property->name)

<div>
    <x-property.detail :property="$property" />
</div>
