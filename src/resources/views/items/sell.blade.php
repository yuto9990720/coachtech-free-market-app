@extends('layouts.app')

@section('content')
<div class="sell-page">
    <h1 class="sell-page-title">商品の出品</h1>

    <form action="{{ route('exhibition.store') }}" method="POST" enctype="multipart/form-data" class="sell-form">
        @csrf

        {{-- 商品画像 --}}
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品画像</h2>
            <div class="form-group">
                <label for="image" class="image-upload__label">
                    <div class="image-upload__area" id="image-preview-area">
                        <img id="image-preview" src="" alt="" style="display:none;" class="image-upload__preview">
                        <span id="image-placeholder">
                            <span class="image-upload__placeholder-btn">画像を選択する</span>
                        </span>
                    </div>
                    <input type="file" id="image" name="image" accept=".jpeg,.jpg,.png" class="image-upload__input">
                </label>
                @error('image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- 商品の詳細 --}}
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品の詳細</h2>

            <div class="form-group" style="margin-bottom: 24px;">
                <span class="category-label">カテゴリー</span>
                <div class="category-tags">
                    @foreach ($categories as $category)
                        <label class="category-tag">
                            <input
                                type="checkbox"
                                name="category_ids[]"
                                value="{{ $category->id }}"
                                {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}
                                class="category-tag__input"
                            >
                            <span class="category-tag__label">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('category_ids')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="condition_id">商品の状態</label>
                <select id="condition_id" name="condition_id"
                        class="form-select @error('condition_id') form-input--error @enderror">
                    <option value="">選択してください</option>
                    @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}"
                            {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                    @endforeach
                </select>
                @error('condition_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- 商品名と説明 --}}
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品名と説明</h2>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="name">商品名</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       class="form-input @error('name') form-input--error @enderror">
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="brand">ブランド名</label>
                <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                       class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label" for="description">商品の説明</label>
                <textarea id="description" name="description" rows="6"
                          class="form-input form-textarea @error('description') form-input--error @enderror"
                          >{{ old('description') }}</textarea>
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- 販売価格 --}}
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">販売価格</h2>
            <div class="form-group">
                <label class="form-label" for="price">販売価格</label>
                <div class="price-input-wrap">
                    <span class="price-input-wrap__symbol">¥</span>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" min="0"
                           class="form-input price-input-wrap__input @error('price') form-input--error @enderror">
                </div>
                @error('price')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div style="padding: 40px 0;">
            <button type="submit" class="btn btn--primary btn--full">出品する</button>
        </div>
    </form>
</div>

<script>
document.getElementById('image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
        const preview     = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');
        preview.src       = ev.target.result;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>
@endsection