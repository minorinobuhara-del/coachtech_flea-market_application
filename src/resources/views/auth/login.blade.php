@extends('layouts.app')

@section('content')
<body>
    <div class="auth-header">
        <img src="{{ asset('images/auth-header.png') }}" alt="COACHTECH">
    </div>
<div class="auth-container">
    <h2>ログイン</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label>メールアドレス</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <label>パスワード</label>
        <input type="password" name="password">
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        @if ($errors->has('auth'))
            <p class="error">{{ $errors->first('auth') }}</p>
        @endif

        <button type="submit">ログインする</button>
    </form>

    <a href="{{ route('register') }}">会員登録はこちら</a>
</div>
</body>
@endsection
