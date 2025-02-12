<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class VerificationController extends Controller
{
    // Display the email verification notice.
    public function notice()
    {
        return view('auth.verify-email');
    }

    // Handle the email verification request.
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('booking');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('booking');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
