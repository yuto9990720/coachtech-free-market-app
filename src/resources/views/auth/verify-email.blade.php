@extends('layouts.auth')

@section('content')
    <div class="auth">
        <h1 class="auth__title">メール認証</h1>

        <p class="auth__description">
            登録したメールアドレスに認証メールを送信しました。<br>
            メール内のリンクをクリックして認証を完了してください。
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert--success">認証メールを再送信しました。</div>
        @endif

        <div class="auth__actions">
            <a href="{{ route('verification.send') }}" class="btn btn--secondary btn--full"
                onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                認証はこちらから
            </a>

            <form id="resend-form" action="{{ route('verification.send') }}" method="POST" style="display:none;">
                @csrf
            </form>

            <form action="/logout" method="POST" class="auth__logout-form">
                @csrf
                <button type="submit" class="btn btn--outline btn--full">ログアウト</button>
            </form>
        </div>
    </div>
@endsection
