<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員登録</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>


<div class="auth-header"></div>

<div class="auth-container">
    <h1 class="auth-title">会員登録</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>確認用パスワード</label>
            <input type="password" name="password_confirmation">
        </div>

        <button class="btn-register">登録する</button>
    </form>

    <div class="auth-link">
        <a href="{{ route('login') }}">ログインはこちら</a>
    </div>
</div>
</body>
