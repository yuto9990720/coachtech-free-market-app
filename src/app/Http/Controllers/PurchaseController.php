<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    // PG06: 商品購入画面
    public function index(Item $item)
    {
        if ($item->is_sold) {
            return redirect()->route('items.index')->with('error', 'この商品はすでに売り切れです。');
        }

        $user = Auth::user();

        // セッションに一時住所があれば優先、なければプロフィールの住所
        $address = Session::get("purchase_address_{$item->id}", [
            'postal_code' => $user->postal_code,
            'address'     => $user->address,
            'building'    => $user->building,
        ]);

        return view('purchase.index', compact('item', 'address'));
    }

    // 購入処理
    public function store(PurchaseRequest $request, Item $item)
    {
        if ($item->is_sold) {
            return redirect()->route('items.index')->with('error', 'この商品はすでに売り切れです。');
        }

        $user    = Auth::user();
        $address = Session::get("purchase_address_{$item->id}", [
            'postal_code' => $user->postal_code,
            'address'     => $user->address,
            'building'    => $user->building,
        ]);

        // コンビニ払いはStripeをスキップして直接購入完了
        if ($request->payment_method === 'convenience') {
            self::completePurchase($item, $request->payment_method, $address);
            Session::forget("purchase_address_{$item->id}");
            return redirect()->route('items.index')->with('success', '購入が完了しました！');
        }

        // カード払いはStripeへ
        if ($request->payment_method === 'card') {
            Session::put("pending_purchase_{$item->id}", [
                'payment_method' => $request->payment_method,
                'postal_code'    => $address['postal_code'],
                'address'        => $address['address'],
                'building'       => $address['building'] ?? null,
            ]);

            $checkoutUrl = route('stripe.checkout', $item);
            return response()->view('purchase.stripe_redirect', [
                'checkoutUrl' => $checkoutUrl,
            ]);
        }

        return redirect()->route('items.index');
    }

    public static function completePurchase(Item $item, string $paymentMethod, array $address): void
    {
        Purchase::create([
            'user_id'        => Auth::id(),
            'item_id'        => $item->id,
            'payment_method' => $paymentMethod,
            'postal_code'    => $address['postal_code'],
            'address'        => $address['address'],
            'building'       => $address['building'] ?? null,
        ]);

        $item->update(['is_sold' => true]);
    }
}