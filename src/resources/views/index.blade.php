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
    <div class="index__content__tab">
        <a class="recommendation__tab {{ request('tab') === 'recommendation' ? 'on' : '' }}"
            href="{{ route('index', array_merge(request()->all(), ['tab' => 'recommendation'])) }}">おすすめ</a>
        <a class="mylist__tab {{ request('tab') === 'mylist' ? 'on' : '' }}"
            href="{{ route('index', array_merge(request()->all(), ['tab' => 'mylist'])) }}">マイリスト</a>
    </div>
    @if (request('tab') === 'mylist' && !auth()->check())
        <p>マイリスト閲覧にはログインが必要です</p>
    @endif

    <div class="item__container">
        @if ($items->isEmpty())
        @else
            @foreach ($items as $item)
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
    </div>
@endsection
