<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Session;

class AddressController extends Controller
{
    // PG07: 送付先住所変更画面
    public function edit(Item $item)
    {
        $address = Session::get("purchase_address_{$item->id}", [
            'postal_code' => auth()->user()->postal_code,
            'address'     => auth()->user()->address,
            'building'    => auth()->user()->building,
        ]);

        return view('purchase.address', compact('item', 'address'));
    }

    public function update(AddressRequest $request, Item $item)
    {
        Session::put("purchase_address_{$item->id}", [
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ]);

        return redirect()->route('purchase.index', $item);
    }
}
