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
        <ul class="header__nav">
            @if (Auth::check())
                <li><a href="{{ route('index') }}"><img class="title" src="{{ asset('storage/others/logo.svg') }}"
                            alt="ロゴ"></a></li>


                <form action="{{ route('item.search') }}" method="get">
                    <li>
                        <input class="input__search" type="text" name="keyword" value="{{ $keyword ?? '' }}"
                            placeholder="　　　　　なにをお探しですか？　　　　　">
                    </li>
                </form>



                <li>
                    <form action="/logout" method="post">
                        @csrf
                        <button class="button__logout">ログアウト</button>
                    </form>
                </li>

                <li>
                    <form action="{{ route('profile.index') }}" method="get">
                        @csrf
                        <button class="button__mypage">マイページ</button>
                    </form>
                </li>

                <li>
                    <form action="" method="get">
                        <button class="button__exhibition">出品</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('index') }}"><img class="title" src="{{ asset('storage/others/logo.svg') }}"
                            alt="ロゴ"></a></li>

                <li>
                    <form action="{{ route('item.search') }}" method="get">
                        <input class="input__search" type="text" name="keyword" value="{{ $keyword ?? '' }}"
                            placeholder="　　　　　なにをお探しですか？　　　　　">
                    </form>
                </li>

                <li>
                    <button onclick="location.href='/login'" class="button__login">ログイン</button>
                </li>

                <li>
                    <form action="/login" method="post">
                        @csrf
                        <button type="button" class="button__mypage">マイページ</button>
                    </form>
                </li>

                <li>
                    <form action="" method="post">
                        @csrf
                        <button class="button__exhibition">出品</button>
                    </form>
                </li>
            @endif

        </ul>
    </header>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
