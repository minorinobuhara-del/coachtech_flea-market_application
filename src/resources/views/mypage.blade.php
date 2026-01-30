@extends('layouts.app2')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@section('content')
<div class="mypage-container">

    {{-- プロフィール情報 --}}
    <div class="profile-header">
        <div class="profile-left">
            @if ($user->profile_image)
                <img class="profile-image" src="{{ asset('storage/' . $user->profile_image) }}">
            @else
                <img class="profile-image" src="{{ asset('images/default-user.png') }}">
            @endif

            <h2 class="username">{{ $user->name }}</h2>
        </div>

        <a href="{{ route('profile.edit') }}" class="edit-profile-btn">
            プロフィールを編集
        </a>
    </div>

    {{-- タブ --}}
    <div class="mypage-tabs">
        <a href="?tab=sell" class="{{ request('tab', 'sell') === 'sell' ? 'active' : '' }}">
            出品した商品
        </a>
        <a href="?tab=buy" class="{{ request('tab') === 'buy' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>

    {{-- 商品一覧 --}}
    <div class="item-grid">
        @if (request('tab', 'sell') === 'sell')
            @forelse ($items as $item)
                <div class="item-card">
                    <img src="{{ asset('storage/' . $item->image_path) }}">
                    <p>{{ $item->name }}</p>
                </div>
            @empty
                <p>出品した商品はありません</p>
            @endforelse
        @else
            <p>購入した商品はありません</p>
        @endif
    </div>

</div>
@endsection
