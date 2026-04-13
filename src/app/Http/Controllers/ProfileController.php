<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // PG09: プロフィール画面
    public function index()
    {
        $user           = Auth::user();
        $page           = request()->query('page', 'sell');
        $soldItems      = $user->items()->with('purchase')->get();
        $purchasedItems = $user->purchases()->with('item')->get()->pluck('item');

        return view('mypage.index', compact('user', 'page', 'soldItems', 'purchasedItems'));
    }

    // PG10: プロフィール編集画面
    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->only(['name', 'postal_code', 'address', 'building']);

        // プロフィール画像のアップロード処理
        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            // 古い画像を削除
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // 新しい画像を保存
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image'] = $path;
        }

        $user->fill($data);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'プロフィールを更新しました。');
    }
}