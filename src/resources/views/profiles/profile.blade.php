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
        <div>
            <a href="{{ route('profile.sell') }}">出品した商品</a>
            <a href="{{ route('profile.buy') }}">購入した商品</a>
        </div>

        <div class="item__container">
            @if (request()->query('page') === 'sell')
                @foreach ($sellItems as $item)
                    <a class="item__link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
                        <div class="item__cards">
                            <img class="item__cards__image" src="{{ 'storage/' . $item->item_image }}"
                                alt="{{ $item->item_name }}">
                            <p class="item__cards__name">{{ $item->item_name }} </p>
                        </div>
                    </a>
                @endforeach
            @elseif (request()->query('page') === 'buy')
                @foreach ($buyItems as $item)
                    <a class="item__link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
                        <div class="item__cards">
                            <img class="item__cards__image" src="{{ 'storage/' . $item->item_image }}"
                                alt="{{ $item->item_name }}">
                            <p class="item__cards__name">{{ $item->item_name }} </p>
                        </div>
                    </a>
                @endforeach
            @else
                @foreach ($items as $item)
                    <a class="item__link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
                        <div class="item__cards">
                            <img class="item__cards__image" src="{{ 'storage/' . $item->item_image }}"
                                alt="{{ $item->item_name }}">
                            <p class="item__cards__name">{{ $item->item_name }} </p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection
