@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ 'css/login.css' }}">
@endsection

@section('content')
    <div class="login__container">
        <h2>ログイン</h2>
        <form action="/login" method="post" novalidate>
            @csrf
            <div class="login__form">
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
            <button class="login__button" type="submit">ログインする</button>
        </form>
        <a class="link__register" href="/register">会員登録はこちら</a>
    </div>
@endsection
