<?php

namespace App\Livewire\Forms\CMS\Login;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string|min:1|max:50|exists:users,username')]
    public string $username = '';

    #[Validate('required|string|min:1|max:50')]
    public string $password = '';

    #[Validate('nullable|boolean')]
    public bool $remember = false;

    public function set(): void
    {
        $this->reset();
    }

    public function submit(): bool
    {
        $this->validate();

        return Auth::attempt(
            [
                'username' => $this->username,
                'password' => $this->password
            ],
            $this->remember,
        );
    }
}
