@extends('layouts.auth')

@section('content')
<div class="auth">
    <h1 class="auth__title">ログイン</h1>

    <form action="/login" method="POST" class="auth__form">
        @csrf

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

        @if ($errors->has('email') && str_contains($errors->first('email'), '登録されていません'))
            <span class="form-error">ログイン情報が登録されていません</span>
        @endif

        <button type="submit" class="btn btn--primary btn--full">ログインする</button>
    </form>

    <p class="auth__link">
        <a href="{{ route('register') }}">会員登録はこちら</a>
    </p>
</div>
@endsection