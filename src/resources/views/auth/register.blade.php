@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ 'css/register.css' }}">
@endsection

@section('content')
    <h2>会員登録</h2>

    <form action="/register" method="post" novalidate>
        @csrf
        <div>
            <label for="name">ユーザー名</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}">
        </div>
        <div class="error">
            @error('name')
                【 {{ $message }}】
            @enderror
        </div>

        <div>
            <label for="email">メールアドレス</label>
            <input id="email" type="text" name="email" value="{{ old('email') }}">
        </div>

        <div class="error">
            @error('email')
                【 {{ $message }}】
            @enderror
        </div>

        <div>
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password">
        </div>

        <div class="error">
            @error('password')
                【 {{ $message }}】
            @enderror
        </div>

        <div>
            <label for="password_confirmation">確認用パスワード</label>
            <input id="password_confirmation" type="password" name="password_confirmation">
        </div>

        <div class="error">
            @error('password')
                【 {{ $message }}】
            @enderror
        </div>

        <button type="submit">登録する</button>
    </form>
    <a href="/login">ログインはこちら</a>
@endsection
