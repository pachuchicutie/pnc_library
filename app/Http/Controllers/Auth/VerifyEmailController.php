<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }
        
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            activity('Verify Email')->by($request->user)->event('verify email')->withProperties(['ip_address' => $request->ip()])->log('Verify Email Successful');
        }
        

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
