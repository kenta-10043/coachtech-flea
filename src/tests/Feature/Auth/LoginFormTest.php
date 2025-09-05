<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginFormTest extends TestCase
{
    use RefreshDatabase;


    public function test_email_is_required()
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_email_is_email()
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'メールアドレスはメール形式で入力してください']);
    }

    public function test_password_is_required()
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_password_is_min_length()
    {
        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'test@example.com',
            'password' => 'short',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function test_login_with_valid_data()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->withoutMiddleware()->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(route('profile.create'));
    }
}

// 'email' => 'required|email',
//             'password' => 'required|min:8',
