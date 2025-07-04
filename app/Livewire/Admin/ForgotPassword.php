<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Livewire\Component;
use Illuminate\Auth\Passwords\PasswordBroker;

class ForgotPassword extends Component
{
    
    public string $email = '';
    
    public function render()
    {
        return view('livewire.admin.forgot-password');
    }

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);
        // $this->only('email') returns an array of the email field
    
        $user = Admin::where('email', $this->email)->first();

        if ($user) {
            $user->sendPasswordResetNotification(app(PasswordBroker::class)->createToken($user));
            session()->flash('status', __('A reset link will be sent if the account exists.'));
        }
        else {
            session()->flash('status', __('No account found for that email address.'));
        }
    }
}
