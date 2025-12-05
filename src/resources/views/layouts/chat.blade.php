<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="user-id" content="{{ auth()->id() }}">
    <script>
        window.userId = document.querySelector('meta[name="user-id"]').content;
    </script>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chats/chat.css') }}">
    @yield('css')

</head>

<body data-item-id="{{ $item->id }}">

    <header class="main-header">
        <nav class="header__nav">
            <a href="{{ route('index') }}"><img class="title" src="{{ asset('storage/others/logo.svg') }}"
                    alt="ロゴ"></a>
        </nav>
    </header>
    <div class="container">
        <div class="side__content">
            <h2 class="side__content__title">その他の取引</h>
                @foreach ($transactionItems as $transactionItem)
                    <a class='chat__link'
                        data-form-id="unreadForm-id-{{ $transactionItem->id }}"href="{{ route('chat.index', [$transactionItem->id]) }}">
                        <form id="unreadForm-id-{{ $transactionItem->id }}"
                            action="{{ route('chat.readIn', ['item_id' => $transactionItem->id]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $transactionItem->id }}">
                        </form>
                        <p class="chat__link__name">{{ $transactionItem->item_name }}</p>
                    </a>
                @endforeach
        </div>
        <div class="main__content">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/list_unread_badge.js') }}"></script>
</body>

</html>
