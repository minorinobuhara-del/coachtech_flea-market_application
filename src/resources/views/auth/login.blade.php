<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>

@extends('layouts.app')

@section('content')

    <div class="auth-header">
        <img src="{{ asset('images/auth-header.png') }}" alt="COACHTECH">
    </div>
<div class="auth-container">
    <h2 class="auth-title">ログイン</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
        <label>メールアドレス</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror
        </div>

        <div class="form-group">
        <label>パスワード</label>
        <input type="password" name="password">
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror
        </div>

        @if ($errors->has('auth'))
            <p class="error">{{ $errors->first('auth') }}</p>
        @endif

        <button type="submit" class="btn-register">ログインする</button>
    </form>

    <div class="auth-link">
    <a href="{{ route('register') }}">会員登録はこちら</a>
    </div>
</div>
@endsection
