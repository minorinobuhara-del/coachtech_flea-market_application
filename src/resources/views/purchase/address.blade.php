@extends('layouts.app2')

@section('content')
<div class="address-wrapper">

    <h2 class="address-title">住所の変更</h2>

    <form method="POST" action="{{ route('purchase.address.update', $item) }}">
        @csrf

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postcode" value="{{ old('postcode', $address->postcode ?? '') }}">
            @error('postcode')
            <p class="address-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $address->address ?? '') }}">
            @error('address')
            <p class="address-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', $address->building ?? '') }}">
            @error('building')
            <p class="address-error">{{ $message }}</p>
            @enderror
        </div>

        <button class="update-btn">更新する</button>
    </form>
</div>
@endsection
