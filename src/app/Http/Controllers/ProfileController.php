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
        return view('profiles.create', compact('user'));
    }

    public function index()
    {
        $user = Auth::user();
        $sellItems = $user->items()->where('status', 1)->get();
        $buyItems = $user->orders()->whereNotNull('paid_at')->with('item')->get();
        $allItems = $sellItems->concat($buyItems);


        return view('profiles.profile', compact('user', 'sellItems', 'buyItems', 'allItems'));
    }

    public function store(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
        ]);

        $profileDate = [
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ];

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $profileDate['profile_image'] = $profileImagePath;
        }

        if ($user->profile) {
            $user->profile->update($profileDate);
        } else {
            $user->profile()->create($profileDate);
        }
        $user->load('profile');

        if ($user->profile && $user->profile->postal_code && $user->profile->address) {
            $user->update(['profile_completed' => true]);
        }

        return redirect()->route('index')->with('success', 'プロフィールを更新しました');
    }
}
