@extends('layouts.app')

@section('content')
<div class="profile-edit">
    <h1 class="profile-edit-title">プロフィール設定</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
        @csrf
        @method('POST')

        {{-- プロフィール画像 --}}
        <div class="profile-image-section">
            <div class="profile-image-upload__preview-wrap">
                @if (auth()->user()->profile_image)
                    <img id="profile-preview"
                         src="{{ Storage::url(auth()->user()->profile_image) }}"
                         alt="プロフィール画像"
                         class="profile-image-upload__preview">
                @else
                    <div id="profile-preview-placeholder" class="profile-image-upload__placeholder"></div>
                    <img id="profile-preview" src="" alt="" class="profile-image-upload__preview" style="display:none;">
                @endif
            </div>
            <label for="profile_image" class="btn btn--outline profile-image-upload__btn">
                画像を選択する
                <input type="file" id="profile_image" name="profile_image"
                       accept=".jpeg,.jpg,.png" class="profile-image-upload__input">
            </label>
            @error('profile_image')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="name">ユーザー名</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', auth()->user()->name) }}"
                class="form-input @error('name') form-input--error @enderror"
            >
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="postal_code">郵便番号</label>
            <input
                type="text"
                id="postal_code"
                name="postal_code"
                value="{{ old('postal_code', auth()->user()->postal_code) }}"
                placeholder="123-4567"
                class="form-input @error('postal_code') form-input--error @enderror"
            >
            @error('postal_code')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="address">住所</label>
            <input
                type="text"
                id="address"
                name="address"
                value="{{ old('address', auth()->user()->address) }}"
                class="form-input @error('address') form-input--error @enderror"
            >
            @error('address')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="building">建物名</label>
            <input
                type="text"
                id="building"
                name="building"
                value="{{ old('building', auth()->user()->building) }}"
                class="form-input"
            >
        </div>

        <button type="submit" class="btn btn--primary btn--full">更新する</button>
    </form>
</div>

<script>
document.getElementById('profile_image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
        const preview     = document.getElementById('profile-preview');
        const placeholder = document.getElementById('profile-preview-placeholder');
        if (preview) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
        }
        if (placeholder) {
            placeholder.style.display = 'none';
        }
    };
    reader.readAsDataURL(file);
});
</script>
@endsection