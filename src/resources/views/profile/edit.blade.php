@extends('layouts.app2')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

@section('content')
<body>
<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="avatar">
        {{-- プレビュー表示用 --}}
        <img id="avatarPreview" class="avatar-circle" src="{{ $user->profile_image? asset('storage/' . $user->profile_image): asset('images/default-user.png') }}" alt="プロフィール画像">

        {{-- ファイル選択 --}}
        <label class="avatar-btn">
        画像を選択する
        <input type="file" name="profile_image" id="profileImage" accept=".jpg,.jpeg,.png" hidden>
        </label>
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}">
            @error('postcode')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}">
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button type="submit" class="btn-update">更新する</button>
    </form>
</div>
</body>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('profileImage');
    const preview = document.getElementById('avatarPreview');

    input.addEventListener('change', () => {
        if (input.files.length === 0) return;

        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = e => {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(file);
    });
});
</script>
@endsection
