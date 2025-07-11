<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Locked;

class ResetPassword extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = 'faisal@howauth.com';
    public string $password = '';
    public string $password_confirmation = '';

    public function render()
    {
        return view('livewire.admin.reset-password');
    }

        /**
     * Mount the component.
     */
    public function mount(string $token , string $email): void
    {   
        
        $this->token = $token;

        $this->email = $email;
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::min(8)->mixedCase()],
        ]);
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        // هنا نحن سوف نحاول إعادة تعيين كلمة المرور لمستخدم اذا كان
        // موجودا في قاعدة البيانات ونقوم بتحديث كلمة المرور
        // ونقوم بحدث الحدث
        //
        $status = Password::broker('admins')->reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PasswordReset) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('admin.login', navigate: true);
    }
}
