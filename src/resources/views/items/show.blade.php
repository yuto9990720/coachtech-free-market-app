@extends('layouts.app')

@section('content')
<div class="item-detail">
    {{-- 左側：商品画像 --}}
    <div class="item-detail__image-wrap">
        @if (str_starts_with($item->image, 'http'))
            <img src="{{ $item->image }}" alt="{{ $item->name }}" class="item-detail__image">
        @else
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="item-detail__image">
        @endif
    </div>

    {{-- 右側：商品情報 --}}
    <div class="item-detail__info">
        <h1 class="item-detail__name">{{ $item->name }}</h1>

        @if ($item->brand)
            <p class="item-detail__brand">{{ $item->brand }}</p>
        @endif

        <p class="item-detail__price">
            ¥{{ number_format($item->price) }}
            <span class="item-detail__price-tax">(税込)</span>
        </p>

        {{-- いいね・コメント数 --}}
        <div class="item-detail__actions">
            <button
                id="like-btn"
                class="like-btn {{ $isLiked ? 'like-btn--active' : '' }}"
                data-item-id="{{ $item->id }}"
                @guest disabled @endguest
            >
                @if ($isLiked)
                    <img src="{{ asset('images/heart_pink.png') }}" alt="いいね" class="like-btn__icon">
                @else
                    <img src="{{ asset('images/heart_default.png') }}" alt="いいね" class="like-btn__icon">
                @endif
                <span id="like-count">{{ $item->likes->count() }}</span>
            </button>

            <div class="comment-count">
                <img src="{{ asset('images/comment.png') }}" alt="コメント" class="comment-count__icon">
                <span>{{ $item->comments->count() }}</span>
            </div>
        </div>

        {{-- 購入ボタン --}}
        @if (!$item->is_sold)
            @auth
                <a href="{{ route('purchase.index', $item) }}" class="btn btn--primary btn--full">購入手続きへ</a>
            @else
                <a href="{{ route('login') }}" class="btn btn--primary btn--full">購入手続きへ</a>
            @endauth
        @else
            <button class="btn btn--disabled btn--full" disabled>売り切れ</button>
        @endif

        {{-- 商品説明 --}}
        <div class="item-detail__section">
            <h2 class="item-detail__section-title">商品説明</h2>
            <p class="item-detail__description">{{ $item->description }}</p>
        </div>

        {{-- 商品の情報 --}}
        <div class="item-detail__section">
            <h2 class="item-detail__section-title">商品の情報</h2>
            <table class="item-info-table">
                <tr>
                    <th class="item-info-table__label">カテゴリー</th>
                    <td class="item-info-table__value">
                        @foreach ($item->categories as $category)
                            <span class="tag">{{ $category->name }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th class="item-info-table__label">商品の状態</th>
                    <td class="item-info-table__value">{{ $item->condition->name }}</td>
                </tr>
            </table>
        </div>

        {{-- コメント --}}
        <div class="item-detail__section">
            <h2 class="comment-section-title">コメント（{{ $item->comments->count() }}）</h2>

            <div class="comment-list">
                @foreach ($item->comments as $comment)
                    <div class="comment">
                        <div class="comment__user">
                            @if ($comment->user->profile_image)
                                <img src="{{ Storage::url($comment->user->profile_image) }}"
                                     alt="{{ $comment->user->name }}"
                                     class="comment__avatar">
                            @else
                                <div class="comment__avatar--default"></div>
                            @endif
                            <span class="comment__username">{{ $comment->user->name }}</span>
                        </div>
                        <p class="comment__content">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>

            @auth
                <p class="comment-form-label">商品へのコメント</p>
                <form action="{{ route('comment.store', $item) }}" method="POST" class="comment-form">
                    @csrf
                    <textarea
                        id="content"
                        name="content"
                        rows="5"
                        class="form-input form-textarea @error('content') form-input--error @enderror"
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="btn btn--primary btn--full">コメントを送信する</button>
                </form>
            @else
                <p class="auth-notice">
                    コメントするには<a href="{{ route('login') }}">ログイン</a>が必要です。
                </p>
            @endauth
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const likeBtn = document.getElementById('like-btn');
    if (!likeBtn || likeBtn.disabled) return;

    likeBtn.addEventListener('click', function () {
        const itemId = this.dataset.itemId;
        const token  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/like/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('like-count').textContent = data.count;
            const icon = likeBtn.querySelector('.like-btn__icon');
            if (data.liked) {
                likeBtn.classList.add('like-btn--active');
                icon.src = '{{ asset("images/heart_pink.png") }}';
            } else {
                likeBtn.classList.remove('like-btn--active');
                icon.src = '{{ asset("images/heart_default.png") }}';
            }
        });
    });
});
</script>
@endsection