<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;


class PurchaseController extends Controller
{
    public function show(Item $item)
    {
        $user = Auth::user();

        return view('purchase.show', compact('item', 'user'));
    }

    public function store(Request $request, Item $item)
    {
        // ログイン必須
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 支払い方法のバリデーション
        $request->validate([
            'payment_method' => 'required',
        ]);

        // 商品を「購入済み」にする
        $item->update([
            'is_sold' => true,
            'buyer_id' => auth()->id(),
        ]);

        // 商品一覧へリダイレクト
        return redirect()->route('items.index');
    }

}
