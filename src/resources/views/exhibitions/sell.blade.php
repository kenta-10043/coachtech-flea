@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell__main">
        <div class="sell__contents">
            <h2 class="sell__contents__tittle">商品の出品</h2>

            <form action="{{ route('sell.store') }}" method="post" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="form__input">
                    <label for="image">商品画像</label>
                    <input class="form__input__image" id="image" type="file" name="image">
                </div>

                @error('image')
                    <div class="error-alert">{{ $message }}</div>
                @enderror

                <h2>商品の詳細</h2>


                <div class="item__information">
                    <div class="information__category">
                        <h4 class="item__tittle-category">カテゴリー</h4>

                        @foreach ($categories as $category)
                            <input class="input__category" id="category{{ $loop->index }}" type="checkbox"
                                name="category[]" value="{{ $category->value }}"
                                {{ is_array(old('category', [])) && in_array($category->value, old('category', [])) ? 'checked' : '' }}>
                            <label for="category{{ $loop->index }}">{{ $category->label }}</label>
                        @endforeach

                        @error('category')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form__input">
                        <label for="condition">商品の状態</label>
                        <select name="condition" id="condition">
                            <option value="1"></option>
                            <option value="1"></option>
                            <option value="1"></option>
                            <option value="1"></option>
                        </select>
                    </div>
                </div>

                <h2>商品名と説明</h2>

                <div class="item__name-description">
                    <div class="form__input">
                        <label for="name">商品名</label>
                        <input class="form__input__name" id="name" type="text" name="name"
                            value="{{ old('name') }}" placeholder="商品名を入力">


                        @error('name')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form__input">
                        <label for="brand_name">ブランド名</label>
                        <input class="form__input__name" id="brand_name" type="text" name="brand_name"
                            value="{{ old('brand_name') }}" placeholder="ブランド名を入力">

                        @error('brand_name')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form__input">
                        <label for="description">商品の説明</label>
                        <textarea class="form__input__description" id="description" name="description" cols="30" rows="10"
                            placeholder="商品の説明を入力">{{ old('description') }}</textarea>


                        @error('description')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form__input">
                        <label for="price">販売価格</label>
                        <input class="form__input__price" id="price" type="text" name="price"
                            value="￥{{ old('price') }}" placeholder="販売価格を入力">

                        @error('price')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__button">
                    <button class='submit__button__register' type="submit">出品する</button>

                </div>
            </form>
        </div>
    </div>
@endsection
