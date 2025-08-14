<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use App\Http\Responses\RegisterViewResponse as CustomRegisterViewResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        Fortify::registerView(
            function () {
                return view('auth.register');
            }
        );

        Fortify::loginView(
            function () {
                return view('auth.login');
            }
        );

        Fortify::authenticateUsing(function ($request) {
            $loginRequest = app(\App\Http\Requests\LoginRequest::class);
            $loginRequest->merge($request->all());
            $validated = $loginRequest->validated();

            if (\Illuminate\Support\Facades\Auth::attempt([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ])) {
                return \Illuminate\Support\Facades\Auth::user();
            }

            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['ログイン情報が登録されていません'],
                'password' => ['ログイン情報が登録されていません'],
            ]);

            return null;
        });

        RateLimiter::for(
            'login',
            function (Request $request) {
                $email = (string) $request->email;
                return Limit::perMinute(10)->by($email . $request->ip());
            }
        );
    }
}
