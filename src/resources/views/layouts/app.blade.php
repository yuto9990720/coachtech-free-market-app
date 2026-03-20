<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="{{ route('items.index') }}" class="header__logo">
                <span class="header__logo-text">coachtechフリマ</span>
            </a>

            @if (!request()->routeIs('login') && !request()->routeIs('register'))
            <form action="{{ route('items.index') }}" method="GET" class="header__search">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="なにをお探しですか？"
                    class="header__search-input"
                >
                @if(request('tab'))
                    <input type="hidden" name="tab" value="{{ request('tab') }}">
                @endif
            </form>

            <nav class="header__nav">
                @auth
                    <form action="/logout" method="POST" class="header__logout-form">
                        @csrf
                        <button type="submit" class="header__nav-link header__nav-link--btn">ログアウト</button>
                    </form>
                    <a href="{{ route('profile.index') }}" class="header__nav-link">マイページ</a>
                @else
                    <a href="{{ route('login') }}" class="header__nav-link">ログイン</a>
                @endauth
                <a href="{{ route('exhibition.create') }}" class="header__nav-btn">出品する</a>
            </nav>
            @endif
        </div>
    </header>

    <main class="main">
        @if (session('success'))
            <div class="alert alert--success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert--error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
