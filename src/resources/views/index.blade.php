@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <a href="{{ route('index') }}">おすすめ</a>
        <a href="{{ route('index', array_merge(request()->all(), ['tab' => 'mylist'])) }}">マイリスト</a>
    </div>
    <div class="item__container">

        @if (request()->query('tab') === 'mylist')
            @auth
                @foreach ($items as $item)
                    @if ($item->likes->contains('user_id', $user->id))
                        <a class="item__link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
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
                    @endif
                @endforeach
            @else
            @endauth
        @else
            @foreach ($items as $item)
                @if ($item->user_id !== auth()->id())
                    <a class="item__link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
                        <div class="item__cards">
                            <img class="item__cards__image" src="{{ 'storage/' . $item->item_image }}"
                                alt="{{ $item->item_name }}">
                            <p class="item__cards__name">{{ $item->item_name }} </p>
                            @if ($item->status === \App\Enums\Status::SOLD->value)
                                <span
                                    class="item__status-alert">{{ \App\Enums\Status::from($item->status)->label() }}</span>
                            @endif
                        </div>
                    </a>
                @endif
            @endforeach
        @endif
    </div>
@endsection
