<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        /** @var \App\Models\Admin $user or \App\Models\User $user */
        $user = $request->user();
        
        if ($user->hasVerifiedEmail()) {
            if ($user instanceof \App\Models\Admin) {
                return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1&role=admin');
            }
            return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1&role=user');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        if ($user instanceof \App\Models\Admin) {
            return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1&role=admin');
        }
        return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1&role=user');
    }
}
