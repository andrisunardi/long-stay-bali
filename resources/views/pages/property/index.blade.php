<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

new #[Title('Property')] class extends Component {
    #[Url(except: null)]
    public ?int $area_id = null;

    public string $area_name = '';

    #[Url(except: null)]
    public ?int $bedroom = null;

    #[Url(except: null)]
    public int $min_price = 0;

    #[Url(except: null)]
    public int $max_price = 100000000000;

    #[On('area-changed')]
    public function changeArea(?int $id = null, string $name = ''): void
    {
        $this->area_id = $id;
        $this->area_name = $name;
    }
};
?>

@section('title', trans('page.property'))

<div>
    <livewire:property.search :area-id="$area_id" />

    <hr />

    {{-- prettier-ignore --}}
    <livewire:property.list
    :area-id="$area_id"
    :area-name="$area_name"
    :bedroom="$bedroom"
    :min-price="$min_price"
    :max-price="$max_price"
    lazy />
</div>
