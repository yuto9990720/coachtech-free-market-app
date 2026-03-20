<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Item $item)
    {
        $existing = Like::where('user_id', Auth::id())
            ->where('item_id', $item->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create(['user_id' => Auth::id(), 'item_id' => $item->id]);
            $liked = true;
        }

        $count = $item->likes()->count();

        return response()->json(['liked' => $liked, 'count' => $count]);
    }
}
