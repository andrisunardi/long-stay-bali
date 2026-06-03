<?php

namespace App\Livewire\Forms\CMS\Guide;

use App\Models\Guide;
use App\Services\GuideService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GuideAddForm extends Form
{
    #[Validate('required|integer|exists:guide_categories,id')]
    public ?int $guide_category_id = null;

    #[Validate('required|string|min:1|max:200|unique:guides,title')]
    public string $title = '';

    #[Validate('nullable|string|min:1|max:200|unique:guides,title_id')]
    public string $title_id = '';

    #[Validate('nullable|string|min:1|max:200|unique:guides,title_zh')]
    public string $title_zh = '';

    #[Validate('nullable|string|min:1|max:200|unique:guides,title_fr')]
    public string $title_fr = '';

    #[Validate('required|string|min:1|max:65535')]
    public string $body = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public string $body_id = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public string $body_zh = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public string $body_fr = '';

    #[Validate(['nullable', 'array', 'min:0'])]
    public array $image = [];

    #[Validate('required|boolean')]
    public bool $is_show = true;

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function submit(): Guide
    {
        return (new GuideService)->create(data: $this->validate());
    }
}
