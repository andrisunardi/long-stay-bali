<?php

namespace App\Livewire\CMS\Login;

use App\Livewire\Component;
use App\Livewire\Forms\CMS\LoginForm;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class LoginPage extends Component
{
    public LoginForm $form;

    public bool $passwordVisibility = false;

    public function mount(): void
    {
        if (Auth::check()) {
            // $this->flash('info', trans('index.login_failed'), [
            //     'html' => trans('index.you_already_login'),
            // ]);

            $this->redirectIntended(route('cms.index'), navigate: true);
        }
    }

    public function changePasswordVisibility(): void
    {
        $this->passwordVisibility = ! $this->passwordVisibility;
    }

    public function submit(): void
    {
        $result = $this->form->submit();

        if ($result) {
            // $this->flash('success', trans('index.login_success'), [
            //     'html' => trans('index.login_has_been_successfully'),
            // ]);

            $this->redirectIntended(route('cms.index'), navigate: true);

            return;
        }

        // $this->alert('error', trans('index.login_failed'), [
        //     'html' => trans('index.username_or_password_is_invalid'),
        // ]);
    }

    public function render(): View
    {
        return view('livewire.cms.login.index');
    }
}
