<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user01 = User::create([
            'name' => 'user01',
            'email' => 'user01@example.com',
            'password' => Hash::make('password01'),
            'role' => 'user',
            'email_verified_at' => now(),
            'profile_completed' => 1,
            'remember_token' => null,
        ]);
        $user01->profile()->create([
            'profile_image' => '/profile_images/default.png',
            'postal_code' => '123-4567',
            'address' => 'sample_address01',
        ]);

        $user02 = User::create([
            'name' => 'user02',
            'email' => 'user02@example.com',
            'password' => Hash::make('password02'),
            'role' => 'user',
            'email_verified_at' => now(),
            'profile_completed' => 1,
            'remember_token' => null,
        ]);
        $user02->profile()->create([
            'profile_image' => '/profile_images/default.png',
            'postal_code' => '321-4567',
            'address' => 'sample_address02',
        ]);

        Item::whereIn('id', [1, 2, 3, 4, 5])->update([
            'user_id' => $user02->id,
        ]);

        $user03 = User::create([
            'name' => 'user03',
            'email' => 'user03@example.com',
            'password' => Hash::make('password03'),
            'role' => 'user',
            'email_verified_at' => now(),
            'profile_completed' => 1,
            'remember_token' => null,
        ]);
        $user03->profile()->create([
            'profile_image' => '/profile_images/default.png',
            'postal_code' => '231-4567',
            'address' => 'sample_address03',
        ]);

        Item::whereIn('id', [6, 7, 8, 9, 10])->update([
            'user_id' => $user03->id,
        ]);
    }
}
