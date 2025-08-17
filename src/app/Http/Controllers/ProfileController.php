<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('profile.create', compact('user'));
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
        ]);

        if ($user->profile) {
            $user->profile->update([
                'profile_image' => $request->profile_image,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);
        } else {
            $user->profile()->create([
                'profile_image' => $request->profile_image,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building
            ]);
        }
        $user->load('profile');

        if ($user->profile && $user->profile->postal_code && $user->profile->address) {
            $user->update(['profile_completed' => true]);
        }

        return redirect()->route('index');
    }
}
