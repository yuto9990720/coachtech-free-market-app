@extends('layouts.app')

@section('content')
<div class="items-page">
    <nav class="tab-nav">
        <a
            href="{{ route('items.index', ['search' => $search]) }}"
            class="tab-nav__item {{ $tab !== 'mylist' ? 'tab-nav__item--active' : '' }}"
        >おすすめ</a>
        <a
            href="{{ route('items.index', ['tab' => 'mylist', 'search' => $search]) }}"
            class="tab-nav__item {{ $tab === 'mylist' ? 'tab-nav__item--active' : '' }}"
        >マイリスト</a>
    </nav>

    <div class="items-grid">
        @forelse ($items as $item)
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
            <p class="items-empty">商品がありません。</p>
        @endforelse
    </div>
</div>
@endsection