<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
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

        // Stripe決済へリダイレクト（StripeControllerで完了後に購入レコードを作成）
        if (in_array($request->payment_method, ['convenience', 'card'])) {
            Session::put("pending_purchase_{$item->id}", [
                'payment_method' => $request->payment_method,
                'postal_code'    => $address['postal_code'],
                'address'        => $address['address'],
                'building'       => $address['building'] ?? null,
            ]);

            // POSTでStripeへ送信するフォームを自動サブミット
            $checkoutUrl = route('stripe.checkout', $item);
            return response()->view('purchase.stripe_redirect', [
                'checkoutUrl' => $checkoutUrl,
            ]);
        }

        // フォールバック（通常は Stripe へ遷移するため到達しない）
        $this->completePurchase($item, $request->payment_method, $address);

        Session::forget("purchase_address_{$item->id}");
        return redirect()->route('items.index')->with('success', '購入が完了しました！');
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
