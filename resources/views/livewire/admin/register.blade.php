<div class="flex flex-col gap-6 w-full max-w-md mx-auto absolute top-1/2 left-1/2 -translate-x-1/2 transform  -translate-y-1/2">
    <x-auth-header :title="__('Create Admin account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('admin.login')" wire:navigate>{{ __('Log in') }}</flux:link>
        <br>
        <br>
        <span class="mx-1">or</span>
        <flux:link  :href="route('login')" wire:navigate>{{ __('Log in as user') }}</flux:link>
        <br>
        <br>
        <span class="mx-1">or</span>
        <flux:link :href="route('register')" wire:navigate>{{ __('Register as user') }}</flux:link>
    </div>
</div>
