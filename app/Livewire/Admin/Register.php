<?php

namespace App\Livewire\Admin;

use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component
{

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function render()
    {
        return view('livewire.admin.register');
    }

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Admin::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::min(8)->mixedCase()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($admin = Admin::create($validated))));

        Auth::guard('admin')->login($admin);

        $this->redirectIntended(route('admin.verification.notice', absolute: false), navigate: true);

    }
}