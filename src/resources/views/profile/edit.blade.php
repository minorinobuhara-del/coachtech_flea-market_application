@extends('layouts.app2')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@section('content')
<body>
<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="avatar">
            <div class="avatar-circle"></div>
            <label class="avatar-btn">
                画像を選択する
                <input type="file" name="image" hidden>
            </label>
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postcode">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address">
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building">
        </div>

        <button class="btn-update">更新する</button>
    </form>
</div>
</body>
@endsection
