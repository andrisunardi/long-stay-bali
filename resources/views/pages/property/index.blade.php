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
    public ?string $start_date = null;

    #[Url(except: null)]
    public ?string $end_date = null;

    #[Url(except: null)]
    public int $min_price = 0;

    #[Url(except: null)]
    public int $max_price = 100000000000;

    public function mount(): void
    {
        $this->start_date = $this->start_date ?? today()->toDateString();
        $this->end_date = $this->end_date ?? today()->toDateString();
    }

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
    :start-date="$start_date"
    :end-date="$end_date"
    :min-price="$min_price"
    :max-price="$max_price"
    lazy />
</div>
