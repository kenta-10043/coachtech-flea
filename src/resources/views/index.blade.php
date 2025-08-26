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
        <a href=""></a>
    </div>
    <div class="item__container">
        @foreach ($items as $item)
            @if ($item->user_id !== auth()->id())
                <a class="item__link" href="{{ route('item.show', ['item_id' => $item->id]) }}">
                    <div class="item__cards">
                        <img class="item__cards__image" src="{{ 'storage/' . $item->item_image }}"
                            alt="{{ $item->item_name }}">
                        <p class="item__cards__name">{{ $item->item_name }} </p>
                        @if ($item->status === \App\Enums\Status::SOLD->value)
                            <span class="item__status-alert">{{ \App\Enums\Status::from($item->status)->label() }}</span>
                        @endif
                    </div>
                </a>
            @endif
        @endforeach
    </div>
@endsection
