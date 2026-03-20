<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">
    <header class="header">
        <div class="header__inner">
            <a href="{{ route('items.index') }}" class="header__logo">
                <span class="header__logo-text">coachtechフリマ</span>
            </a>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
</body>
</html>
