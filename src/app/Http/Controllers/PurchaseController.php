<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\PurchaseAddress;
use Stripe\Stripe;
use Stripe\PaymentIntent;


class PurchaseController extends Controller
{
    public function show(Item $item)
    {
        $user = Auth::user();

        $address = PurchaseAddress::where('user_id', $user->id)
        ->where('item_id', $item->id)
        ->first();

        // Stripe APIキー設定
        Stripe::setApiKey(config('services.stripe.secret'));

        // PaymentIntent 作成
        $intent = PaymentIntent::create([
        'amount' => $item->price, // 購入金額
        'currency' => 'jpy',
    ]);

        return view('purchase.show', [
        'item' => $item,
        'user' => $user,
        'address' => $address,
        'clientSecret' => $intent->client_secret,
    ]);
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        // 商品を「購入済み」にする
        if ($item->buyer_id) {
        return back();
        }
        
        $item->buyer_id = Auth::id();
        $item->is_sold  = true;
        $item->save();

        // 商品一覧へリダイレクト
        return redirect('/mypage?tab=buy');
    }

    public function address(Item $item)
    {
    $user = Auth::user();

    $address = PurchaseAddress::where('user_id', $user->id)
        ->where('item_id', $item->id)
        ->first();

    return view('purchase.address', compact('item', 'address'));
    }

}
