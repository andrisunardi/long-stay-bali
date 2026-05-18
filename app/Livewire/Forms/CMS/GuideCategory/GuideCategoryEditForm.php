<?php

namespace App\Livewire\Forms\CMS\GuideCategory;

use App\Models\GuideCategory;
use App\Services\GuideCategoryService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GuideCategoryEditForm extends Form
{
    public GuideCategory $guideCategory;

    public string $name = '';

    public string $name_id = '';

    public string $name_zh = '';

    public string $name_fr = '';

    #[Validate('required|boolean')]
    public bool $is_show = true;

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function set(GuideCategory $guideCategory): void
    {
        $this->guideCategory = $guideCategory;
        $this->name = $guideCategory->name;
        $this->name_id = $guideCategory->name_id;
        $this->name_zh = $guideCategory->name_zh;
        $this->name_fr = $guideCategory->name_fr;
        $this->is_show = $guideCategory->is_show;
        $this->is_active = $guideCategory->is_active;
    }

    public function rules(): array
    {
        return [
            'name' => "required|string|min:1|max:50|unique:guide_categories,name,{$this->guideCategory->id}",
            'name_id' => "required|string|min:1|max:50|unique:guide_categories,name_id,{$this->guideCategory->id}",
            'name_zh' => "required|string|min:1|max:50|unique:guide_categories,name_zh,{$this->guideCategory->id}",
            'name_fr' => "required|string|min:1|max:50|unique:guide_categories,name_fr,{$this->guideCategory->id}",
        ];
    }

    public function submit(GuideCategory $guideCategory): GuideCategory
    {
        return (new GuideCategoryService)->update(guideCategory: $guideCategory, data: $this->validate());
    }
}
