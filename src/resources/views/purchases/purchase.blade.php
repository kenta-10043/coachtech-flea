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

    <h3>商品の購入</h3>

    <form action="{{ route('purchase.checkout', ['item_id' => $item->id]) }}" method="post">
        @csrf
        <div class="purchase__content">

            <div class="purchase__content__information">

                <div>
                    <img class="item__image" src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}">

                    <p>{{ $item->item_name }} </p>

                    <P>{{ '￥' . number_format($item->price) }}</P>
                    <input type="hidden" name="order_price" value="{{ $item->price }}">
                </div>

                <h4>支払方法</h4>
                <select name="payment_method" id="payment_method">
                    <option value="" disabled selected {{ old('payment_method') ? '' : 'selected' }}>選択してください</option>
                    @foreach ($paymentMethods as $method)
                        <option value="{{ $method->value }}"
                            {{ old('payment_method') == $method->value ? 'selected' : '' }}>
                            {{ $method->label() }}</option>
                    @endforeach
                </select>

                @error('payment_method')
                    <div class="error-alert">{{ $message }}</div>
                @enderror


                <h4>配送先</h4>
                <a href="{{ route('address.edit', ['item_id' => $item->id]) }}">変更する</a>

                <p>〒{{ $postalCode }}</p>
                <input type="hidden" name="shopping_postal_code" value="{{ $postalCode }}">

                <p>{{ $address }} </p>
                <input type="hidden" name="shopping_address" value="{{ $address }}">

                <p>{{ $building }} </p>
                <input type="hidden" name="shopping_building" value="{{ $building }}">
            </div>

            @error('shopping_postal_code')
                <div class="error-alert">{{ $message }}</div>
            @enderror

            @error('shopping_address')
                <div class="error-alert">{{ $message }}</div>
            @enderror

            @error('shopping_building')
                <div class="error-alert">{{ $message }}</div>
            @enderror

            <div class="purchase__content__pay-information">

                <div>
                    <div>
                        <label for="shopping_price">商品代金</label>
                        <p for="shopping_price">￥{{ number_format($item->price) }} </p>
                    </div>

                    <div>
                        <p>支払方法 <span
                                id="selectedPayment">{{ old('payment_method') ? \App\Enums\PaymentMethod::from(old('payment_method'))->label() : $selectedPayment ?? '' }}</span>
                        </p>

                    </div>
                </div>
                <button class="purchase__button" type="submit">購入する</button>

            </div>
        </div>
    </form>

    <script>
        const select = document.getElementById('payment_method');
        const display = document.getElementById('selectedPayment');

        display.textContent = select.options[select.selectedIndex].text;


        select.addEventListener('change', function() {
            const value = this.value;
            const text = this.options[this.selectedIndex].text;
            display.textContent = text;
        });
    </script>
@endsection
