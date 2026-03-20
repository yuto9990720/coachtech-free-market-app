<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExhibitionController extends Controller
{
    // PG08: 商品出品画面
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('items.sell', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'user_id'      => Auth::id(),
            'condition_id' => $request->condition_id,
            'name'         => $request->name,
            'brand'        => $request->brand,
            'description'  => $request->description,
            'price'        => $request->price,
            'image'        => $path,
        ]);

        $item->categories()->attach($request->category_ids);

        return redirect()->route('items.index')->with('success', '商品を出品しました！');
    }
}
