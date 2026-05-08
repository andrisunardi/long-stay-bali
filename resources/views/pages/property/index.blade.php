<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

new #[Title('Property')] class extends Component {
    #[Url(except: null)]
    public ?int $area_id = null;

    public string $search_area = '';

    #[Url(except: null)]
    public ?int $bedroom = null;

    #[Url(except: null)]
    public int $min_price = 0;

    #[Url(except: null)]
    public int $max_price = 100000000000;
};
?>

@section('title', trans('page.property'))

<div>
    {{-- prettier-ignore --}}
    <livewire:property.list
    :area-id="$area_id"
    :bedroom="$bedroom"
    :min-price="$min_price"
    :max-price="$max_price"
    lazy />
</div>
