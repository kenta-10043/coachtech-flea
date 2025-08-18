@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="profile__container">
        <img class="profile__image" src="{{ asset('storage/' . $user->profile->profile_image) }}" alt="{{ $user->name }}">

        <div class="profile__user-name">
            <p>{{ $user->name }} </p>
        </div>

        <button class="button__edit" onclick="location.href='{{ route('profile.create') }}'">プロフィールを編集</button>



    </div>
@endsection
