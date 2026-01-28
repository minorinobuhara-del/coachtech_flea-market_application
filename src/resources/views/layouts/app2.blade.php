<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<header class="header">
    <div class="header-left">
        <img src="{{ asset('images/auth-header.png') }}" alt="COACHTECH">
    </div>

    <form class="search-form" method="GET" action="{{ route('items.search') }}">
    <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
</form>

    <div class="header-right">

        {{-- 未ログイン --}}
        @guest
            <a href="/login">ログイン</a>
        @endguest

        {{-- ログイン中 --}}
        @auth
        <a href="#" class="header-link"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            ログアウト
        </a>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>
        @endauth
        <a href="/mypage">マイページ</a>
        <a class="sell-btn" href="#"><font color="#000000">出品</font></a>
    </div>
</header>

<main>
    @yield('content')
</main>

</body>
</html>
