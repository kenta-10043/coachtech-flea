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
                <h3>商品画像</h3>
                <div class="form__input-body">
                    <input class="form__input__image" type="file" name="item_image" id="item_image">
                    <img class="preview__image" id="preview" src="#">
                </div>
                @error('item_image')
                    <div class="error-alert">{{ $message }}
                    </div>
                @enderror
                <h2 class="subheading">商品の詳細</h2>
                <div class="item__information">
                    <div class="information__category">
                        <h4 class="item__tittle-category">カテゴリー</h4>
                        @foreach ($categories as $category)
                            <input class="input__category" id="category{{ $loop->index }}" type="checkbox"
                                name="category[]" value="{{ $category->category }}"
                                {{ is_array(old('category', [])) && in_array($category->category, old('category', [])) ? 'checked' : '' }}>
                            <label for="category{{ $loop->index }}">{{ $category->label }}</label>
                        @endforeach
                        @error('category')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <h4 class="item__tittle-condition">商品の状態</h4>
                    <div class="form__input">
                        <label for="condition">
                            <select class="choice__condition" name="condition" id="condition">
                                <option value="" disabled selected {{ old('condition') ? '' : 'selected' }}>選択してください
                                </option>
                                @foreach ($conditions as $condition)
                                    <option value="{{ $condition->condition }}"
                                        {{ old('condition') == $condition->condition ? 'selected' : '' }}>
                                        {{ $condition->label }}</option>
                                @endforeach
                            </select>
                        </label>
                        @error('condition')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <h2 class="subheading">商品名と説明 </h2>
                <div class="item__information-description">
                    <div class="form__input__name">
                        <label class="label__name" for="item_name">商品名</label>
                        <input class="input__name" id="item_name" type="text" name="item_name"
                            value="{{ old('item_name') }}" placeholder="商品名を入力">
                        @error('item_name')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form__input__brand-name">
                        <label class="label__brand-name" for="brand_name">ブランド名</label>
                        <input class="input__brand-name" id="brand_name" type="text" name="brand_name"
                            value="{{ old('brand_name') }}" placeholder="ブランド名を入力">
                    </div>
                    <div class="form__input__description">
                        <label class="label__description" for="description">商品の説明</label>
                        <textarea class="input__description" id="description" name="description" cols="30" rows="10"
                            placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="error-alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form__input__price">
                        <label class="label__price" for="price">販売価格</label>
                        <input class="input__price" id="price" type="text" name="price"
                            value="{{ old('price') }}" placeholder="販売価格を入力">
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
    @vite('resources/js/sell.js')
@endsection
