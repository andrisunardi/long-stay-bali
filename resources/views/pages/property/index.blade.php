<?php

use App\Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Property')] class extends Component {};
?>

@section('title', trans('page.property'))

<div>
    <livewire:property.list lazy />
</div>
