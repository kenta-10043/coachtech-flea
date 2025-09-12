<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_required()
    {
        $response = $this->withoutMiddleware()->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }

    public function test_email_is_required()
    {
        $response = $this->withoutMiddleware()->post('/register', [
            'name' => 'Ken',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_email_must_be_valid_email()
    {
        $response = $this->withoutMiddleware()->post('/register', [
            'name' => 'Ken',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionHasErrors(['email' => 'メールアドレスはメール形式で入力してください']);
    }

    public function test_password_is_required()
    {
        $response = $this->withoutMiddleware()->post('/register', [
            'name' => 'Ken',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_password_min_length()
    {
        $response = $this->withoutMiddleware()->post('/register', [
            'name' => 'Ken',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);
        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function test_password_must_be_confirmed()
    {
        $response = $this->withoutMiddleware()->post('/register', [
            'name' => 'Ken',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);
        $response->assertSessionHasErrors(['password' => 'パスワードと一致しません']);
    }

    public function test_register_with_valid_data()
    {
        $response = $this->withoutMiddleware()->post('/register', [
            'name' => 'Ken',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect('/email/verify');
    }
}
