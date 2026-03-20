<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // PG09 / PG11 / PG12: プロフィール画面
    public function index()
    {
        $user = Auth::user();
        $page = request()->query('page', 'sell');

        $soldItems     = $user->items()->with('purchase')->get();
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

        if ($request->hasFile('profile_image')) {
            // 旧画像削除
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.index')->with('success', 'プロフィールを更新しました。');
    }
}
