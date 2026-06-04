<?php

namespace App\Livewire\Forms\CMS\Area;

use App\Models\Area;
use App\Services\AreaService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AreaAddForm extends Form
{
    #[Validate('required|integer|exists:districts,id')]
    public ?int $district_id = null;

    public string $name = '';

    #[Validate('required|boolean')]
    public bool $is_promoted = true;

    #[Validate('required|boolean')]
    public bool $is_show = true;

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:1',
                'max:50',
                Rule::unique('areas', 'name')
                    ->where(
                        fn ($query) => $query->where('district_id', $this->district_id)
                    ),
            ],
        ];
    }

    public function submit(): Area
    {
        return (new AreaService)->create(data: $this->validate());
    }
}
