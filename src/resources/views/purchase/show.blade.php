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

    <form id="purchase-form" method="POST" action="{{ route('purchase.store', $item) }}">
    @csrf
        <div class="purchase-section">
            <h3>支払い方法</h3>
            <select name="payment_method" form="purchase-form">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ支払い</option>
                <option value="card">カード支払い</option>
            </select>
            @error('payment_method')
            <p class="error">{{ $message }}</p>
            @enderror

            {{-- カード支払い時のみ表示 --}}
        <div id="card-payment-area" style="display:none; margin-top:16px;">
        <label>カード情報</label>
        <div id="card-element"></div>
        <p id="card-error" class="error"></p>
        </div>
        </div>

        <hr>


        <div class="purchase-section">
            <h3>配送先 <a href="{{ route('purchase.address.edit', $item) }}" class="change-link">変更する</a></h3>
            <p>〒{{ $address->postcode ?? $user->postcode }}</p>
            <p>{{ $address->address ?? $user->address }}</p>
            <p>{{ $address->building ?? $user->building }}</p>

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

            <button type="submit" class="purchase-btn">購入する</button>
    </form>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const select = document.querySelector('select[name="payment_method"]');
    const paymentText = document.getElementById('payment-text');
    const cardArea = document.getElementById('card-payment-area');
    const form = document.getElementById('purchase-form');

    // Stripe 初期化
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    // 支払い方法変更時
    select.addEventListener('change', function () {
        paymentText.textContent = this.options[this.selectedIndex].text;
        cardArea.style.display = this.value === 'card' ? 'block' : 'none';
    });

    // 送信時（カード支払いのみ Stripe 実行）
    form.addEventListener('submit', async function (e) {
        if (select.value !== 'card') return;

        e.preventDefault();

        const { paymentIntent, error } = await stripe.confirmCardPayment(
            "{{ $clientSecret ?? '' }}",
            {
                payment_method: {
                    card: card,
                }
            }
        );

        if (error) {
            document.getElementById('card-error').textContent = error.message;
        } else {
            form.submit();
        }
    });
});
</script>
@endpush
