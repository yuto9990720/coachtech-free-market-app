<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // PG01 / PG02: 商品一覧
    public function index(Request $request)
    {
        $tab    = $request->query('tab', 'all');
        $search = $request->query('search', '');

        if ($tab === 'mylist') {
            // マイリスト：未認証は空表示
            if (!Auth::check()) {
                return view('items.index', [
                    'items'  => collect(),
                    'tab'    => $tab,
                    'search' => $search,
                ]);
            }
            $items = Auth::user()->likedItems()
                ->with(['purchase', 'likes'])
                ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->get();
        } else {
            // 全商品：自分の出品は除外
            $query = Item::with(['purchase', 'likes'])
                ->when(Auth::check(), fn($q) => $q->where('user_id', '!=', Auth::id()))
                ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"));
            $items = $query->get();
        }

        return view('items.index', compact('items', 'tab', 'search'));
    }

    // PG05: 商品詳細
    public function show(Item $item)
    {
        $item->load(['user', 'categories', 'condition', 'comments.user', 'likes']);

        $isLiked = Auth::check()
            ? $item->likes->where('user_id', Auth::id())->isNotEmpty()
            : false;

        return view('items.show', compact('item', 'isLiked'));
    }
}
