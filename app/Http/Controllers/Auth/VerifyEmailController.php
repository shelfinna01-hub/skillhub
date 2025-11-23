<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController 
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->hasVerifiedEmail()) {
            return $this->redirectBasedOnRole($user, '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->redirectBasedOnRole($user, '?verified=1');
    }

    /**
     * Redirect user based on their role.
     */
    private function redirectBasedOnRole($user, string $query = ''): RedirectResponse
    {
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false).$query);
        } elseif ($user->role === 'peserta') {
            return redirect()->intended(route('peserta.dashboard', absolute: false).$query);
        }

        return redirect('/');
    }
}
