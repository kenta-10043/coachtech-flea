@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ 'css/login.css' }}">
@endsection

@section('content')
    <h2>会員登録</h2>

    <form action="/login" method="post" novalidate>
        @csrf


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



        <button type="submit">ログインする</button>
    </form>
    <a href="/register">会員登録はこちら</a>
@endsection
