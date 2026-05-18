<?php

namespace App\Livewire\Forms\CMS\GuideCategory;

use App\Models\GuideCategory;
use App\Services\GuideCategoryService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GuideCategoryAddForm extends Form
{
    #[Validate('required|string|min:1|max:50|unique:guide_categories,name')]
    public string $name = '';

    #[Validate('required|string|min:1|max:50|unique:guide_categories,name_id')]
    public string $name_id = '';

    #[Validate('required|string|min:1|max:50|unique:guide_categories,name_zh')]
    public string $name_zh = '';

    #[Validate('required|string|min:1|max:50|unique:guide_categories,name_fr')]
    public string $name_fr = '';

    #[Validate('required|boolean')]
    public bool $is_show = true;

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function submit(): GuideCategory
    {
        return (new GuideCategoryService)->create(data: $this->validate());
    }
}
