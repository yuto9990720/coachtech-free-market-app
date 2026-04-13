@extends('layouts.auth')

@section('content')
<div class="verify-page">
    <p class="verify-page__text">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert--success" style="margin-bottom: 24px;">認証メールを再送信しました。</div>
    @endif

    <div class="verify-page__actions">
        <a href="{{ route('verification.send') }}"
           class="btn btn--outline-dark"
           style="min-width: 240px; padding: 16px 40px; font-size: 1rem;"
           onclick="event.preventDefault(); document.getElementById('resend-form-main').submit();">
            認証はこちらから
        </a>

        <form id="resend-form-main" action="{{ route('verification.send') }}" method="POST" style="display:none;">
            @csrf
        </form>

        <form action="{{ route('verification.send') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="verify-page__resend">
                認証メールを再送する
            </button>
        </form>
    </div>
</div>
@endsection