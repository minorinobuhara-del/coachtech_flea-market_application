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

    <form class="search-form">
        <input type="text" placeholder="なにをお探しですか？">
    </form>

    <div class="header-right">
        <a href="/login">ログイン</a>
        <a href="#">マイページ</a>
        <a class="sell-btn" href="#">出品</a>
    </div>
</header>

<main>
    @yield('content')
</main>

</body>
</html>
