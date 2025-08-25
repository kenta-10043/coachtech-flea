@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <h3>商品の購入</h3>

    <form action="route('profile.buy' )" method:"post">
        @csrf
        <div class="purchase__content">

            <div class="purchase__content__information">

                <div>
                    <input type="hidden" name="item_image">
                    <img class="item__image" src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}">

                    <input type="hidden" name="item_name">
                    <p>{{ $item->item_name }} </p>

                    <input type="hidden" name="price">
                    <P>{{ '￥' . number_format($item->price) }}</P>

                    <input type="hidden" name="status" value="2">

                </div>

                <h4>配送先</h4>
                <a href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>
                <p>{{ '〒' . ($user->orders()->latest()->first()?->shopping_postal_code ?? $user->profile->postal_code) }}
                </p>
                <p>{{ $user->orders()->latest()->first()?->shopping_address ?? $user->profile->address }} </p>
                <p>{{ $user->orders()->latest()->first()?->shopping_building ?? $user->profile->building }} </p>
            </div>

            <div class="purchase__content__pay-information">
                <button>購入する</button>

            </div>



        </div>
    @endsection
