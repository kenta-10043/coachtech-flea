<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->hasVerifiedEmail()) {
            return redirect('/email/verify');
        }
        if (!$user->profile_completed) {
            return redirect()->route('profile.create');
        }

        return redirect()->intended('/');
    }
}
