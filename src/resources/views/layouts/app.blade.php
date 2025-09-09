<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')

</head>

<body>
    <header class="main-header">
        <nav class="header__nav">
            @if (Auth::check())
                <a href="{{ route('index') }}"><img class="title" src="{{ asset('storage/others/logo.svg') }}"
                        alt="ロゴ"></a>
                <form class="search__form" action="{{ route('index') }}" method="get">
                    <input class="search__input" type="text" name="keyword" value="{{ $keyword ?? '' }}"
                        placeholder="　　　　　なにをお探しですか？　　　　　">
                </form>
                <div class="link__button">
                    <form action="/logout" method="post">
                        @csrf
                        <button class="button__logout">ログアウト</button>
                    </form>

                    <a class="button__mypage" href="{{ route('profile.index') }}">マイページ</a>
                    <a class="button__exhibition" href="{{ route('sell.index') }}">出品</a>
                </div>
            @else
                <a href="{{ route('index') }}"><img class="title" src="{{ asset('storage/others/logo.svg') }}"
                        alt="ロゴ"></a>

                <form class="search__form" action="{{ route('index') }}" method="get">
                    <input class="search__input" type="text" name="keyword" value="{{ $keyword ?? '' }}"
                        placeholder="　　　　　なにをお探しですか？　　　　　">
                </form>

                <div class="link__button">
                    <button class="button__login" onclick="location.href='/login'">ログイン</button>
                    <a class="button__mypage" href="{{ route('profile.index') }}">マイページ</a>
                    <a class="button__exhibition" href="{{ route('sell.index') }}">出品</a>
                </div>
            @endif

        </nav>
    </header>
    <div class="container">
        @yield('content')
    </div>


</body>

</html>
