@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="address__container">
        <h3>住所の変更</h3>
        <form action="{{ route('address.update', ['item_id' => $item->id]) }}" method="post">
            @method('put')
            @csrf
            <div class="address__form">
                <label class="input__label" for="shopping_postal_code">郵便番号</label>
                <input class="input__shopping-postal-code" id="shopping_postal_code" type="text"
                    name="shopping_postal_code"
                    value="{{ old('shopping_postal_code', $order->shopping_postal_code ?? $profile->postal_code) }}">

                @error('shopping_postal_code')
                    <div class="error-alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="address__form">
                <label class="input__label" for="shopping_address">住所</label>
                <input class="input__shopping-address" id="shopping_address" type="text" name="shopping_address"
                    value="{{ old('shopping_address', $order->shopping_address ?? $profile->address) }}">

                @error('shopping_address')
                    <div class="error-alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="address__form">
                <label class="input__label" for="shopping_building">建物名</label>
                <input class="input__shopping-building" id="shopping_building" type="text" name="shopping_building"
                    value="{{ old('shopping_building', $order->shopping_building ?? $profile->building) }}">

                @error('shopping_building')
                    <div class="error-alert">{{ $message }}</div>
                @enderror
            </div>

            <button class='update__button' type="submit">更新する</button>

        </form>
    </div>
@endsection
