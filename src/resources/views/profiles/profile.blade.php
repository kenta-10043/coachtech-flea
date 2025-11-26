@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    @if ($seedRefreshed)
        <script>
            console.log("DB が初期化されたので localStorage をクリアします");
            localStorage.clear();
        </script>
    @endif
    <div class="profile__container">
        <img class="profile__image" src="{{ asset('storage/' . $user->profile->profile_image) }}" alt="{{ $user->name }}">

        <div class="rating__box">
            <div class="profile__user-name">
                <p class="user-name">{{ $user->name }} </p>
            </div>

            <div class="stars__box" id="stars-box">
                <p class="stars" data-score=1>★</p>
                <p class="stars" data-score=2>★</p>
                <p class="stars" data-score=3>★</p>
                <p class="stars" data-score=4>★</p>
                <p class="stars" data-score=5>★</p>
            </div>
        </div>

        <button class="button__edit" onclick="location.href='{{ route('profile.create') }}'">プロフィールを編集</button>
    </div>
    <div>
        <div class="profile__content__page">
            <a class="page__sell{{ request('page') === 'sell' ? ' on' : '' }}"
                href="{{ route('profile.index', ['page' => 'sell']) }}">出品した商品</a>
            <a class="page__buy{{ request('page') === 'buy' ? ' on' : '' }}"
                href="{{ route('profile.index', ['page' => 'buy']) }}">購入した商品</a>
            <div class="chat-badge__box">
                <a class="page__transaction{{ request('page') === 'transaction' ? ' on' : '' }}"
                    href="{{ route('profile.index', ['page' => 'transaction']) }}">取引中の商品</a>
                <div class="chat-badge" id="chat-badge">0</div>
            </div>
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
                    <div class="item-row" data-item-id="{{ $item->id }}">
                        <p class="item-badge" id="badge-item-{{ $item->id }}">0</p>
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
                    </div>
                @endforeach
            @endif
        </div>
    </div>


@endsection
