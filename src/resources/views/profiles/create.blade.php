@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
    <div class="profile__container">
        <h2>プロフィール設定</h2>
        <form action="{{ route('profile.create') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div>
                <img class="profile__image"
                    src="{{ $user->profile?->profile_image ? asset('storage/' . $user->profile->profile_image) : asset('storage/profile_images/default.png') }}"
                    alt="{{ $user->name }}">
                <label for="profile_image"></label>
                <input class="form__input__image" id="profile_image" type="file" name="profile_image">
                <img class="preview__image" id="preview" src="#">
                @error('image')
                    <div class="error-alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="profile__form">
                <label class="input__label" for="name">ユーザー名</label>
                <input class="input__name" id="name" type="text" name="name" value="{{ $user->name }}">
                @error('name')
                    <div class="error-alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="profile__form">
                <label class="input__label" for="postal_code">郵便番号</label>
                <input class="input__postal-code" id="postal_code" type="text" name="postal_code"
                    value="{{ $user->profile->postal_code ?? '' }}">
                @error('postal_code')
                    <div class="error-alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="profile__form">
                <label class="input__label" for="address">住所</label>
                <input class="input__address" id="address" type="text" name="address"
                    value="{{ $user->profile->address ?? '' }}">
                @error('address')
                    <div class="error-alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="profile__form">
                <label class="input__label" for="building">建物名</label>
                <input class="input__building" id="building" type="text" name="building"
                    value="{{ $user->profile->building ?? '' }}">
                @error('building')
                    <div class="error-alert">{{ $message }}</div>
                @enderror
            </div>
            <button class='register__button' type="submit">更新する</button>
        </form>
    </div>

    <script>
        document.getElementById('profile_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = "none";
            }
        });
    </script>
@endsection
