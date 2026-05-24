<?php

namespace App\Livewire\Forms\Property;

use App\Enums\Property\PropertyRentalType;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ListYourPropertyForm extends Form
{
    #[Validate('required|string|min:1|max:50')]
    public string $name = '';

    #[Validate('required|email:rfc,dns|min:1|max:50|unique:contacts,email')]
    public string $email = '';

    #[Validate('required|string|min:1|max:20|unique:contacts,phone')]
    public string $phone = '';

    #[Validate(['required', 'integer', new Enum(PropertyRentalType::class)])]
    public ?int $rental_type = null;

    #[Validate('required|string|min:1|max:65535')]
    public string $description = '';

    #[Validate('nullable|string|min:1|max:65535')]
    public string $google_maps_url = '';

    public function submit(): Property
    {
        return (new PropertyService)->list(data: $this->validate());
    }
}
