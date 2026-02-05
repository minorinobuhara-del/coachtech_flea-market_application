<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\PurchaseAddress;

class PurchaseAddressController extends Controller
{
    // 住所変更画面表示
    public function edit(Item $item)
    {

        $address = PurchaseAddress::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->first();

        return view('purchase.address', compact('item', 'address'));
    }

    // 住所更新処理
    public function update(AddressRequest $request, Item $item)
    {
        PurchaseAddress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'item_id' => $item->id,
            ],
            [
                'postcode' => $request->postcode,
                'address'  => $request->address,
                'building' => $request->building,
            ]
        );

        return redirect()
            ->route('purchase.show', $item)
            ->with('success', '配送先を変更しました');
    }
}
