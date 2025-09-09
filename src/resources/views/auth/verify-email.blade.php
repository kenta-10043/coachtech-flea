<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">


</head>

<body>
    <header class="main-header">
        <form class="header__nav" action="/logout" method="post">
            @csrf
            <button class="button__logout"><img class="title" src="{{ asset('storage/others/logo.svg') }}"
                    alt="ロゴ"></a></button>
        </form>
    </header>

    <div class="container">
        <div class="mail-message__contents">
            <div>
                <span class="send-message">登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</span>
                <button onclick="location.href='http://localhost:8025'">認証はこちらから</button>
            </div>

            <div>
                <form action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <button class="verification-send" type="submit">認証メールを再送する</button>
                </form>
            </div>
        </div>

    </div>


</body>

</html>
