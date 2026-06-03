<?php

namespace App\Livewire\Forms\CMS\Guide;

use App\Models\Guide;
use App\Services\GuideService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GuideEditForm extends Form
{
    public Guide $guide;

    #[Validate('required|integer|exists:guide_categories,id')]
    public ?int $guide_category_id = null;

    public string $title = '';

    public string $title_id = '';

    public string $title_zh = '';

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

    public function set(Guide $guide): void
    {
        $this->guide = $guide;
        $this->guide_category_id = $guide->guide_category_id;
        $this->title = $guide->title;
        $this->title_id = $guide->title_id;
        $this->title_zh = $guide->title_zh;
        $this->title_fr = $guide->title_fr;
        $this->body = $guide->body;
        $this->body_id = $guide->body_id;
        $this->body_zh = $guide->body_zh;
        $this->body_fr = $guide->body_fr;
        $this->is_show = $guide->is_show;
        $this->is_active = $guide->is_active;
    }

    public function rules(): array
    {
        return [
            'title' => "required|string|min:1|max:200|unique:guides,title,{$this->guide->id}",
            'title_id' => "nullable|string|min:1|max:200|unique:guides,title_id,{$this->guide->id}",
            'title_zh' => "nullable|string|min:1|max:200|unique:guides,title_zh,{$this->guide->id}",
            'title_fr' => "nullable|string|min:1|max:200|unique:guides,title_fr,{$this->guide->id}",
        ];
    }

    public function submit(Guide $guide): Guide
    {
        return (new GuideService)->update(guide: $guide, data: $this->validate());
    }
}
