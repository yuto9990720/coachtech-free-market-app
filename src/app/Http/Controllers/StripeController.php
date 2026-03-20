<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout(Item $item)
    {
        $pendingData = Session::get("pending_purchase_{$item->id}");
        if (!$pendingData) {
            return redirect()->route('purchase.index', $item);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItem = [
            'price_data' => [
                'currency'     => 'jpy',
                'product_data' => [
                    'name' => $item->name,
                ],
                'unit_amount' => $item->price,
            ],
            'quantity' => 1,
        ];

        $paymentMethodType = $pendingData['payment_method'] === 'card'
            ? ['card']
            : ['konbini'];

        $session = StripeSession::create([
            'payment_method_types' => $paymentMethodType,
            'line_items'           => [$lineItem],
            'mode'                 => 'payment',
            'success_url'          => route('stripe.success') . "?item_id={$item->id}",
            'cancel_url'           => route('stripe.cancel') . "?item_id={$item->id}",
            'metadata'             => ['item_id' => $item->id],
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        $itemId = request()->query('item_id');
        $item   = Item::findOrFail($itemId);

        $pendingData = Session::get("pending_purchase_{$itemId}");
        if ($pendingData && !$item->is_sold) {
            \App\Http\Controllers\PurchaseController::completePurchase(
                $item,
                $pendingData['payment_method'],
                $pendingData
            );
            Session::forget("pending_purchase_{$itemId}");
            Session::forget("purchase_address_{$itemId}");
        }

        return redirect()->route('items.index')->with('success', '購入が完了しました！');
    }

    public function cancel()
    {
        $itemId = request()->query('item_id');
        $item   = Item::findOrFail($itemId);
        return redirect()->route('purchase.index', $item)->with('error', '決済がキャンセルされました。');
    }
}
