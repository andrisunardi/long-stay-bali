<?php

namespace App\Livewire\Forms\Contact;

use App\Models\Contact;
use App\Services\ContactService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactSubmitForm extends Form
{
    #[Validate('nullable|string|min:1|max:50')]
    public string $name = '';

    #[Validate('required|email:rfc,dns|min:1|max:50|unique:contacts,email')]
    public string $email = '';

    #[Validate('required|string|min:1|max:20|unique:contacts,phone')]
    public string $phone = '';

    #[Validate('required|string|min:1|max:1000')]
    public string $message = '';

    public function submit(): Contact
    {
        return (new ContactService)->create(data: $this->validate());
    }
}
