{{-- resources/views/items/sell.blade.php --}}
@extends('layouts.app2')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@section('content')
<div class="sell-container">
    <h1 class="sell-title">商品の出品</h1>
    @if ($errors->any())
    <div class="error-box">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-section">
            <label class="section-label">商品画像</label>

        <div class="image-upload">
        {{-- プレビュー表示 --}}
        <img id="imagePreview" class="image-preview" src="{{ asset('images/no-image.png') }}"
            alt="商品画像">

        {{-- 画像選択 --}}
        <label class="image-upload-box">
            <span>画像を選択する</span>
            <input type="file" name="image" id="imageInput" accept=".jpg,.jpeg,.png" hidden>
        </label>
        </div>
        </div>

        {{-- 商品の詳細 --}}
        <div class="form-section">
            <h2 class="section-title">商品の詳細</h2>

            {{-- カテゴリー --}}
            <label class="section-label">カテゴリー</label>
            <div class="category-list">
                @foreach (['ファッション','家電','インテリア','レディース','メンズ','コスメ','本','ゲーム','スポーツ','キッチン','ハンドメイド','アクセサリー','おもちゃ','ベビー・キッズ'] as $category)
                    <label class="category-item">
                        <input type="radio" name="category" value="{{ $category }}">
                        <span>{{ $category }}</span>
                    </label>
                @endforeach
            </div>

            {{-- 商品の状態 --}}
            <label class="section-label">商品の状態</label>
            <select name="condition" class="select-box">
                <option value="">選択してください</option>
                <option value="新品">新品</option>
                <option value="未使用に近い">未使用に近い</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
            </select>
        </div>

        {{-- 商品名と説明 --}}
        <div class="form-section">
            <h2 class="section-title">商品名と説明</h2>

            <label class="section-label">商品名</label>
            <input type="text" name="name" class="input-box" value="{{ old('name') }}">
            @error('name')
            <p class="error-text">{{ $message }}</p>
            @enderror

            <label class="section-label">ブランド名</label>
            <input type="text" name="brand" class="input-box" value="{{ old('brand') }}">
            @error('brand')
            <p class="error-text">{{ $message }}</p>
            @enderror

            <label class="section-label">商品の説明</label>
            <textarea name="description" class="textarea-box">{{ old('description') }}</textarea>
            @error('description')
            <p class="error-text">{{ $message }}</p>
            @enderror

            <label class="section-label">販売価格</label>
            <div class="price-box">
                <span>¥</span>
                <input type="number" name="price" value="{{ old('price') }}">
                @error('price')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="submit-btn">出品する</button>
    </form>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');

    input.addEventListener('change', () => {
        if (!input.files.length) return;

        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = e => {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(file);
    });
});
</script>

