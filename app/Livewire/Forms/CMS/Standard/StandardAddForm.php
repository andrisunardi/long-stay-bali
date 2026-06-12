<?php

namespace App\Livewire\Forms\CMS\Standard;

use App\Models\Standard;
use App\Services\StandardService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StandardAddForm extends Form
{
    #[Validate('required|string|min:1|max:50|unique:standards,title')]
    public string $title = '';

    #[Validate('required|string|min:1|max:50|unique:standards,title_id')]
    public string $title_id = '';

    #[Validate('required|string|min:1|max:50|unique:standards,title_zh')]
    public string $title_zh = '';

    #[Validate('required|string|min:1|max:50|unique:standards,title_fr')]
    public string $title_fr = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $description = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $description_id = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $description_zh = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $description_fr = '';

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function submit(): Standard
    {
        return (new StandardService)->create(data: $this->validate());
    }
}
