<?php

namespace App\Livewire\Forms\CMS\Area;

use App\Models\Area;
use App\Services\AreaService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AreaEditForm extends Form
{
    public Area $area;

    #[Validate('required|integer|exists:districts,id')]
    public ?int $district_id = null;

    public string $name = '';

    #[Validate('required|boolean')]
    public bool $is_promoted = true;

    #[Validate('required|boolean')]
    public bool $is_show = true;

    #[Validate('required|boolean')]
    public bool $is_active = true;

    public function set(Area $area): void
    {
        $this->area = $area;
        $this->district_id = $area->district_id;
        $this->name = $area->name;
        $this->is_promoted = $area->is_promoted;
        $this->is_show = $area->is_show;
        $this->is_active = $area->is_active;
    }

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
                    )
                    ->ignore($this->area->id),
            ],
        ];
    }

    public function submit(Area $area): Area
    {
        return (new AreaService)->update(area: $area, data: $this->validate());
    }
}
