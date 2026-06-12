<?php

namespace App\Livewire\Forms\CMS\Standard;

use App\Models\Standard;
use App\Services\StandardService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StandardEditForm extends Form
{
    public Standard $standard;

    public string $title = '';

    public string $title_id = '';

    public string $title_zh = '';

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

    public function set(Standard $standard): void
    {
        $this->standard = $standard;
        $this->title = $standard->title;
        $this->title_id = $standard->title_id;
        $this->title_zh = $standard->title_zh;
        $this->title_fr = $standard->title_fr;
        $this->description = $standard->description;
        $this->description_id = $standard->description_id;
        $this->description_zh = $standard->description_zh;
        $this->description_fr = $standard->description_fr;
        $this->is_active = $standard->is_active;
    }

    public function rules(): array
    {
        return [
            'title' => "required|string|min:1|max:50|unique:standards,title,{$this->standard->id}",
            'title_id' => "required|string|min:1|max:50|unique:standards,title_id,{$this->standard->id}",
            'title_zh' => "required|string|min:1|max:50|unique:standards,title_zh,{$this->standard->id}",
            'title_fr' => "required|string|min:1|max:50|unique:standards,title_fr,{$this->standard->id}",
        ];
    }

    public function submit(Standard $standard): Standard
    {
        return (new StandardService)->update(standard: $standard, data: $this->validate());
    }
}
