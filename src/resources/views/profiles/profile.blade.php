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
        <div class="profile__content__page">
            <a class="page__sell{{ request('page') === 'sell' ? ' on' : '' }}"
                href="{{ route('profile.index', ['page' => 'sell']) }}">出品した商品</a>
            <a class="page__buy{{ request('page') === 'buy' ? ' on' : '' }}"
                href="{{ route('profile.index', ['page' => 'buy']) }}">購入した商品</a>
            <a class="page__transaction{{ request('page') === 'transaction' ? ' on' : '' }}"
                href="{{ route('profile.index', ['page' => 'transaction']) }}">取引中の商品</a>
        </div>
        <div class="item__container">
            @if (request()->query('page') === 'sell' || !request()->query('page'))
                @foreach ($sellItems as $item)
                    <a class="item__link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
                        <div class="item__cards">
                            <img class="item__cards__image" src="{{ asset('storage/' . $item->item_image) }}"
                                alt="{{ $item->item_name }}">
                            <div class="item__card__description">
                                <p class="item__cards__name">{{ $item->item_name }} </p>
                                @if ($item->status === \App\Enums\Status::SOLD->value)
                                    <span
                                        class="item__status-alert">{{ \App\Enums\Status::from($item->status)->label() }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
            @if (request()->query('page') === 'buy' || !request()->query('page'))
                @foreach ($buyItems as $item)
                    <a class="item__link" href="{{ route('item.show', ['item_id' => $item->item->id]) }}">
                        <div class="item__cards">
                            <img class="item__cards__image" src="{{ asset('storage/' . $item->item->item_image) }}"
                                alt="{{ $item->item->item_name }}">
                            <p class="item__cards__name">{{ $item->item->item_name }} </p>
                            @if ($item->item->status === \App\Enums\Status::SOLD->value)
                                <span
                                    class="item__status-alert">{{ \App\Enums\Status::from($item->item->status)->label() }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            @endif

            @if (request()->query('page') === 'transaction')
                @foreach ($transactionItems as $item)
                    <a class="item__link" href="{{ route('chat.index', ['item_id' => $item->id]) }}">
                        <div class="item__cards">
                            <img class="item__cards__image" src="{{ asset('storage/' . $item->item_image) }}"
                                alt="{{ $item->item_name }}">
                            <p class="item__cards__name">{{ $item->item_name }} </p>
                            @if ($item->status === \App\Enums\Status::SOLD->value)
                                <span
                                    class="item__status-alert">{{ \App\Enums\Status::from($item->status)->label() }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
@endsection
