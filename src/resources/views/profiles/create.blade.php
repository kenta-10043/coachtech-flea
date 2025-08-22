@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
    <h2>プロフィール設定</h2>

    <form action="{{ route('profile.create') }}" method="post" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="form__input">
            <img class="profile__image" src="{{ asset('storage/' . $user->profile->profile_image) }}"
                alt="{{ $user->name }}">
            <label for="image"></label>
            <input class="form__input__image" id="image" type="file" name="profile_image">
        </div>

        @error('image')
            <div class="error-alert">{{ $message }}</div>
        @enderror

        <div class="form__input">
            <label for="name">ユーザー名</label>
            <input class="form__input__name" id="name" type="text" name="name" value="{{ $user->name }}">
        </div>

        @error('name')
            <div class="error-alert">{{ $message }}</div>
        @enderror

        <div class="form__input">
            <label for="postal_code">郵便番号</label>
            <input class="form__input__postal" id="postal_code" type="text" name="postal_code"
                value="{{ $user->profile->postal_code ?? '' }}">
        </div>

        @error('postal_code')
            <div class="error-alert">{{ $message }}</div>
        @enderror

        <div class="form__input">
            <label for="address">住所</label>
            <input class="form__input__address" id="address" type="text" name="address"
                value="{{ $user->profile->address ?? '' }}">
        </div>

        @error('address')
            <div class="error-alert">{{ $message }}</div>
        @enderror

        <div class="form__input">
            <label for="building">建物名</label>
            <input class="form__input__building" id="building" type="text" name="building"
                value="{{ $user->profile->building ?? '' }}">
        </div>

        @error('building')
            <div class="error-alert">{{ $message }}</div>
        @enderror


        <button class='submit__button__register' type="submit">更新する</button>



    </form>
@endsection
