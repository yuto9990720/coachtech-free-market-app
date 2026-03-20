@extends('layouts.app')

@section('content')
<div class="item-detail">
    <div class="item-detail__image-wrap">
        @if (str_starts_with($item->image, 'http'))
            <img src="{{ $item->image }}" alt="{{ $item->name }}" class="item-detail__image">
        @else
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="item-detail__image">
        @endif
    </div>

    <div class="item-detail__info">
        <h1 class="item-detail__name">{{ $item->name }}</h1>

        @if ($item->brand)
            <p class="item-detail__brand">{{ $item->brand }}</p>
        @endif

        <p class="item-detail__price">
            <span class="item-detail__price-symbol">¥</span>{{ number_format($item->price) }}
            <span class="item-detail__price-tax">（税込）</span>
        </p>

        <div class="item-detail__actions">
            {{-- いいねボタン --}}
            <button
                id="like-btn"
                class="like-btn {{ $isLiked ? 'like-btn--active' : '' }}"
                data-item-id="{{ $item->id }}"
                data-liked="{{ $isLiked ? 'true' : 'false' }}"
                @guest disabled @endguest
            >
                <span class="like-btn__icon">♥</span>
                <span class="like-btn__count" id="like-count">{{ $item->likes->count() }}</span>
            </button>

            {{-- コメント数 --}}
            <div class="comment-count">
                <span class="comment-count__icon">💬</span>
                <span class="comment-count__num" id="comment-count">{{ $item->comments->count() }}</span>
            </div>
        </div>

        @if (!$item->is_sold)
            @auth
                <a href="{{ route('purchase.index', $item) }}" class="btn btn--primary btn--full">購入手続きへ</a>
            @else
                <a href="{{ route('login') }}" class="btn btn--primary btn--full">購入手続きへ</a>
            @endauth
        @else
            <button class="btn btn--disabled btn--full" disabled>売り切れ</button>
        @endif

        <section class="item-detail__section">
            <h2 class="item-detail__section-title">商品説明</h2>
            <p class="item-detail__description">{{ $item->description }}</p>
        </section>

        <section class="item-detail__section">
            <h2 class="item-detail__section-title">商品情報</h2>
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
        </section>

        <section class="item-detail__section">
            <h2 class="item-detail__section-title">
                コメント（<span id="comment-count-title">{{ $item->comments->count() }}</span>）
            </h2>

            <div class="comment-list" id="comment-list">
                @foreach ($item->comments as $comment)
                    <div class="comment">
                        <div class="comment__user">
                            @if ($comment->user->profile_image)
                                <img src="{{ Storage::url($comment->user->profile_image) }}"
                                     alt="{{ $comment->user->name }}" class="comment__avatar">
                            @else
                                <div class="comment__avatar comment__avatar--default"></div>
                            @endif
                            <span class="comment__username">{{ $comment->user->name }}</span>
                        </div>
                        <p class="comment__content">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>

            @auth
                <form action="{{ route('comment.store', $item) }}" method="POST" class="comment-form">
                    @csrf
                    <label class="form-label" for="content">商品へのコメント</label>
                    <textarea
                        id="content"
                        name="content"
                        rows="4"
                        class="form-input form-textarea @error('content') form-input--error @enderror"
                        placeholder="コメントを入力してください"
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="btn btn--secondary btn--full">コメントを送信する</button>
                </form>
            @else
                <p class="auth-notice">
                    コメントするには<a href="{{ route('login') }}">ログイン</a>が必要です。
                </p>
            @endauth
        </section>
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
            if (data.liked) {
                likeBtn.classList.add('like-btn--active');
            } else {
                likeBtn.classList.remove('like-btn--active');
            }
        });
    });
});
</script>
@endsection
