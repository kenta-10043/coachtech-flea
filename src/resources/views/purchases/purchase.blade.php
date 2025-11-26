@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    <form action="{{ route('purchase.checkout', ['item_id' => $item->id]) }}" method="post">
        @csrf
        <div class="purchase__content">

            <div class="purchase__content__information">

                <div class="item__card">
                    <img class="item__image" src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}">
                    <div class="item__information">
                        <p class="item-name">{{ $item->item_name }} </p>
                        <P class="item-price">{{ '￥' . number_format($item->price) }}</P>
                        <input type="hidden" name="order_price" value="{{ $item->price }}">
                    </div>
                </div>

                <h4>支払い方法</h4>
                <div class="payment-method__box">
                    <select class="select__payment-method" name="payment_method" id="payment_method">
                        <option value="" disabled selected {{ old('payment_method') ? '' : 'selected' }}>選択してください
                        </option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->value }}"
                                {{ old('payment_method') == $method->value ? 'selected' : '' }}>
                                {{ $method->label() }}</option>
                        @endforeach
                    </select>

                    @error('payment_method')
                        <div class="error-alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="shopping-address__box">
                    <h4>配送先</h4>
                    <a class="address__update-link" href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>
                </div>

                <div class="shopping-address__box__inner">
                    <p>〒{{ $postalCode }}</p>
                    <input type="hidden" name="shopping_postal_code" value="{{ $postalCode }}">

                    <span>{{ $address }} </span>
                    <input type="hidden" name="shopping_address" value="{{ $address }}">

                    <span>{{ $building }} </span>
                    <input type="hidden" name="shopping_building" value="{{ $building }}">


                    @error('shopping_postal_code')
                        <div class="error-alert">{{ $message }}</div>
                    @enderror

                    @error('shopping_address')
                        <div class="error-alert">{{ $message }}</div>
                    @enderror

                    @error('shopping_building')
                        <div class="error-alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="purchase__content__pay-information">

                <div class="subtotal">
                    <div class="shopping-price__content">
                        <label class="shopping-price__label" for="shopping_price">商品代金</label>
                        <p class="shopping-price for="shopping_price">￥{{ number_format($item->price) }} </p>
                    </div>

                    <div>
                        <p class="payment-method">支払方法 <span class="payment-method__select"
                                id="selectedPayment">{{ old('payment_method') ? \App\Enums\PaymentMethod::from(old('payment_method'))->label() : $selectedPayment ?? '' }}</span>
                        </p>

                    </div>
                </div>
                <button class="purchase__button" type="submit">購入する</button>

            </div>
        </div>
    </form>
@endsection
