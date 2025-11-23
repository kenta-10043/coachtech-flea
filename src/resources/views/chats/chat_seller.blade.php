@extends('layouts.chat')

@section('title', '取引チャット画面（出品者）')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/chats/chat_seller.css') }}">
@endsection

@section('content')
    <div class="profile__container">
        <img class="profile__image" src="{{ asset('storage/' . $buyerUser->profile->profile_image) }}"
            alt="{{ $buyerUser->name }}">
        <p class="main__content__title">{{ $buyerUser->name }}さんとの取引画面</p>
    </div>

    <div class=item__box>
        <img class="item__image" src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}">
        <div class="item__inner">
            <p class="item__name">{{ $item->item_name }}</p>
            <p class="item__price">￥{{ number_format($item->price) }}</p>
        </div>
    </div>

    <div class="chat__area">
        @foreach ($allMessages as $allMessage)
            <div class="chat__message {{ $allMessage->sender_id == auth()->id() ? 'my-message' : 'partner-message' }}">
                @if ($allMessage->sender_id == auth()->id())
                    <div>
                        <div class="chat__profile__container">
                            <p class="chat__user__name">{{ $allMessage->sender->name }}</p>
                            <img class="chat__profile__image"
                                src="{{ asset('storage/' . $allMessage->sender->profile->profile_image) }}"
                                alt="{{ $sellerUser->name }}">
                        </div>
                        <div class="chat__body__container">
                            <p class="chat__body">{{ $allMessage->body }}</p>
                            @foreach ($allMessage->chatImages as $image)
                                <a href="{{ asset('storage/' . $image->chat_image) }}"><img class="image-icon"
                                        src="{{ asset('storage/others/写真のフリーアイコン5 (1).png') }}" alt="写真アイコン"></a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div>
                        <div class="chat__profile__container__other">
                            <img class="chat__profile__image"
                                src="{{ asset('storage/' . $allMessage->sender->profile->profile_image) }}"
                                alt="{{ $sellerUser->name }}">
                            <p class="chat__user__name">{{ $allMessage->sender->name }}</p>
                        </div>
                        <div class="chat__body__container">
                            <p class="chat__body">{{ $allMessage->body }}</p>
                            @foreach ($allMessage->chatImages as $image)
                                <a href="{{ asset('storage/' . $image->chat_image) }}"><img class="image-icon"
                                        src="{{ asset('storage/others/写真のフリーアイコン5 (1).png') }}" alt="写真アイコン"></a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div>
        <form action="{{ route('chat.send', ['item_id' => $item->id]) }}" id="chat-form" method="POST"
            enctype="multipart/form-data">
            @csrf

            @error('body')
                <p class="alert__message">{{ $message }}</p>
            @enderror
            <div class="input__box">
                <div class="error__alert">
                </div>
                <textarea class="input__textarea" name="body" cols="30" rows="1" id="chat-input"
                    placeholder="取引メッセージを記入してください">{{ old('body') }}</textarea>

                <div class="error__alert">
                    @error('chat_images')
                        <p class="alert__message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="button__box">
                    <label class="input__button__label" for="realFile">画像を追加</label>
                    <input type="file" id="realFile" name="chat_images[]" multiple>
                    <button class="input__button" type="submit"><img class="input__button__image"
                            src="{{ asset('storage/' . 'others/inputbuttun 1.png') }}" alt="インプット画像"></button>
                </div>
            </div>
            <div id="preview-container"></div>

        </form>
    </div>



    <script>
        const realFile = document.getElementById('realFile');
        const previewContainer = document.getElementById('preview-container');

        realFile.addEventListener('change', function() {
            previewContainer.innerHTML = ''; // 初期化

            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.marginRight = '5px';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });

        const input = document.getElementById('chat-input');
        input.value = localStorage.getItem('chat_draft') || '';

        input.addEventListener('input', () => {
            localStorage.setItem('chat_draft', input.value)
        });

        document.getElementById('chat-form').addEventListener('submit', () => {
            localStorage.removeItem('chat_draft');
        });
    </script>

@endsection
