<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        /** @var \App\Models\Admin $user */
        $user = Auth::guard('admin')->user();

        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('admin.verification.notice');
        }

        return $next($request);
    }
}
