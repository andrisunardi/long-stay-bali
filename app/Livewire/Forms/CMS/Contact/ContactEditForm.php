<?php

namespace App\Livewire\Forms\CMS\Contact;

use App\Enums\Property\PropertyBedroom;
use App\Enums\Property\PropertyRentalType;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactEditForm extends Form
{
    public Contact $contact;

    public string $code = '';

    #[Validate('required|string|min:1|max:50')]
    public string $name = '';

    #[Validate('required|string|min:1|max:25')]
    public string $first_name = '';

    #[Validate('nullable|string|min:1|max:25')]
    public ?string $last_name = '';

    #[Validate('nullable|string|min:1|max:50')]
    public string $company = '';

    #[Validate('required|email:rfc,dns|min:1|max:50')]
    public string $email = '';

    #[Validate('required|string|min:1|max:20')]
    public string $phone = '';

    #[Validate('nullable|integer|exists:areas,id')]
    public ?string $area_id = '';

    #[Validate(['nullable', 'integer', new Enum(PropertyBedroom::class)])]
    public ?int $bedroom = null;

    #[Validate(['nullable', 'integer', new Enum(PropertyRentalType::class)])]
    public ?int $rental_type = null;

    #[Validate('nullable|string|min:1|max:1000')]
    public string $message = '';

    public function set(Contact $contact): void
    {
        $this->contact = $contact;
        $this->code = $contact->code;
        $this->name = $contact->name;
        $this->first_name = $contact->first_name;
        $this->last_name = $contact->last_name;
        $this->company = $contact->company;
        $this->email = $contact->email;
        $this->phone = $contact->phone;
        $this->area_id = $contact->area_id;
        $this->bedroom = $contact->bedroom?->value ?? null;
        $this->rental_type = $contact->rental_type?->value ?? null;
        $this->message = $contact->message;
    }

    public function rules(): array
    {
        return [
            'code' => "nullable|string|min:20|max:20|unique:contacts,code,{$this->contact->id}",
            'email' => "required|rfc,dns|min:1|max:50|unique:contacts,email,{$this->contact->id}",
            'phone' => "required|string|min:1|max:20|unique:contacts,phone,{$this->contact->id}",
        ];
    }

    public function submit(Contact $contact): Contact
    {
        return (new ContactService)->update(contact: $contact, data: $this->validate());
    }
}
