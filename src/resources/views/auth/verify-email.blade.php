<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メール認証</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-header">
        <img src="{{ asset('images/auth-header.png') }}" alt="COACHTECH">
    </div>

    <div class="verify-container">
        <p class="verify-text">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        <a href="/profile" class="verify-button" onclick="document.getElementById('verify-form').submit();">
            認証はこちらから
        </a>

        <form id="verify-form" method="POST" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="resend-link">
                認証メールを再送する
            </button>
        </form>
    </div>
</body>
</html>