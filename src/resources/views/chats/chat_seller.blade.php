@extends('layouts.chat')

@section('title', '取引チャット画面（出品者）')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/chats/chat_seller.css') }}">
@endsection

@section('content')
    <div class="profile__container">
        <div class="profile__container__inner">
        <img class="profile__image" src="{{ asset('storage/' . $buyerUser->profile->profile_image) }}"
            alt="{{ $buyerUser->name }}">
        </div>
        <p class="main__content__title">{{ $buyerUser->name }}さんとの取引画面</p>

        @if ($item->ratings->contains('reviewer_id', $item->buyer_id))
            <button id="btuOpen" class="button-open">取引を終了する</button>
        @else
            <button id="btnDisabled" class="button-disabled">取引を終了する</button>
        @endif

        {{-- モーダル部分 --}}
        <div id="myModal" class="modal">
            <div class="modal__content">

                <div class="modal__content__item">
                    <p class="modal__content__title">取引完了しました。</p>
                </div>

                <form action="{{ route('rating.review', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <div>
                        <p class="modal__content__content" id="content">今回の取引相手はどうでしたか？</p>
                    </div>
                    <div class="star__box" id="star-box">
                        <p class="star" data-score=1>★</p>
                        <p class="star" data-score=2>★</p>
                        <p class="star" data-score=3>★</p>
                        <p class="star" data-score=4>★</p>
                        <p class="star" data-score=5>★</p>
                    </div>
                    <input type="hidden" name="rating" id="rating">
                    <input type="hidden" name="transaction_status" value="3">
                    <div class="review__button__area">
                        <button class="review__button" type="submit">送信する</button>
                    </div>
                </form>
            </div>
        </div>

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
                            <form action="{{ route('chat.update', ['chat_id' => $allMessage->id]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <textarea class="chat__body" name="body" cols="30" rows="1">{{ old('body', $allMessage->body) }}</textarea>
                                <div class="chat__body__items">
                                    @foreach ($allMessage->chatImages as $image)
                                        <a class="chat__body__link"
                                            href="{{ asset('storage/' . $image->chat_image) }}"><img class="image-icon"
                                                src="{{ asset('storage/others/写真のフリーアイコン5 (1).png') }}" alt="写真アイコン"></a>
                                    @endforeach
                                    <button type="submit">編集</button>
                                </div>
                            </form>
                            <form action="{{ route('chat.destroy', ['chat_id' => $allMessage->id]) }}" method="POST">
                                @method('delete')
                                @csrf
                                <button class="delete__button" type="submit">削除</button>
                            </form>
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
        <div>
            {{ $allMessages->links() }}
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
    </div>








@endsection
