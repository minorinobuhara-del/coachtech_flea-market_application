<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //マイページ（プロフィール画面）
    public function mypage()
    {
        $user = auth()->user()->load('sellingItems');

        return view('mypage', compact('user'));
    }

    // プロフィール編集画面
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }
    
    // プロフィール更新処理
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'postcode' => 'required|string|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string',
            'building' => 'nullable|string',
            'profile_image' => 'nullable|image',
        ]);

        $user = auth()->user();

        // 画像保存
        if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')
                        ->store('profiles', 'public');
        $user->profile_image = $path;
        }

        $user->fill($request->only([
        'name',
        'postcode',
        'address',
        'building',
    ]));
        $user->profile_completed = true;
        $user->save();

        return redirect()->route('mypage');
    }
}
