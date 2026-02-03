@extends('layouts.app2')

@section('content')
<div class="purchase-wrapper">

    <!-- 左 -->
    <div class="purchase-main">

        <div class="purchase-item">
            <div class="purchase-image">
                <img src="{{ asset('storage/'.$item->image_path) }}">
            </div>

            <div class="purchase-info">
                <p class="item-name">{{ $item->name }}</p>
                <p class="item-price">¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <hr>

        <div class="purchase-section">
            <h3>支払い方法</h3>
            <select name="payment_method" form="purchase-form">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ支払い</option>
                <option value="card">カード支払い</option>
            </select>
        </div>

        <hr>

        <div class="purchase-section">
            <h3>配送先 <a href="/mypage/profile" class="change-link">変更する</a></h3>
            <p>〒{{ $user->postcode }}</p>
            <p>{{ $user->address }}</p>
        </div>
    </div>

    <!-- 右 -->
    <div class="purchase-side">
        <div class="purchase-summary">
            <div class="row">
                <span>商品代金</span>
                <span>¥{{ number_format($item->price) }}</span>
            </div>
            <div class="row">
                <span>支払い方法</span>
                <span id="payment-text">未選択</span>
            </div>
        </div>

        <form id="purchase-form" method="POST" action="{{ route('purchase.store', $item) }}">
            @csrf
            <button class="purchase-btn">購入する</button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.querySelector('select[name="payment_method"]').addEventListener('change', function () {
    document.getElementById('payment-text').textContent =
        this.options[this.selectedIndex].text;
});
</script>
@endpush
