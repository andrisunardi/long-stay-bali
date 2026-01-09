<?php

namespace App\Livewire;

use Livewire\Component as LivewireComponent;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Component extends LivewireComponent
{
    use WithFileUploads;
    use WithPagination;
}
