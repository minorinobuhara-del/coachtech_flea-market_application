@extends('layouts.app2')

@section('content')
<title>商品詳細</title>

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
            {{-- いいね --}}
        <div class="icon-box">
        <form method="POST" action="{{ route('item.like', $item) }}">
            @csrf
            <button type="submit" class="icon-btn">
                <img src="{{ asset(
                    $item->isLikedBy(auth()->user())
                        ? 'images/icon_heart_pink.png'
                        : 'images/icon_heart_.png'
                ) }}" alt="いいね">
            </button>
        </form>
        <span class="icon-count">{{ $item->likes->count() }}</span>
        </div>
            {{-- コメント --}}
        <div class="icon-box">
        <img src="{{ asset('images/fukidashi-logo.png') }}" alt="コメント">
        <span class="icon-count">{{ $item->comments->count() }}</span>
        </div>

    </div>

        <button class="purchase-btn" onclick="location.href='{{ route('purchase.show', $item) }}'">購入手続きへ</button>

        <h3>商品説明</h3>
        <p>{{ $item->description }}</p>

        <h3>商品の情報</h3>
        <div class="item-info">
        <div class="info-row">
        <span class="info-label">カテゴリー</span>

        <span class="category-tag">
            @if ($item->category)
            {{ $item->category->name }}
        @else
            未設定
        @endif
        </span>
        </div>

        <div class="info-row">
        <span class="info-label">商品の状態</span>
        <span class="info-value">{{ $item->condition }}</span>
        </div>
    </div>
        {{-- コメント欄 --}}
        <div class="comment-section">
        <h3 class="comment-title">コメント</h3>

    {{-- 既存コメント --}}
        @foreach ($item->comments as $comment)
        <div class="comment-item">
        <div class="comment-user">
        <span class="user-name">{{ $comment->user->name }}</span>
        </div>
        <p class="comment-body">{{ $comment->content }}</p>
        </div>
        @endforeach

        {{-- コメント入力 --}}
        <div class="comment-form">
        @if(auth()->check())
        <form method="POST" action="{{ route('item.comment', $item) }}">
        @csrf

            <label>商品へのコメント</label>
            <textarea name="content" rows="4">{{ old('content') }}</textarea>

            @error('content')
                <p class="error">{{ $message }}</p>
            @enderror

            <button class="comment-btn">コメントを送信する</button>
        </form>
        @else
        <p>
            コメントを投稿するには
            <a href="{{ route('login') }}">ログイン</a>
            してください
        </p>
        @endif
</div>
@endsection
