<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;


class PurchaseController extends Controller
{
    public function show(Item $item)
    {
        $user = Auth::user();

        return view('purchase.show', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        // 商品を「購入済み」にする
        $item->update([
            'is_sold' => true,
            'buyer_id' => auth()->id(),
        ]);

        // 商品一覧へリダイレクト
        return redirect('/')
            ->with('success', '購入が完了しました');
    }

}
