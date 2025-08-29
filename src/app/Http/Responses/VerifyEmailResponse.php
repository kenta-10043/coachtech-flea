<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;
use Illuminate\Support\Facades\Auth;

class VerifyEmailResponse implements VerifyEmailResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if (!$user->profile_completed) {
            return redirect()->route('profile.create');
        }

        return redirect()->intended('/');
    }
}
