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
        <a class="recommendation__tab" href="{{ route('index') }}">おすすめ</a>
        <a class="mylist__tab" href="{{ route('index', array_merge(request()->all(), ['tab' => 'mylist'])) }}">マイリスト</a>
    </div>
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
                                <span class="item__status-alert">{{ \App\Enums\Status::from($item->status)->label() }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
@endsection
