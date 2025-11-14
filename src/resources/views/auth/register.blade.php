@extends('layouts.auth')
@section('css')
    <link rel="stylesheet" href="{{ 'css/register.css' }}">
@endsection

@section('content')
    <div class="register__container">
        <h2>会員登録</h2>
        <form action="/register" method="post" novalidate>
            @csrf
            <div class="register__form">
                <label class="input__label" for="name">ユーザー名</label>
                <input class="input__name" id="name" type="text" name="name" value="{{ old('name') }}">
                <div class="error-alert">
                    @error('name')
                        【 {{ $message }}】
                    @enderror
                </div>
            </div>
            <div class="register__form">
                <label class="input__label" for="email">メールアドレス</label>
                <input class="input__email" id="email" type="text" name="email" value="{{ old('email') }}">
                <div class="error-alert">
                    @error('email')
                        【 {{ $message }}】
                    @enderror
                </div>
            </div>
            <div class="register__form">
                <label class="input__label" for="password">パスワード</label>
                <input class="input__password" id="password" type="password" name="password">
                <div class="error-alert">
                    @error('password')
                        【 {{ $message }}】
                    @enderror
                </div>
            </div>
            <div class="register__form">
                <label class="input__label" for="password_confirmation">確認用パスワード</label>
                <input class="input__password_confirmation" id="password_confirmation" type="password"
                    name="password_confirmation">
                <div class="error-alert">
                    @error('password')
                        【 {{ $message }}】
                    @enderror
                </div>
            </div>
            <button class="register__button" type="submit">登録する</button>
        </form>
        <a class="link__login" href="/login">ログインはこちら</a>
    </div>
@endsection
