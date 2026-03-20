<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

// PG01 / PG02: 商品一覧（トップ画面）
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// PG03: 会員登録画面（Fortify が /register を担当）
// PG04: ログイン画面（Fortify が /login を担当）

// PG05: 商品詳細画面
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

// 認証必須ルート
Route::middleware(['auth', 'verified'])->group(function () {

    // PG06: 商品購入画面
    Route::get('/purchase/{item}', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');

    // PG07: 送付先住所変更画面
    Route::get('/purchase/address/{item}', [AddressController::class, 'edit'])->name('address.edit');
    Route::post('/purchase/address/{item}', [AddressController::class, 'update'])->name('address.update');

    // PG08: 商品出品画面
    Route::get('/sell', [ExhibitionController::class, 'create'])->name('exhibition.create');
    Route::post('/sell', [ExhibitionController::class, 'store'])->name('exhibition.store');

    // PG09 / PG11 / PG12: プロフィール画面
    Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');

    // PG10: プロフィール編集画面
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // いいね機能
    Route::post('/like/{item}', [LikeController::class, 'toggle'])->name('like.toggle');

    // コメント送信
    Route::post('/comment/{item}', [CommentController::class, 'store'])->name('comment.store');

    // Stripe決済
    Route::post('/stripe/checkout/{item}', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
});
