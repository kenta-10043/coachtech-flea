<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin=User::create([
            'name'=>'Admin',
            'email'=>'admin@example.com',
            'password'=>Hash::make('password00000'),
            'role'=>'admin',
            'email_verified_at'=>now(),
            'profile_completed'=>1,
            'remember_token'=>null,
        ]);
        $admin=([
            'profile_image'=> '/profile_images/default.png',
            'postal_code' => '123-4567',
            'address' => 'sample_address',
        ]);

        $user=User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password00000'),
            'role' => 'user',
            'email_verified_at' => now(),
            'profile_completed' => 1,
            'remember_token' => null,
        ]);
        $user->profile()->create([
            'profile_image' => '/profile_images/default.png',
            'postal_code' => '123-4567',
            'address' => 'sample_address',
        ]);
    }
}
