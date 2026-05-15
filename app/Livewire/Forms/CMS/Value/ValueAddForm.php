<?php

namespace App\Livewire\Forms\CMS\Value;

use App\Models\Value;
use App\Services\ValueService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ValueAddForm extends Form
{
    #[Validate('required|string|min:1|max:50|unique:values,title')]
    public string $title = '';

    #[Validate('required|string|min:1|max:50|unique:values,title_id')]
    public string $title_id = '';

    #[Validate('required|string|min:1|max:50|unique:values,title_zh')]
    public string $title_zh = '';

    #[Validate('required|string|min:1|max:50|unique:values,title_fr')]
    public string $title_fr = '';

    #[Validate('required|string|min:1|max:100')]
    public string $short_description = '';

    #[Validate('required|string|min:1|max:100')]
    public string $short_description_id = '';

    #[Validate('required|string|min:1|max:100')]
    public string $short_description_zh = '';

    #[Validate('required|string|min:1|max:100')]
    public string $short_description_fr = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $description = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $description_id = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $description_zh = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $description_fr = '';

    #[Validate('required|string|min:1|max:50')]
    public string $icon = '';

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function submit(): Value
    {
        return (new ValueService)->create(data: $this->validate());
    }
}
