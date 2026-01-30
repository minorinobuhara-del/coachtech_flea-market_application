@extends('layouts.app2')

@section('content')
<title>商品一覧</title>
<div class="tab-menu">
    <span class="tab {{ $tab === 'recommend' ? 'active' : '' }}" onclick="location.href='/?tab=recommend'">
    おすすめ</span>

    <span class="tab {{ $tab === 'favorite' ? 'active' : '' }}" onclick="location.href='/?tab=favorite'">マイリスト</span>
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
            </div>
            <p class="item-name">{{ $item->name }}</p>
        </a>
    @empty
        <p class="no-result">該当する商品が見つかりませんでした</p>
    @endforelse
</div>
@endsection
