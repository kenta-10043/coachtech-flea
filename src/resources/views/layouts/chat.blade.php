<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chats/chat.css') }}">
    @yield('css')

</head>

<body>
    <header class="main-header">
        <nav class="header__nav">
            <a href="{{ route('index') }}"><img class="title" src="{{ asset('storage/others/logo.svg') }}"
                    alt="ロゴ"></a>
        </nav>
    </header>
    <div class="container">
        <div class="side__content">
            <h2 class="side__content__title">その他の取引</h>
        </div>
        <div class="main__content">
            @yield('content')
        </div>
    </div>
</body>

</html>
