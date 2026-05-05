<?php

namespace App\Livewire\Forms\CMS\Contact;

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyRentalType;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactAddForm extends Form
{
    #[Validate('nullable|string|min:20|max:20|unique:contacts,code')]
    public string $code = '';

    #[Validate('required|string|min:1|max:50')]
    public string $name = '';

    #[Validate('required|string|min:1|max:25')]
    public string $first_name = '';

    #[Validate('nullable|string|min:1|max:25')]
    public string $last_name = '';

    #[Validate('required|string|min:1|max:50')]
    public string $company = '';

    #[Validate('required|email:rfc,dns|min:1|max:50|unique:contacts,email')]
    public string $email = '';

    #[Validate('required|string|min:1|max:20|unique:contacts,phone')]
    public string $phone = '';

    #[Validate('nullable|integer|exists:areas,id')]
    public string $area_id = '';

    #[Validate(['nullable', 'integer', new Enum(PropertyBedroom::class)])]
    public ?int $bedroom = null;

    #[Validate(['nullable', 'integer', new Enum(PropertyRentalType::class)])]
    public ?int $rental_type = null;

    #[Validate('nullable|string|min:1|max:1000')]
    public string $message = '';

    public function submit(): Contact
    {
        return (new ContactService)->create(data: $this->validate());
    }
}
