@extends('layouts.auth')

@section('content')
<div class="auth">
    <h1 class="auth__title">会員登録</h1>

    <form action="/register" method="POST" class="auth__form">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">ユーザー名</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                class="form-input @error('name') form-input--error @enderror"
            >
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">メールアドレス</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                class="form-input @error('email') form-input--error @enderror"
            >
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">パスワード</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-input @error('password') form-input--error @enderror"
            >
            @error('password')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">確認用パスワード</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-input @error('password_confirmation') form-input--error @enderror"
            >
            @error('password_confirmation')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn--primary btn--full">登録する</button>
    </form>

    <p class="auth__link">
        <a href="{{ route('login') }}">ログインはこちら</a>
    </p>
</div>
@endsection