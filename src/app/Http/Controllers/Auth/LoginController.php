<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 入力チェック
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 認証
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'email' => 'ログイン情報が登録されていません',
            ])->withInput();
        }

        // 成功時
        $request->session()->regenerate();
        return redirect('/mypage');
    }
}
