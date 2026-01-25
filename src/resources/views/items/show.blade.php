@extends('layouts.app2')

@section('content')
<title>商品詳細（ログイン前）</title>

<div class="item-detail">
    {{-- 左：商品画像 --}}
    <div class="item-detail-image">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="">
    </div>

    {{-- 右：商品情報 --}}
    <div class="item-detail-info">
        <h2 class="item-title">{{ $item->name }}</h2>
        <p class="brand">{{ $item->brand }}</p>
        <p class="price">¥{{ number_format($item->price) }} <span>(税込)</span></p>

        {{-- いいね・コメント --}}
        <div class="icon-area">
            <div class="icon-box">
                <img src="{{ asset('images/icon_heart_.png') }}" alt="いいね">
            </div>
            <div class="icon-box">
                <img src="{{ asset('images/fukidashi-logo.png') }}" alt="コメント">
            </div>
        </div>

        <button class="purchase-btn">購入手続きへ</button>

        <h3>商品説明</h3>
        <p>{{ $item->description }}</p>

        <h3>商品の情報</h3>
        <p>カテゴリー：{{ $item->category->name ?? '未設定' }}</p>
        <p>商品の状態：{{ $item->condition }}</p>
        {{-- コメント欄 --}}
        <div class="comment-section">
        <h3 class="comment-title">コメント</h3>

    {{-- 既存コメント --}}
        <div class="comment-item">
        <div class="comment-user">
            <div class="user-icon"></div>
            <span class="user-name">admin</span>
        </div>
        <p class="comment-body">こちらにコメントが入ります。</p>
        </div>

    {{-- コメント入力 --}}
        <div class="comment-form">
        <label>商品へのコメント</label>
        <textarea rows="4"></textarea>
        <button class="comment-btn">コメントを送信する</button>
        </div>
</div>

    </div>
</div>
@endsection
