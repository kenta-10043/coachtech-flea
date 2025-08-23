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
    <div>
        <a href="{{ route('profile.index') }}">出品した商品</a>

        <div class="item__container">
            @foreach ($items as $item)
                @if ($item->user_id == auth()->id())
                    <a class="item__link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
                        <div class="item__cards">
                            <img class="item__cards__image" src="{{ 'storage/' . $item->item_image }}"
                                alt="{{ $item->item_name }}">
                            <p class="item__cards__name">{{ $item->item_name }} </p>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
@endsection
