@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="item-data__container">
        <img class="item__image" src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}">

        <div class="item-data__inner">
            <div>
                <h2 class="item__name">{{ $item->item_name }} </h2>
                <h5 class="Brand__name">{{ $item->brand_name }}</h5>
                @if ($item->status === \App\Enums\Status::SOLD->value)
                    <span class="item__status-alert">{{ \App\Enums\Status::from($item->status)->label() }}</span>
                @endif
                <p class="item__price">{{ '￥' . number_format($item->price) }}（税込）</p>

                <div class="item__reactions">
                    <div>
                        @auth
                            <form class="like__form" action="{{ route('item.like', ['item_id' => $item->id]) }}" method="post">
                                @csrf
                                <button class="like__button{{ $isLiked ? 'liked' : '' }}" type="submit">
                                    <img src="{{ asset('storage/others/星アイコン8.png') }}" alt="星のアイコン">
                                </button>
                            </form>
                            <p class="likes__count">{{ $item->likes_count }}</p>
                        @endauth
                    </div>
                    <div>
                        @guest
                            <form class="like__form" action="{{ route('item.like', ['item_id' => $item->id]) }}"
                                method="post">
                                @csrf
                                <button class="like__button" type="submit">
                                    <img src="{{ asset('storage/others/星アイコン8.png') }}" alt="星のアイコン">
                                </button>
                            </form>
                            <p class="likes__count">{{ $item->likes_count }}</p>
                        @endguest
                    </div>

                    <div class="comment__icon">
                        <img src="{{ asset('storage/others/ふきだしのアイコン.jpg') }}" alt="ふきだしのアイコン">
                        <p class="comments__count">{{ $item->comments_count }}</p>
                    </div>
                </div>

                @if ($item->status !== 2)
                    <div>
                        <button class="purchase__button"
                            onclick="location.href='{{ route('purchase.order', ['item_id' => $item->id]) }}'">購入手続きへ</button>
                    </div>
                @else
                    <p class="purchased-alert">この商品は完売しました</p>
                @endif
            </div>

            <div>
                <h3>商品説明</h3>
                <p class="item__description">{{ $item->description }} </p>
            </div>

            <div class="item__information">
                <div class="information__category">
                    <h4 class="item__tittle-category">カテゴリー</h4>
                    @foreach ($item->categories as $category)
                        <p class="item__category">{{ $category->label }} </p>
                    @endforeach
                </div>
            </div>

            <div class="item__information">
                <div class="information__condition">
                    <h4 class="item__tittle-condition">商品の状態</h4>
                    <p class="item__condition">{{ $item->condition->label }} </p>
                </div>
            </div>

            <div>
                <h3>コメント({{ $item->comments_count }} )</h3>
                <ul class="comment__list">
                    @foreach ($item->comments as $comment)
                        <li><img class="profile_images"
                                src="{{ asset('storage/' . $comment->user->profile->profile_image) }}"
                                alt="{{ $comment->user->name }}">
                            <p>{{ $comment->user->name }} </p>
                            <p class="comment__content">{{ $comment->comment }} </p>
                        </li>
                    @endforeach
                </ul>

                <form action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="post">
                    @csrf
                    <label for="comment">商品へのコメント</label><br>
                    <textarea class="comment__input" id="comment" name="comment" cols="30" rows="10"
                        placeholder="こちらへコメントを入力してください"></textarea>

                    <button class="comment__button" type="submit">コメントを送信する</button>
                </form>
                @error('comment')
                    <div class="error-alert">{{ $message }}</div>
                @enderror

            </div>


        </div>


    </div>
@endsection
