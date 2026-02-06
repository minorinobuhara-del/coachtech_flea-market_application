@extends('layouts.app2')

@section('content')
<title>商品一覧</title>
<div class="tab-menu">
    <span class="tab {{ request('tab', 'recommend') === 'recommend' ? 'active' : '' }}"
    onclick="location.href='/?tab=recommend'">
    おすすめ
    </span>

    <span class="tab {{ request('tab') === 'favorite' ? 'active' : '' }}"
    onclick="location.href='/?tab=favorite'">
    マイリスト
    </span>
</div>
@if(request('keyword'))
    <p class="search-result">
        「{{ request('keyword') }}」の検索結果
    </p>
@endif

<div class="item-grid">
    @forelse($items as $item)
        <a href="{{ route('items.show', $item) }}" class="item-card">
            <div class="item-image">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="">
                {{-- SOLD表示 --}}
                @if ($item->is_sold)
                    <span class="sold-label">SOLD</span>
                @endif
            </div>

            <p class="item-name">{{ $item->name }}</p>
        </a>
    @empty
    @if ($tab === 'favorite')
        <p>マイリストに商品がありません</p>
    @endif
@endforelse
</div>
@endsection
