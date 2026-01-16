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

    <div class="auth-container">
    <h1 class="auth-title">メール認証</h1>
    <p class="auth-text">
        ご登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    @if (session('status') == 'verification-link-sent')
        <p class="success-message">
            認証メールを再送信しました。
        </p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn-register">認証メールを再送信する</button>
    </form>
    </div>
</body>
</html>