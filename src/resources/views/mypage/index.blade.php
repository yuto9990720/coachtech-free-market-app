@extends('layouts.app')

@section('content')
<div class="mypage">
    <div class="mypage__profile">
        <div class="mypage__avatar-wrap">
            @if (auth()->user()->profile_image)
                <img src="{{ Storage::url(auth()->user()->profile_image) }}"
                     alt="{{ auth()->user()->name }}"
                     class="mypage__avatar">
            @else
                <div class="mypage__avatar mypage__avatar--default"></div>
            @endif
        </div>
        <div class="mypage__user-info">
            <p class="mypage__username">{{ auth()->user()->name }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn--outline">プロフィールを編集する</a>
        </div>
    </div>

    <nav class="tab-nav">
        <a href="{{ route('profile.index', ['page' => 'sell']) }}"
           class="tab-nav__item {{ $page !== 'buy' ? 'tab-nav__item--active' : '' }}">出品した商品</a>
        <a href="{{ route('profile.index', ['page' => 'buy']) }}"
           class="tab-nav__item {{ $page === 'buy' ? 'tab-nav__item--active' : '' }}">購入した商品</a>
    </nav>

    <div class="items-grid">
        @if ($page === 'buy')
            @forelse ($purchasedItems as $item)
                <a href="{{ route('items.show', $item) }}" class="item-card">
                    <div class="item-card__image-wrap">
                        @if (str_starts_with($item->image, 'http'))
                            <img src="{{ $item->image }}" alt="{{ $item->name }}" class="item-card__image">
                        @else
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="item-card__image">
                        @endif
                        <span class="item-card__sold">Sold</span>
                    </div>
                    <p class="item-card__name">{{ $item->name }}</p>
                </a>
            @empty
                <p class="items-empty">購入した商品はありません。</p>
            @endforelse
        @else
            @forelse ($soldItems as $item)
                <a href="{{ route('items.show', $item) }}" class="item-card">
                    <div class="item-card__image-wrap">
                        @if (str_starts_with($item->image, 'http'))
                            <img src="{{ $item->image }}" alt="{{ $item->name }}" class="item-card__image">
                        @else
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="item-card__image">
                        @endif
                        @if ($item->is_sold)
                            <span class="item-card__sold">Sold</span>
                        @endif
                    </div>
                    <p class="item-card__name">{{ $item->name }}</p>
                </a>
            @empty
                <p class="items-empty">出品した商品はありません。</p>
            @endforelse
        @endif
    </div>
</div>
@endsection
