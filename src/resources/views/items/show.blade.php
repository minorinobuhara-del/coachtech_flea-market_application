@extends('layouts.app2')

@section('content')
<title>商品詳細（ログイン前）</title>
<div class="item-detail">
    <div class="item-detail-image">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="">
    </div>

    <div class="item-detail-info">
        <h2>{{ $item->name }}</h2>
        <p class="brand">{{ $item->brand }}</p>
        <p class="price">¥{{ number_format($item->price) }} (税込)</p>

        <button class="purchase-btn">購入手続きへ</button>

        <h3>商品説明</h3>
        <p>{{ $item->description }}</p>

        <h3>商品の情報</h3>
        <p>カテゴリー：{{ $item->category->name }}</p>
        <p>商品の状態：{{ $item->condition }}</p>
    </div>
</div>
@endsection
